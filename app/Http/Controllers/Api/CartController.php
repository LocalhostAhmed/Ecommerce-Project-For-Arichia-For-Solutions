<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use App\Services\CartService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    /**
     * Resolve the cart for this request (user or guest token).
     */
    protected function resolveCart(Request $request): Cart
    {
        return $this->cartService->resolveCart(
            userId: $request->user()?->id,
            token: $request->header('X-Cart-Token') ?? $request->input('cart_token'),
        );
    }

    /**
     * GET /api/cart
     * View the current cart.
     */
    public function show(Request $request)
    {
        try {
            $cart    = $this->resolveCart($request);
            $payload = $this->cartService->buildCartPayload($cart);

            return response()->json([
                'success' => true,
                'message' => 'Cart retrieved successfully.',
                'data'    => $payload,
            ]);
        } catch (Throwable $e) {
            Log::error('Cart retrieval failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve cart.',
            ], 500);
        }
    }

    /**
     * POST /api/cart/items
     * Add a product to the cart.
     */
    public function addItem(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => ['required', 'integer', 'exists:products,id'],
                'quantity'   => ['required', 'integer', 'min:1', 'max:1000'],
            ]);

            $cart    = $this->resolveCart($request);
            $product = Product::findOrFail($validated['product_id']);

            $item = $this->cartService->addItem(
                cart: $cart,
                product: $product,
                quantity: $validated['quantity'],
            );

            $payload = $this->cartService->buildCartPayload($cart->fresh());

            return response()->json([
                'success' => true,
                'message' => 'Item added to cart successfully.',
                'data'    => array_merge($payload, [
                    'added_item' => [
                        'id'         => $item->id,
                        'product_id' => $item->product_id,
                        'quantity'   => $item->quantity,
                        'unit_price' => (float) $item->unit_price,
                        'line_total' => $item->line_total,
                    ],
                ]),
            ], 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Add to cart failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
                'input'   => $request->only(['product_id', 'quantity']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to add item to cart.',
            ], 500);
        }
    }

    /**
     * PUT /api/cart/items/{item}
     * Update the quantity of a cart item.
     */
    public function updateItem(Request $request, CartItem $item)
    {
        try {
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1', 'max:1000'],
            ]);

            $cart = $this->resolveCart($request);

            $updated = $this->cartService->updateItemQuantity(
                cart: $cart,
                item: $item,
                quantity: $validated['quantity'],
            );

            $payload = $this->cartService->buildCartPayload($cart->fresh());

            return response()->json([
                'success' => true,
                'message' => 'Cart item updated successfully.',
                'data'    => array_merge($payload, [
                    'updated_item' => [
                        'id'         => $updated->id,
                        'product_id' => $updated->product_id,
                        'quantity'   => $updated->quantity,
                        'unit_price' => (float) $updated->unit_price,
                        'line_total' => $updated->line_total,
                    ],
                ]),
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Cart item update failed.', [
                'user_id'      => $request->user()?->id,
                'cart_item_id' => $item->id,
                'error'        => $e->getMessage(),
                'input'        => $request->only(['quantity']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update cart item.',
            ], 500);
        }
    }

    /**
     * DELETE /api/cart/items/{item}
     * Remove a single item from the cart.
     */
    public function removeItem(Request $request, CartItem $item)
    {
        try {
            $cart = $this->resolveCart($request);

            $this->cartService->removeItem(cart: $cart, item: $item);

            $payload = $this->cartService->buildCartPayload($cart->fresh());

            return response()->json([
                'success' => true,
                'message' => 'Item removed from cart successfully.',
                'data'    => $payload,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Cart item removal failed.', [
                'user_id'      => $request->user()?->id,
                'cart_item_id' => $item->id,
                'error'        => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to remove cart item.',
            ], 500);
        }
    }

    /**
     * DELETE /api/cart
     * Clear the entire cart.
     */
    public function clear(Request $request)
    {
        try {
            $cart    = $this->resolveCart($request);
            $deleted = $this->cartService->clearCart($cart);

            return response()->json([
                'success' => true,
                'message' => 'Cart cleared successfully.',
                'data' => [
                    'cart_token'    => $cart->token,
                    'items_removed' => $deleted,
                    'item_count'    => 0,
                    'subtotal'      => 0.00,
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Cart clear failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to clear cart.',
            ], 500);
        }
    }

    /**
     * GET /api/cart/subtotal
     * Lightweight endpoint that only returns totals.
     */
    public function subtotal(Request $request)
    {
        try {
            $cart = $this->resolveCart($request);

            return response()->json([
                'success' => true,
                'message' => 'Cart subtotal calculated successfully.',
                'data' => [
                    'cart_token'     => $cart->token,
                    'item_count'     => $cart->items()->count(),
                    'total_quantity' => (int) $cart->items()->sum('quantity'),
                    'subtotal'       => (float) round(
                        $cart->items()->get()
                            ->sum(fn($i) => $i->quantity * (float) $i->unit_price),
                        2
                    ),
                    'currency'       => 'USD',
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Cart subtotal calculation failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to calculate cart subtotal.',
            ], 500);
        }
    }

    /**
     * POST /api/cart/merge
     * Merge a guest cart into the current logged-in user's cart.
     * Call this after login.
     */
    public function merge(Request $request)
    {
        try {
            $userId = $request->user()?->id;

            if (!$userId) {
                return response()->json([
                    'success' => false,
                    'message' => 'Authentication required to merge carts.',
                ], 401);
            }

            $validated = $request->validate([
                'cart_token' => ['required', 'string', 'max:64'],
            ]);

            $guestCart = Cart::where('token', $validated['cart_token'])
                ->whereNull('user_id')
                ->first();

            if (!$guestCart) {
                return response()->json([
                    'success' => false,
                    'message' => 'Guest cart not found.',
                ], 404);
            }

            $userCart = $this->cartService->resolveCart($userId, null);

            \Illuminate\Support\Facades\DB::transaction(function () use ($guestCart, $userCart) {
                foreach ($guestCart->items()->with('product')->get() as $guestItem) {
                    if (!$guestItem->product) {
                        continue;
                    }

                    $this->cartService->addItem(
                        cart: $userCart,
                        product: $guestItem->product,
                        quantity: $guestItem->quantity,
                    );
                }

                $guestCart->delete();
            });

            $payload = $this->cartService->buildCartPayload($userCart->fresh());

            return response()->json([
                'success' => true,
                'message' => 'Cart merged successfully.',
                'data'    => $payload,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Cart merge failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to merge carts.',
            ], 500);
        }
    }
}
