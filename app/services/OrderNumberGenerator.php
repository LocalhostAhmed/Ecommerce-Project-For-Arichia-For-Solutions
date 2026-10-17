<?php

namespace App\Services;

use App\Models\Order;

class OrderNumberGenerator
{
    /**
     * Generate a unique order number: ORD-YYYYMMDD-XXXXXX
     */
    public function generate(): string
    {
        $prefix = 'ORD-' . now()->format('Ymd') . '-';

        // Loop in the unlikely event of a collision.
        for ($i = 0; $i < 5; $i++) {
            $candidate = $prefix . strtoupper(bin2hex(random_bytes(3))); // 6 hex chars

            if (!Order::where('order_number', $candidate)->exists()) {
                return $candidate;
            }
        }

        throw new \RuntimeException('Unable to generate a unique order number.');
    }
}