<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use App\Services\CartService;
use App\Services\CheckoutCalculator;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected CheckoutCalculator $calculator,
        protected OrderService $orderService,
    ) {}

    /**
     * POST /api/checkout/preview
     * Validate cart + address and return totals without creating an order.
     */
    public function preview(Request $request)
    {
        try {
            $validated = $request->validate([
                'coupon_code' => ['sometimes', 'nullable', 'string', 'max:64'],
            ]);

            $cart = $this->cartService->resolveCart(
                userId: $request->user()->id,
                token: null,
            );

            $cart->load(['items.product']);

            if ($cart->items->isEmpty()) {
                throw ValidationException::withMessages([
                    'cart' => ['Your cart is empty.'],
                ]);
            }

            $issues = [];
            foreach ($cart->items as $item) {
                $product = $item->product;

                if (!$product || !$product->is_active) {
                    $issues[] = "Product #{$item->product_id} is no longer available.";
                } elseif (
                    !$product->allow_backorder
                    && $item->quantity > $product->stock_quantity
                ) {
                    $issues[] = "{$product->name}: only {$product->stock_quantity} available.";
                }
            }

            $subtotal = round(
                $cart->items->sum(fn($i) => $i->quantity * (float) $i->unit_price),
                2
            );

            $coupon = null;
            if (!empty($validated['coupon_code'])) {
                $coupon = Coupon::where('code', $validated['coupon_code'])->first();

                if (!$coupon || !$coupon->isValidForAmount($subtotal)) {
                    $issues[] = 'Invalid or expired coupon.';
                    $coupon = null;
                }
            }

            $totals = $this->calculator->calculate($subtotal, $coupon);

            return response()->json([
                'success' => empty($issues),
                'message' => empty($issues)
                    ? 'Checkout is valid.'
                    : 'Some items need attention before checkout.',
                'data' => [
                    'is_valid' => empty($issues),
                    'issues'   => $issues,
                    'totals'   => $totals,
                    'items'    => $cart->items->map(fn($i) => [
                        'product_id' => $i->product_id,
                        'name'       => $i->product?->name,
                        'quantity'   => $i->quantity,
                        'unit_price' => (float) $i->unit_price,
                        'line_total' => round($i->quantity * (float) $i->unit_price, 2),
                    ]),
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Checkout preview failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to preview checkout.',
            ], 500);
        }
    }

    /**
     * POST /api/checkout
     * Create the order.
     * Requires header: Idempotency-Key (recommended, not required).
     */
    public function place(Request $request)
    {
        try {
            $validated = $request->validate([
                'shipping_address'                => ['required', 'array'],
                'shipping_address.name'           => ['required', 'string', 'max:255'],
                'shipping_address.phone'          => ['required', 'string', 'max:32'],
                'shipping_address.email'          => ['required', 'email', 'max:255'],
                'shipping_address.address_line1'  => ['required', 'string', 'max:255'],
                'shipping_address.address_line2'  => ['sometimes', 'nullable', 'string', 'max:255'],
                'shipping_address.city'           => ['required', 'string', 'max:100'],
                'shipping_address.state'          => ['sometimes', 'nullable', 'string', 'max:100'],
                'shipping_address.postal_code'    => ['required', 'string', 'max:20'],
                'shipping_address.country'        => ['required', 'string', 'size:2'],

                'coupon_code'    => ['sometimes', 'nullable', 'string', 'max:64'],
                'customer_note'  => ['sometimes', 'nullable', 'string', 'max:1000'],
                'payment_method' => ['sometimes', 'string', 'in:cod,card,wallet'],
            ]);

            $cart = $this->cartService->resolveCart(
                userId: $request->user()->id,
                token: null,
            );

            $idempotencyKey = $request->header('Idempotency-Key');

            $order = $this->orderService->createFromCart(
                user: $request->user(),
                cart: $cart,
                shippingAddress: $validated['shipping_address'],
                options: [
                    'idempotency_key' => $idempotencyKey,
                    'coupon_code'     => $validated['coupon_code'] ?? null,
                    'customer_note'   => $validated['customer_note'] ?? null,
                    'payment_method'  => $validated['payment_method'] ?? 'cod',
                ],
            );

            $wasReplay = $idempotencyKey && $order->wasRecentlyCreated === false;

            return response()->json([
                'success' => true,
                'message' => $wasReplay
                    ? 'Existing order returned (idempotent request).'
                    : 'Order created successfully.',
                'data'    => $this->formatOrder($order),
            ], $wasReplay ? 200 : 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Order creation failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
                'input'   => $request->except(['shipping_address.email']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create order.',
            ], 500);
        }
    }

    /**
     * Format an order for JSON responses.
     */
    protected function formatOrder($order): array
    {
        return [
            'id'              => $order->id,
            'order_number'    => $order->order_number,
            'status'          => $order->status,
            'subtotal'        => (float) $order->subtotal,
            'tax_amount'      => (float) $order->tax_amount,
            'shipping_amount' => (float) $order->shipping_amount,
            'discount_amount' => (float) $order->discount_amount,
            'total_amount'    => (float) $order->total_amount,
            'coupon_code'     => $order->coupon_code,
            'payment_method'  => $order->payment_method,
            'payment_status'  => $order->payment_status,
            'shipping_address' => [
                'name'         => $order->shipping_name,
                'phone'        => $order->shipping_phone,
                'email'        => $order->shipping_email,
                'address_line1' => $order->shipping_address_line1,
                'address_line2' => $order->shipping_address_line2,
                'city'         => $order->shipping_city,
                'state'        => $order->shipping_state,
                'postal_code'  => $order->shipping_postal_code,
                'country'      => $order->shipping_country,
            ],
            'items' => $order->items->map(fn($i) => [
                'id'           => $i->id,
                'product_id'   => $i->product_id,
                'product_name' => $i->product_name,
                'quantity'     => $i->quantity,
                'unit_price'   => (float) $i->unit_price,
                'line_total'   => (float) $i->line_total,
            ]),
            'created_at' => $order->created_at?->toIso8601String(),
        ];
    }
}
