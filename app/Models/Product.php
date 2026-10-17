<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'price',
        'compare_at_price',
        'sku',
        'category_id',
        'brand',
        'stock',
        'image',
        'is_active',
        'stock_quantity',
        'low_stock_threshold',
        'allow_backorder',
        'rating',
        'rating_count',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'compare_at_price' => 'decimal:2',
            'stock' => 'integer',
            'is_active' => 'boolean',
            'stock_quantity'      => 'integer',
            'low_stock_threshold' => 'integer',
            'allow_backorder'     => 'boolean',
            'rating'       => 'decimal:2',
            'rating_count' => 'integer',
        ];
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function cartItems(): HasMany
    {
        return $this->hasMany(CartItem::class);
    }

    public function images(): HasMany
    {
        return $this->hasMany(ProductImage::class)
            ->orderByDesc('is_primary')
            ->orderBy('id');
    }

    public function primaryImage(): HasOne
    {
        return $this->hasOne(ProductImage::class)
            ->where('is_primary', true);
    }


    public function inventoryMovements(): HasMany
    {
        return $this->hasMany(InventoryMovement::class)
            ->orderByDesc('created_at');
    }

    /**
     * True when stock is positive but at or below the threshold.
     */
    public function isLowStock(): bool
    {
        return $this->stock_quantity > 0
            && $this->stock_quantity <= $this->low_stock_threshold;
    }

    /**
     * True when there is no stock at all.
     */
    public function isOutOfStock(): bool
    {
        return $this->stock_quantity <= 0;
    }

    /**
     * True when the product can be sold right now.
     */
    public function isPurchasable(): bool
    {
        return $this->stock_quantity > 0 || $this->allow_backorder;
    }


    public function wishlistItems(): HasMany
    {
        return $this->hasMany(WishlistItem::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(Review::class);
    }

    public function approvedReviews(): HasMany
    {
        return $this->hasMany(Review::class)->where('status', 'approved');
    }
}
