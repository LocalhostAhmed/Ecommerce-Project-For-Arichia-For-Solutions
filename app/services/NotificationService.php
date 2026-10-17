<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Notifications\LowStockAlert;
use App\Notifications\OrderConfirmed;
use App\Notifications\OrderShipped;
use App\Notifications\OrderStatusUpdated;
use App\Notifications\PaymentFailed;
use App\Notifications\PaymentSucceeded;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Throwable;

class NotificationService
{
    /**
     * Send order confirmation to the customer.
     */
    public function sendOrderConfirmed(Order $order): void
    {
        try {
            $order->loadMissing(['items', 'user']);

            if (!$order->user) {
                Log::warning('Order has no user; skipping confirmation.', [
                    'order_id' => $order->id,
                ]);
                return;
            }

            $order->user->notify(new OrderConfirmed($order));
        } catch (Throwable $e) {
            Log::error('Order confirmation notification failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send payment success to the customer and admin(s).
     */
    public function sendPaymentSucceeded(Order $order, float $amountPaid): void
    {
        try {
            $order->loadMissing('user');

            if ($order->user) {
                $order->user->notify(new PaymentSucceeded($order, $amountPaid));
            }

            // Notify admins.
            $this->notifyAdmins(new PaymentSucceeded($order, $amountPaid));
        } catch (Throwable $e) {
            Log::error('Payment success notification failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send payment failure to the customer.
     */
    public function sendPaymentFailed(Order $order, string $reason): void
    {
        try {
            $order->loadMissing('user');

            if ($order->user) {
                $order->user->notify(new PaymentFailed($order, $reason));
            }
        } catch (Throwable $e) {
            Log::error('Payment failure notification failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send order status update to the customer.
     */
    public function sendOrderStatusUpdated(
        Order $order,
        string $oldStatus,
        string $newStatus
    ): void {
        try {
            $order->loadMissing('user');

            if (!$order->user) {
                return;
            }

            $order->user->notify(
                new OrderStatusUpdated($order, $oldStatus, $newStatus)
            );
        } catch (Throwable $e) {
            Log::error('Order status notification failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send shipping confirmation to the customer.
     */
    public function sendOrderShipped(Order $order, ?string $trackingNumber = null): void
    {
        try {
            $order->loadMissing('user');

            if (!$order->user) {
                return;
            }

            $order->user->notify(new OrderShipped($order, $trackingNumber));
        } catch (Throwable $e) {
            Log::error('Order shipped notification failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send low stock alert to admins.
     * Throttled: one alert per product per 24 hours.
     */
    public function sendLowStockAlert(Product $product): void
    {
        try {
            // Skip if no threshold defined or stock is fine.
            if ($product->low_stock_threshold === null) {
                return;
            }

            if ($product->stock_quantity > $product->low_stock_threshold) {
                return;
            }

            // Throttle: one alert per product per 24 hours.
            $cacheKey = "low_stock_alert_sent:{$product->id}";

            if (Cache::has($cacheKey)) {
                return;
            }

            $this->notifyAdmins(new LowStockAlert($product));

            Cache::put($cacheKey, true, now()->addHours(24));
        } catch (Throwable $e) {
            Log::error('Low stock alert notification failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);
        }
    }

    /**
     * Send a notification to all admins.
     */
    protected function notifyAdmins(object $notification): void
    {
        try {
            $admins = User::where('role', 'admin')->get();

            foreach ($admins as $admin) {
                $admin->notify(clone $notification);
            }
        } catch (Throwable $e) {
            Log::error('Admin notification dispatch failed.', [
                'notification' => get_class($notification),
                'error'        => $e->getMessage(),
            ]);
        }
    }
}
