<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\CartService;
use App\Services\WishlistService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class WishlistController extends Controller
{
    public function __construct(
        protected WishlistService $wishlistService,
        protected CartService $cartService,
    ) {}

    /**
     * GET /api/wishlist
     * View the authenticated user's wishlist.
     */
    public function index(Request $request)
    {
        try {
            $payload = $this->wishlistService->buildPayload($request->user());

            return response()->json([
                'success' => true,
                'message' => 'Wishlist retrieved successfully.',
                'data'    => $payload,
            ]);
        } catch (Throwable $e) {
            Log::error('Wishlist retrieval failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve wishlist.',
            ], 500);
        }
    }

    /**
     * POST /api/wishlist/items
     * Add a product to the wishlist.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => ['required', 'integer', 'exists:products,id'],
            ]);

            $product = Product::findOrFail($validated['product_id']);

            $item = $this->wishlistService->addItem($request->user(), $product);

            $payload = $this->wishlistService->buildPayload($request->user());

            return response()->json([
                'success' => true,
                'message' => 'Product added to wishlist successfully.',
                'data'    => array_merge($payload, [
                    'added_item_id' => $item->id,
                ]),
            ], 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Wishlist add failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
                'input'   => $request->only(['product_id']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to add product to wishlist.',
            ], 500);
        }
    }

    /**
     * DELETE /api/wishlist/items/{product}
     * Remove a product from the wishlist.
     */
    public function destroy(Request $request, Product $product)
    {
        try {
            $this->wishlistService->removeItem($request->user(), $product);

            $payload = $this->wishlistService->buildPayload($request->user());

            return response()->json([
                'success' => true,
                'message' => 'Product removed from wishlist successfully.',
                'data'    => $payload,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Wishlist remove failed.', [
                'user_id'    => $request->user()?->id,
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to remove product from wishlist.',
            ], 500);
        }
    }

    /**
     * POST /api/wishlist/items/{product}/move-to-cart
     * Move a product from wishlist into the user's cart.
     */
    public function moveToCart(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'quantity' => ['sometimes', 'integer', 'min:1', 'max:1000'],
            ]);

            // Resolve the user's cart (must exist or be created).
            $cart = $this->cartService->resolveCart(
                userId: $request->user()->id,
                token: null,
            );

            $result = $this->wishlistService->moveToCart(
                user: $request->user(),
                product: $product,
                cart: $cart,
                quantity: $validated['quantity'] ?? 1,
                cartService: $this->cartService,
            );

            $wishlistPayload = $this->wishlistService->buildPayload($request->user());
            $cartPayload     = $this->cartService->buildCartPayload($cart->fresh());

            return response()->json([
                'success' => true,
                'message' => 'Product moved to cart successfully.',
                'data' => [
                    'moved'    => $result,
                    'wishlist' => $wishlistPayload,
                    'cart'     => $cartPayload,
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Wishlist move-to-cart failed.', [
                'user_id'    => $request->user()?->id,
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to move product to cart.',
            ], 500);
        }
    }
}
