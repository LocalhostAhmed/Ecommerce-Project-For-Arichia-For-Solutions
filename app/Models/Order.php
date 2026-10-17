<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    // Allowed status transitions
    public const STATUSES = [
        'pending',
        'confirmed',
        'processing',
        'shipped',
        'delivered',
        'cancelled',
    ];

    protected $fillable = [
        'user_id',
        'order_number',
        'idempotency_key',
        'status',
        'subtotal',
        'tax_amount',
        'shipping_amount',
        'discount_amount',
        'total_amount',
        'shipping_name',
        'shipping_phone',
        'shipping_email',
        'shipping_address_line1',
        'shipping_address_line2',
        'shipping_city',
        'shipping_state',
        'shipping_postal_code',
        'shipping_country',
        'billing_same_as_shipping',
        'coupon_code',
        'payment_method',
        'payment_status',
        'customer_note',
        'admin_note',
        'confirmed_at',
        'cancelled_at',
        'cancellation_reason',
    ];

    protected function casts(): array
    {
        return [
            'subtotal'                => 'decimal:2',
            'tax_amount'              => 'decimal:2',
            'shipping_amount'         => 'decimal:2',
            'discount_amount'         => 'decimal:2',
            'total_amount'            => 'decimal:2',
            'billing_same_as_shipping' => 'boolean',
            'confirmed_at'            => 'datetime',
            'cancelled_at'            => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function statusHistory(): HasMany
    {
        return $this->hasMany(OrderStatusHistory::class)->latest();
    }

    public function isCancellable(): bool
    {
        return in_array($this->status, ['pending', 'confirmed'], true);
    }

    public function isFinal(): bool
    {
        return in_array($this->status, ['delivered', 'cancelled'], true);
    }
}