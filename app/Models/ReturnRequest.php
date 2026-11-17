<?php
// app/Models/ReturnRequest.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnRequest extends Model
{
    protected $table = 'returns';

    protected $fillable = ['order_id', 'user_id', 'status', 'reason', 'refund_amount', 'processed_at'];

    protected $casts = [
        'processed_at' => 'datetime',
        'refund_amount' => 'decimal:2',
    ];

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}