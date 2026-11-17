<?php

namespace App\Services;

use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class ReviewService
{
    public const MIN_RATING = 1;
    public const MAX_RATING = 5;

    /**
     * Create a new review. Prevents duplicates and auto-detects verified purchase.
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function create(
        User $user,
        Product $product,
        int $rating,
        ?string $title,
        ?string $comment
    ): Review {
        if ($rating < self::MIN_RATING || $rating > self::MAX_RATING) {
            throw ValidationException::withMessages([
                'rating' => ['Rating must be between 1 and 5.'],
            ]);
        }

        if (!$product->is_active) {
            throw ValidationException::withMessages([
                'product_id' => ['You cannot review an unavailable product.'],
            ]);
        }

        return DB::transaction(function () use (
            $user,
            $product,
            $rating,
            $title,
            $comment
        ) {
            // Prevent duplicate (defense-in-depth: DB also enforces).
            $existing = Review::where('product_id', $product->id)
                ->where('user_id', $user->id)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                throw ValidationException::withMessages([
                    'product_id' => [
                        'You have already reviewed this product. Edit your existing review instead.',
                    ],
                ]);
            }

            $verified = $this->hasPurchased($user, $product);

            $review = Review::create([
                'product_id'           => $product->id,
                'user_id'              => $user->id,
                'rating'               => $rating,
                'title'                => $title,
                'comment'              => $comment,
                'is_verified_purchase' => $verified,
                'status'               => 'pending',
            ]);

            return $review->load(['user:id,name', 'product:id,name']);
        });
    }

    /**
     * Edit an existing review. Only the author or admin can update.
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function update(
        Review $review,
        int $rating,
        ?string $title,
        ?string $comment
    ): Review {
        if ($rating < self::MIN_RATING || $rating > self::MAX_RATING) {
            throw ValidationException::withMessages([
                'rating' => ['Rating must be between 1 and 5.'],
            ]);
        }

        return DB::transaction(function () use ($review, $rating, $title, $comment) {
            $wasApproved = $review->status === 'approved';

            $review->update([
                'rating'  => $rating,
                'title'   => $title,
                'comment' => $comment,
                // Re-enter moderation when the content changes.
                'status'  => 'pending',
                'moderation_note' => null,
                'moderated_by'    => null,
                'moderated_at'    => null,
            ]);

            // If it was approved before, remove its contribution from the cache.
            if ($wasApproved) {
                $this->recalculateProductRating($review->product);
            }

            return $review->fresh(['user:id,name', 'product:id,name']);
        });
    }

    /**
     * Delete a review and recalculate the product's average rating.
     *
     * @throws Throwable
     */
    public function delete(Review $review): void
    {
        DB::transaction(function () use ($review) {
            $product = $review->product;
            $wasApproved = $review->status === 'approved';

            $review->delete();

            if ($wasApproved && $product) {
                $this->recalculateProductRating($product);
            }
        });
    }

    /**
     * Moderator action: approve or reject a pending review.
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function moderate(
        Review $review,
        string $newStatus,
        $moderator,
        ?string $note = null
    ): Review {
        if (!in_array($newStatus, ['approved', 'rejected'], true)) {
            throw ValidationException::withMessages([
                'status' => ['Status must be approved or rejected.'],
            ]);
        }

        return DB::transaction(function () use (
            $review,
            $newStatus,
            $moderator,
            $note
        ) {
            $wasApproved = $review->status === 'approved';

            $review->update([
                'status'          => $newStatus,
                'moderation_note' => $note,
                'moderated_by'    => $moderator->id,
                'moderated_at'    => now(),
            ]);

            // Recalculate whenever the approved state changes.
            if ($wasApproved || $newStatus === 'approved') {
                $this->recalculateProductRating($review->product);
            }

            return $review->fresh(['user:id,name', 'product:id,name', 'moderator:id,name']);
        });
    }

    /**
     * Mark a review as helpful (one vote per user is out of scope — just increments).
     */
    public function markHelpful(Review $review): Review
    {
        $review->increment('helpful_count');
        return $review->fresh();
    }

    /**
     * Check whether the user has a delivered/paid order containing this product.
     */
    public function hasPurchased(User $user, Product $product): bool
    {
        return Order::where('user_id', $user->id)
            ->whereIn('status', ['delivered', 'shipped', 'processing', 'confirmed'])
            ->whereHas('items', function ($q) use ($product) {
                $q->where('product_id', $product->id);
            })
            ->exists();
    }

    /**
     * Recalculate products.rating and products.rating_count from approved reviews.
     * Called after every moderation change.
     *
     * @throws Throwable
     */
    public function recalculateProductRating(Product $product): void
    {
        if (!$product) return;

        $stats = Review::where('product_id', $product->id)
            ->where('status', 'approved')
            ->selectRaw('COALESCE(AVG(rating), 0) AS avg_rating, COUNT(*) AS total')
            ->first();

        $product->update([
            'rating'       => round((float) ($stats->avg_rating ?? 0), 2),
            'rating_count' => (int) ($stats->total ?? 0),
        ]);
    }

    /**
     * Get paginated approved reviews for a product.
     */
    public function getProductReviews(Product $product, int $perPage = 10, ?int $ratingFilter = null)
    {
        $query = Review::where('product_id', $product->id)
            ->where('status', 'approved')
            ->with(['user:id,name'])
            ->orderByDesc('helpful_count')
            ->orderByDesc('created_at');

        if ($ratingFilter) {
            $query->where('rating', $ratingFilter);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Rating breakdown (how many 5s, 4s, 3s...).
     */
    public function getRatingBreakdown(Product $product): array
    {
        $rows = Review::where('product_id', $product->id)
            ->where('status', 'approved')
            ->selectRaw('rating, COUNT(*) as count')
            ->groupBy('rating')
            ->pluck('count', 'rating')
            ->all();

        $breakdown = [];
        for ($i = 5; $i >= 1; $i--) {
            $breakdown[$i] = (int) ($rows[$i] ?? 0);
        }

        return $breakdown;
    }
}
