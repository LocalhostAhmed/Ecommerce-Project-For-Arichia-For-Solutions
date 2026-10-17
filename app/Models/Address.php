<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    protected $fillable = [
        'label',
        'recipient_name',
        'phone',
        'country',
        'state',
        'city',
        'street_address',
        'apartment',
        'postal_code',
        'delivery_instructions',
        'is_shipping',
        'is_billing',
        'is_default_shipping',
        'is_default_billing',
    ];

    protected function casts(): array
    {
        return [
            'is_shipping' => 'boolean',
            'is_billing' => 'boolean',
            'is_default_shipping' => 'boolean',
            'is_default_billing' => 'boolean',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}