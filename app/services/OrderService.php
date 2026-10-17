<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderStatusHistory;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class OrderService
{
    public function __construct(
        protected CheckoutCalculator $calculator,
        protected OrderNumberGenerator $orderNumberGenerator,
        protected InventoryService $inventoryService,
    ) {}

    /**
     * Create an order from the user's current cart.
     *
     * @param User   $user
     * @param Cart   $cart
     * @param array  $shippingAddress Validated address payload
     * @param array  $options         ['idempotency_key', 'coupon_code', 'customer_note', 'payment_method']
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function createFromCart(
        User $user,
        Cart $cart,
        array $shippingAddress,
        array $options = []
    ): Order {
        // ---------- Idempotency check ----------
        $idempotencyKey = $options['idempotency_key'] ?? null;

        if ($idempotencyKey) {
            $existing = Order::where('user_id', $user->id)
                ->where('idempotency_key', $idempotencyKey)
                ->first();

            if ($existing) {
                // Return the previously created order (idempotent).
                return $existing->load(['items', 'statusHistory']);
            }
        }

        // ---------- Load and validate cart ----------
        $cart->load(['items.product']);

        if ($cart->items->isEmpty()) {
            throw ValidationException::withMessages([
                'cart' => ['Your cart is empty.'],
            ]);
        }

        // ---------- Validate stock for every item ----------
        foreach ($cart->items as $item) {
            $product = $item->product;

            if (!$product || !$product->is_active) {
                throw ValidationException::withMessages([
                    'cart' => [
                        "Product '{$item->product_id}' is no longer available.",
                    ],
                ]);
            }

            if (!$product->allow_backorder && $item->quantity > $product->stock_quantity) {
                throw ValidationException::withMessages([
                    'cart' => [
                        "Insufficient stock for '{$product->name}'. "
                            . "Available: {$product->stock_quantity}, requested: {$item->quantity}.",
                    ],
                ]);
            }
        }

        // ---------- Calculate totals ----------
        $subtotal = round(
            $cart->items->sum(fn($i) => $i->quantity * (float) $i->unit_price),
            2
        );

        $coupon = null;
        if (!empty($options['coupon_code'])) {
            $coupon = Coupon::where('code', $options['coupon_code'])->first();

            if (!$coupon || !$coupon->isValidForAmount($subtotal)) {
                throw ValidationException::withMessages([
                    'coupon_code' => ['This coupon is invalid or has expired.'],
                ]);
            }
        }

        $totals = $this->calculator->calculate($subtotal, $coupon);

        $order = DB::transaction(function () use (
            $user,
            $cart,
            $shippingAddress,
            $options,
            $subtotal,
            $totals,
            $coupon,
            $idempotencyKey
        ) {
            // Lock all products to serialize concurrent checkout.
            $productIds = $cart->items->pluck('product_id')->all();
            $products   = Product::whereIn('id', $productIds)
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            // Re-validate stock after lock.
            foreach ($cart->items as $item) {
                $locked = $products->get($item->product_id);

                if (!$locked || !$locked->is_active) {
                    throw ValidationException::withMessages([
                        'cart' => ["Product {$item->product_id} is no longer available."],
                    ]);
                }

                if (!$locked->allow_backorder && $item->quantity > $locked->stock_quantity) {
                    throw ValidationException::withMessages([
                        'cart' => [
                            "Insufficient stock for '{$locked->name}' after locking.",
                        ],
                    ]);
                }
            }

            // Create order.
            $order = Order::create([
                'user_id'          => $user->id,
                'order_number'     => $this->orderNumberGenerator->generate(),
                'idempotency_key'  => $idempotencyKey,
                'status'           => 'pending',

                'subtotal'         => $subtotal,
                'tax_amount'       => $totals['tax_amount'],
                'shipping_amount'  => $totals['shipping_amount'],
                'discount_amount'  => $totals['discount_amount'],
                'total_amount'     => $totals['total_amount'],

                'shipping_name'         => $shippingAddress['name'],
                'shipping_phone'        => $shippingAddress['phone'],
                'shipping_email'        => $shippingAddress['email'],
                'shipping_address_line1' => $shippingAddress['address_line1'],
                'shipping_address_line2' => $shippingAddress['address_line2'] ?? null,
                'shipping_city'         => $shippingAddress['city'],
                'shipping_state'        => $shippingAddress['state'] ?? null,
                'shipping_postal_code'  => $shippingAddress['postal_code'],
                'shipping_country'      => $shippingAddress['country'],

                'billing_same_as_shipping' => true,
                'coupon_code'              => $coupon?->code,

                'payment_method' => $options['payment_method'] ?? 'cod',
                'payment_status' => 'unpaid',
                'customer_note'  => $options['customer_note'] ?? null,
            ]);

            // Create order items (snapshot).
            foreach ($cart->items as $item) {
                $product = $products->get($item->product_id);

                OrderItem::create([
                    'order_id'     => $order->id,
                    'product_id'   => $product->id,
                    'product_name' => $product->name,
                    'product_sku'  => $product->sku ?? null,
                    'quantity'     => $item->quantity,
                    'unit_price'   => $item->unit_price,
                    'line_total'   => round($item->quantity * (float) $item->unit_price, 2),
                ]);

                // Deduct stock via InventoryService (writes an audit movement row).
                if (!$product->allow_backorder) {
                    $this->inventoryService->removeStock(
                        product: $product,
                        quantity: $item->quantity,
                        reason: 'order',
                        note: "Order {$order->order_number}",
                        userId: $user->id,
                    );
                }
            }

            // Initial status history.
            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => 'pending',
                'changed_by' => $user->id,
                'note'       => 'Order created.',
            ]);

            // Bump coupon usage.
            if ($coupon) {
                $coupon->increment('times_used');
            }

            // Clear the cart.
            $cart->items()->delete();

            return $order->load(['items', 'statusHistory']);
        });

        try {
            app(NotificationService::class)->sendOrderConfirmed($order);
        } catch (Throwable $e) {
            Log::error('Post-order notification dispatch failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        return $order;
    }

    /**
     * Cancel an order and restore stock.
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function cancel(Order $order, ?string $reason, ?int $changedBy = null): Order
    {
        if (!$order->isCancellable()) {
            throw ValidationException::withMessages([
                'order' => [
                    "Order cannot be cancelled in status '{$order->status}'.",
                ],
            ]);
        }

        $order = DB::transaction(function () use ($order, $reason, $changedBy) {
            $order->load('items.product');

            // Restore stock.
            foreach ($order->items as $item) {
                if ($item->product) {
                    $this->inventoryService->addStock(
                        product: $item->product,
                        quantity: $item->quantity,
                        reason: 'order_cancel',
                        note: "Order {$order->order_number} cancelled",
                        userId: $changedBy,
                    );
                }
            }

            $order->update([
                'status'              => 'cancelled',
                'cancelled_at'        => now(),
                'cancellation_reason' => $reason,
            ]);

            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => 'cancelled',
                'changed_by' => $changedBy,
                'note'       => $reason,
            ]);

            return $order->fresh(['items', 'statusHistory']);
        });

        try {
            app(NotificationService::class)->sendOrderStatusUpdated(
                $order,
                'confirmed',
                'cancelled'
            );
        } catch (Throwable $e) {
            Log::error('Cancel notification failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        return $order;
    }

    /**
     * Change order status (admin action) with allowed-transition rules.
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function updateStatus(
        Order $order,
        string $newStatus,
        ?int $changedBy = null,
        ?string $note = null
    ): Order {
        $transitions = [
            'pending'    => ['confirmed', 'cancelled'],
            'confirmed'  => ['processing', 'cancelled'],
            'processing' => ['shipped'],
            'shipped'    => ['delivered'],
            'delivered'  => [],
            'cancelled'  => [],
        ];

        $allowed = $transitions[$order->status] ?? [];

        if (!in_array($newStatus, $allowed, true)) {
            throw ValidationException::withMessages([
                'status' => [
                    "Cannot transition from '{$order->status}' to '{$newStatus}'.",
                ],
            ]);
        }

        $previousStatus = $order->status;

        $order = DB::transaction(function () use (
            $order,
            $newStatus,
            $changedBy,
            $note
        ) {
            $update = ['status' => $newStatus];

            if ($newStatus === 'confirmed') {
                $update['confirmed_at'] = now();
            }

            $order->update($update);

            OrderStatusHistory::create([
                'order_id'   => $order->id,
                'status'     => $newStatus,
                'changed_by' => $changedBy,
                'note'       => $note,
            ]);

            return $order->fresh(['items', 'statusHistory']);
        });

        try {
            $notificationService = app(NotificationService::class);

            if ($newStatus === 'shipped') {
                $notificationService->sendOrderShipped($order);
            } else {
                $notificationService->sendOrderStatusUpdated(
                    $order,
                    $previousStatus,
                    $newStatus
                );
            }
        } catch (Throwable $e) {
            Log::error('Status update notification failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }

        return $order;
    }
}