<?php

namespace App\Services;

use App\Models\Coupon;

class CheckoutCalculator
{
    /**
     * Default rates — override via config('checkout.*').
     */
    protected const DEFAULT_TAX_RATE         = 0.14;  // 14% VAT
    protected const DEFAULT_SHIPPING_FLAT    = 50.00;
    protected const FREE_SHIPPING_THRESHOLD  = 500.00;

    /**
     * @return array{tax_rate: float, tax_amount: float, shipping_amount: float, discount_amount: float, subtotal: float, total_amount: float}
     */
    public function calculate(float $subtotal, ?Coupon $coupon = null): array
    {
        $taxRate      = (float) config('checkout.tax_rate', self::DEFAULT_TAX_RATE);
        $shippingFlat = (float) config('checkout.shipping_flat', self::DEFAULT_SHIPPING_FLAT);
        $freeAbove    = (float) config('checkout.free_shipping_threshold', self::FREE_SHIPPING_THRESHOLD);

        // Discount first (before tax & shipping).
        $discountAmount = $coupon ? $coupon->calculateDiscount($subtotal) : 0.0;

        // Tax on the discounted amount.
        $taxableAmount = max(0, $subtotal - $discountAmount);
        $taxAmount     = round($taxableAmount * $taxRate, 2);

        // Shipping (flat, free above threshold).
        $shippingAmount = $subtotal >= $freeAbove ? 0.0 : $shippingFlat;

        // Final total.
        $total = round($taxableAmount + $taxAmount + $shippingAmount, 2);

        return [
            'subtotal'        => round($subtotal, 2),
            'discount_amount' => $discountAmount,
            'tax_rate'        => $taxRate,
            'tax_amount'      => $taxAmount,
            'shipping_amount' => $shippingAmount,
            'total_amount'    => $total,
        ];
    }
}
