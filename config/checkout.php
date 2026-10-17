<?php

return [
    'tax_rate'                => env('CHECKOUT_TAX_RATE', 0.14),
    'shipping_flat'           => env('CHECKOUT_SHIPPING_FLAT', 50.00),
    'free_shipping_threshold' => env('CHECKOUT_FREE_SHIPPING_THRESHOLD', 500.00),
];
