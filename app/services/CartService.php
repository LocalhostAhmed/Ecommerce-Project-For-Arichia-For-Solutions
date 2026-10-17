<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class CartService
{
    /**
     * Resolve the cart for the current request.
     * Priority: user cart (if logged in) → token cart → new cart.
     */
    public function resolveCart(?int $userId, ?string $token): Cart
    {
        // Logged-in user: use their open cart.
        if ($userId) {
            $cart = Cart::where('user_id', $userId)
                ->latest()
                ->first();

            if ($cart) {
                return $cart;
            }

            return Cart::create([
                'user_id'    => $userId,
                'expires_at' => now()->addDays(30),
            ]);
        }

        // Guest with token: look up existing cart.
        if ($token) {
            $cart = Cart::where('token', $token)->first();

            if ($cart) {
                return $cart;
            }
        }

        // New guest cart.
        return Cart::create([
            'expires_at' => now()->addDays(7),
        ]);
    }

    /**
     * Add a product to the cart (or increment quantity if already present).
     *
     * @throws ValidationException
     */
    public function addItem(
        Cart $cart,
        Product $product,
        int $quantity
    ): CartItem {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => ['Quantity must be greater than zero.'],
            ]);
        }

        if (!$product->is_active) {
            throw ValidationException::withMessages([
                'product_id' => ['This product is not available.'],
            ]);
        }

        if (!$product->isPurchasable()) {
            throw ValidationException::withMessages([
                'product_id' => ['This product is currently out of stock.'],
            ]);
        }

        return DB::transaction(function () use ($cart, $product, $quantity) {
            $existing = CartItem::where('cart_id', $cart->id)
                ->where('product_id', $product->id)
                ->lockForUpdate()
                ->first();

            $currentQty    = $existing?->quantity ?? 0;
            $newQty        = $currentQty + $quantity;

            // Enforce stock (unless backorders allowed).
            if (!$product->allow_backorder && $newQty > $product->stock_quantity) {
                throw ValidationException::withMessages([
                    'quantity' => [
                        "Only {$product->stock_quantity} unit(s) available. "
                            . "You already have {$currentQty} in your cart.",
                    ],
                ]);
            }

            if ($existing) {
                $existing->update([
                    'quantity'   => $newQty,
                    // Refresh price snapshot in case the price changed.
                    'unit_price' => $product->price,
                ]);

                return $existing->fresh();
            }

            return CartItem::create([
                'cart_id'    => $cart->id,
                'product_id' => $product->id,
                'quantity'   => $quantity,
                'unit_price' => $product->price,
            ]);
        });
    }

    /**
     * Update the quantity of an existing cart item.
     *
     * @throws ValidationException
     */
    public function updateItemQuantity(
        Cart $cart,
        CartItem $item,
        int $quantity
    ): CartItem {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => ['Quantity must be at least 1. Use remove to delete the item.'],
            ]);
        }

        if ($item->cart_id !== $cart->id) {
            throw ValidationException::withMessages([
                'item' => ['This item does not belong to your cart.'],
            ]);
        }

        return DB::transaction(function () use ($item, $quantity) {
            $product = Product::query()
                ->whereKey($item->product_id)
                ->lockForUpdate()
                ->firstOrFail();

            if (!$product->allow_backorder && $quantity > $product->stock_quantity) {
                throw ValidationException::withMessages([
                    'quantity' => [
                        "Only {$product->stock_quantity} unit(s) available.",
                    ],
                ]);
            }

            $item->update([
                'quantity'   => $quantity,
                'unit_price' => $product->price,
            ]);

            return $item->fresh();
        });
    }

    /**
     * Remove a single item from the cart.
     */
    public function removeItem(Cart $cart, CartItem $item): void
    {
        if ($item->cart_id !== $cart->id) {
            throw ValidationException::withMessages([
                'item' => ['This item does not belong to your cart.'],
            ]);
        }

        DB::transaction(function () use ($item) {
            $item->delete();
        });
    }

    /**
     * Remove all items from the cart.
     */
    public function clearCart(Cart $cart): int
    {
        return DB::transaction(function () use ($cart) {
            return $cart->items()->delete();
        });
    }

    /**
     * Build the full cart payload: items, subtotal, count, stock warnings.
     */
    public function buildCartPayload(Cart $cart): array
    {
        $cart->load(['items.product.primaryImage', 'items.product.category']);

        $items = $cart->items->map(function (CartItem $item) {
            $product = $item->product;

            $stockIssue = null;
            if ($product) {
                if (!$product->is_active) {
                    $stockIssue = 'unavailable';
                } elseif (
                    !$product->allow_backorder
                    && $item->quantity > $product->stock_quantity
                ) {
                    $stockIssue = 'insufficient_stock';
                } elseif ($product->stock_quantity <= 0 && !$product->allow_backorder) {
                    $stockIssue = 'out_of_stock';
                }
            }

            return [
                'id'          => $item->id,
                'product_id'  => $item->product_id,
                'name'        => $product?->name,
                'image_url'   => $product?->primaryImage
                    ? asset('storage/' . $product->primaryImage->image_path)
                    : null,
                'unit_price'  => (float) $item->unit_price,
                'quantity'    => $item->quantity,
                'line_total'  => $item->line_total,
                'stock'       => $product?->stock_quantity,
                'stock_issue' => $stockIssue,
            ];
        });

        return [
            'cart_token'     => $cart->token,
            'items'          => $items,
            'item_count'     => $items->count(),
            'total_quantity' => $cart->total_quantity,
            'subtotal'       => $cart->subtotal,
            'currency'       => 'USD',
        ];
    }
}