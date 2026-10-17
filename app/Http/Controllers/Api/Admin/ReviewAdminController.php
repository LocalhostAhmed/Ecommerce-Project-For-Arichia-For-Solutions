<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Review;
use App\Services\ReviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ReviewAdminController extends Controller
{
    public function __construct(
        protected ReviewService $reviewService
    ) {}

    /**
     * GET /api/admin/reviews
     * List reviews with filters: status, product_id, rating.
     */
    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'status'     => ['sometimes', Rule::in(Review::STATUSES)],
                'product_id' => ['sometimes', 'integer', 'exists:products,id'],
                'rating'     => ['sometimes', 'integer', 'between:1,5'],
                'per_page'   => ['sometimes', 'integer', 'min:1', 'max:100'],
            ]);

            $query = Review::with(['user:id,name,email', 'product:id,name'])
                ->orderByDesc('created_at');

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }
            if (!empty($validated['product_id'])) {
                $query->where('product_id', $validated['product_id']);
            }
            if (!empty($validated['rating'])) {
                $query->where('rating', $validated['rating']);
            }

            $reviews = $query
                ->paginate($validated['per_page'] ?? 20)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Reviews retrieved successfully.',
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
            Log::error('Admin reviews listing failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve reviews.',
            ], 500);
        }
    }

    /**
     * PATCH /api/admin/reviews/{review}/moderate
     * Approve or reject a review.
     */
    public function moderate(Request $request, Review $review)
    {
        try {
            $validated = $request->validate([
                'status' => ['required', Rule::in(['approved', 'rejected'])],
                'note'   => ['sometimes', 'nullable', 'string', 'max:500'],
            ]);

            $updated = $this->reviewService->moderate(
                review: $review,
                newStatus: $validated['status'],
                moderator: $request->user(),
                note: $validated['note'] ?? null,
            );

            return response()->json([
                'success' => true,
                'message' => "Review {$validated['status']} successfully.",
                'data'    => $updated,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Admin review moderation failed.', [
                'review_id' => $review->id,
                'admin_id'  => $request->user()?->id,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to moderate review.',
            ], 500);
        }
    }

    /**
     * DELETE /api/admin/reviews/{review}
     * Admin: delete any review.
     */
    public function destroy(Request $request, Review $review)
    {
        try {
            $this->reviewService->delete($review);

            return response()->json([
                'success' => true,
                'message' => 'Review deleted successfully.',
            ]);
        } catch (Throwable $e) {
            Log::error('Admin review deletion failed.', [
                'review_id' => $review->id,
                'admin_id'  => $request->user()?->id,
                'error'     => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete review.',
            ], 500);
        }
    }

    /**
     * GET /api/admin/reviews/pending/count
     * Small utility for admin dashboards.
     */
    public function pendingCount()
    {
        try {
            $count = Review::where('status', 'pending')->count();

            return response()->json([
                'success' => true,
                'message' => 'Pending reviews count retrieved successfully.',
                'data'    => ['pending_reviews' => $count],
            ]);
        } catch (Throwable $e) {
            Log::error('Pending reviews count failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve pending review count.',
            ], 500);
        }
    }
}
