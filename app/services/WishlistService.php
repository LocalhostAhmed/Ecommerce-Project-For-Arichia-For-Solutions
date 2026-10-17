<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\Product;
use App\Models\User;
use App\Models\Wishlist;
use App\Models\WishlistItem;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class WishlistService
{
    public const MAX_ITEMS = 100;

    /**
     * Get or create the user's default wishlist.
     */
    public function getOrCreateWishlist(User $user): Wishlist
    {
        return Wishlist::firstOrCreate(
            ['user_id' => $user->id, 'name' => 'default'],
        );
    }

    /**
     * Add a product to the wishlist (idempotent).
     *
     * @throws ValidationException
     */
    public function addItem(User $user, Product $product): WishlistItem
    {
        if (!$product->is_active) {
            throw ValidationException::withMessages([
                'product_id' => ['This product is not available.'],
            ]);
        }

        $wishlist = $this->getOrCreateWishlist($user);

        return DB::transaction(function () use ($wishlist, $product) {
            $existing = WishlistItem::where('wishlist_id', $wishlist->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                return $existing; // idempotent
            }

            $count = WishlistItem::where('wishlist_id', $wishlist->id)->count();

            if ($count >= self::MAX_ITEMS) {
                throw ValidationException::withMessages([
                    'wishlist' => [
                        'Wishlist is full (max ' . self::MAX_ITEMS . ' items). '
                            . 'Remove something first.',
                    ],
                ]);
            }

            return WishlistItem::create([
                'wishlist_id' => $wishlist->id,
                'product_id'  => $product->id,
            ]);
        });
    }

    /**
     * Remove a product from the wishlist.
     *
     * @throws ValidationException
     */
    public function removeItem(User $user, Product $product): bool
    {
        $wishlist = $this->getOrCreateWishlist($user);

        return DB::transaction(function () use ($wishlist, $product) {
            $deleted = WishlistItem::where('wishlist_id', $wishlist->id)
                ->where('product_id', $product->id)
                ->delete();

            if ($deleted === 0) {
                throw ValidationException::withMessages([
                    'product_id' => ['This product is not in your wishlist.'],
                ]);
            }

            return true;
        });
    }

    /**
     * Build the full wishlist payload.
     */
    public function buildPayload(User $user): array
    {
        $wishlist = $this->getOrCreateWishlist($user);

        $wishlist->load([
            'items.product.category',
            'items.product.primaryImage',
        ]);

        $items = $wishlist->items->map(function (WishlistItem $item) {
            $product = $item->product;

            return [
                'id'          => $item->id,
                'product_id'  => $item->product_id,
                'name'        => $product?->name,
                'price'       => $product ? (float) $product->price : null,
                'image_url'   => $product?->primaryImage
                    ? asset('storage/' . $product->primaryImage->image_path)
                    : null,
                'category'    => $product?->category?->name,
                'in_stock'    => $product ? $product->isPurchasable() : false,
                'stock'       => $product?->stock_quantity,
                'added_at'    => $item->created_at?->toIso8601String(),
            ];
        });

        return [
            'wishlist_id' => $wishlist->id,
            'name'        => $wishlist->name,
            'item_count'  => $items->count(),
            'items'       => $items,
        ];
    }

    /**
     * Move a wishlist item into a cart.
     * Removes from wishlist, adds to cart, validates stock.
     *
     * @throws ValidationException
     */
    public function moveToCart(
        User $user,
        Product $product,
        Cart $cart,
        int $quantity,
        CartService $cartService
    ): array {
        // First validate the product can be moved.
        $wishlist = $this->getOrCreateWishlist($user);

        $wishlistItem = WishlistItem::where('wishlist_id', $wishlist->id)
            ->where('product_id', $product->id)
            ->first();

        if (!$wishlistItem) {
            throw ValidationException::withMessages([
                'product_id' => ['This product is not in your wishlist.'],
            ]);
        }

        return DB::transaction(function () use (
            $wishlistItem,
            $cart,
            $product,
            $quantity,
            $cartService
        ) {
            // Add to cart first (may throw on stock issues).
            $cartItem = $cartService->addItem($cart, $product, $quantity);

            // Only delete from wishlist after cart insertion succeeded.
            $wishlistItem->delete();

            return [
                'cart_item' => [
                    'id'         => $cartItem->id,
                    'product_id' => $cartItem->product_id,
                    'quantity'   => $cartItem->quantity,
                    'unit_price' => (float) $cartItem->unit_price,
                    'line_total' => $cartItem->line_total,
                ],
                'removed_from_wishlist' => true,
            ];
        });
    }
}