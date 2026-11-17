<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ReviewController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    public function index(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'rating'   => ['sometimes', 'integer', 'between:1,5'],
                'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            ]);

            $reviews    = $this->reviewService->getProductReviews(
                product: $product,
                perPage: $validated['per_page'] ?? 10,
                ratingFilter: $validated['rating'] ?? null,
            );
            $breakdown  = $this->reviewService->getRatingBreakdown($product);

            return response()->json([
                'success' => true,
                'message' => 'Reviews retrieved successfully.',
                'data' => [
                    'product_id'     => $product->id,
                    'average_rating' => (float) $product->rating,
                    'rating_count'   => $product->rating_count,
                    'breakdown'      => $breakdown,
                    'reviews'        => $reviews->items(),
                ],
                'pagination' => [
                    'current_page' => $reviews->currentPage(),
                    'per_page'     => $reviews->perPage(),
                    'total'        => $reviews->total(),
                    'last_page'    => $reviews->lastPage(),
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Reviews retrieval failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve reviews.',
            ], 500);
        }
    }


    public function store(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'rating'  => ['required', 'integer', 'between:1,5'],
                'title'   => ['sometimes', 'nullable', 'string', 'max:150'],
                'comment' => ['sometimes', 'nullable', 'string', 'max:2000'],
            ]);

            $review = $this->reviewService->create(
                user: $request->user(),
                product: $product,
                rating: $validated['rating'],
                title: $validated['title'] ?? null,
                comment: $validated['comment'] ?? null,
            );

            return response()->json([
                'success' => true,
                'message' => 'Review submitted successfully. It will be visible once approved.',
                'data'    => $review,
            ], 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Review creation failed.', [
                'user_id'    => $request->user()?->id,
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
                'input'      => $request->only(['rating', 'title', 'comment']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to submit review.',
            ], 500);
        }
    }

    public function update(Request $request, Review $review)
    {
        try {
            if ($review->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Review not found.',
                ], 404);
            }

            $validated = $request->validate([
                'rating'  => ['required', 'integer', 'between:1,5'],
                'title'   => ['sometimes', 'nullable', 'string', 'max:150'],
                'comment' => ['sometimes', 'nullable', 'string', 'max:2000'],
            ]);

            $updated = $this->reviewService->update(
                review: $review,
                rating: $validated['rating'],
                title: $validated['title'] ?? null,
                comment: $validated['comment'] ?? null,
            );

            return response()->json([
                'success' => true,
                'message' => 'Review updated. It will be re-moderated.',
                'data'    => $updated,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Review update failed.', [
                'review_id' => $review->id,
                'user_id'   => $request->user()?->id,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update review.',
            ], 500);
        }
    }

    public function destroy(Request $request, Review $review)
    {
        try {
            if ($review->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Review not found.',
                ], 404);
            }

            $this->reviewService->delete($review);

            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully.',
            ]);
        } catch (Throwable $e) {
            Log::error('Review deletion failed.', [
                'review_id' => $review->id,
                'user_id'   => $request->user()?->id,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete review.',
            ], 500);
        }
    }

    public function mine(Request $request)
    {
        try {
            $validated = $request->validate([
                'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
            ]);

            $reviews = Review::where('user_id', $request->user()->id)
                ->with(['product:id,name'])
                ->orderByDesc('created_at')
                ->paginate($validated['per_page'] ?? 10)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Your reviews retrieved successfully.',
                'data'    => $reviews->items(),
                'pagination' => [
                    'current_page' => $reviews->currentPage(),
                    'per_page'     => $reviews->perPage(),
                    'total'        => $reviews->total(),
                    'last_page'    => $reviews->lastPage(),
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('User reviews retrieval failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve your reviews.',
            ], 500);
        }
    }

    public function helpful(Request $request, Review $review)
    {
        try {
            if ($review->status !== 'approved') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only approved reviews can be marked helpful.',
                ], 422);
            }

            if ($review->user_id === $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'You cannot mark your own review as helpful.',
                ], 422);
            }

            $updated = $this->reviewService->markHelpful($review);

            return response()->json([
                'success' => true,
                'message' => 'Marked as helpful.',
                'data'    => [
                    'review_id'     => $updated->id,
                    'helpful_count' => $updated->helpful_count,
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Mark helpful failed.', [
                'review_id' => $review->id,
                'user_id'   => $request->user()?->id,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to mark review as helpful.',
            ], 500);
        }
    }
}
