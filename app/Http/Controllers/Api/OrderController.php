<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    /**
     * GET /api/orders
     * Paginated order history for the authenticated user.
     */
    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'status'   => ['sometimes', Rule::in(Order::STATUSES)],
                'per_page' => ['sometimes', 'integer', 'min:1', 'max:50'],
                'page'     => ['sometimes', 'integer', 'min:1'],
            ]);

            $query = Order::where('user_id', $request->user()->id)
                ->with(['items'])
                ->orderByDesc('created_at');

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            $orders = $query
                ->paginate($validated['per_page'] ?? 10)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Orders retrieved successfully.',
                'data' => $orders->items(),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page'     => $orders->perPage(),
                    'total'        => $orders->total(),
                    'last_page'    => $orders->lastPage(),
                    'next_page_url' => $orders->nextPageUrl(),
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Order history retrieval failed.', [
                'user_id' => $request->user()?->id,
                'error'   => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve orders.',
            ], 500);
        }
    }

    /**
     * GET /api/orders/{order}
     * Show one order — must belong to the user.
     */
    public function show(Request $request, Order $order)
    {
        try {
            if ($order->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.',
                ], 404);
            }

            $order->load(['items', 'statusHistory.changedBy:id,name']);

            return response()->json([
                'success' => true,
                'message' => 'Order retrieved successfully.',
                'data'    => $order,
            ]);
        } catch (Throwable $e) {
            Log::error('Order detail retrieval failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve order.',
            ], 500);
        }
    }

    /**
     * GET /api/orders/{order}/tracking
     * Status tracking timeline.
     */
    public function tracking(Request $request, Order $order)
    {
        try {
            if ($order->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.',
                ], 404);
            }

            $history = $order->statusHistory()
                ->orderBy('created_at')
                ->get()
                ->map(fn($h) => [
                    'status'     => $h->status,
                    'note'       => $h->note,
                    'changed_by' => $h->changedBy?->name,
                    'at'         => $h->created_at?->toIso8601String(),
                ]);

            return response()->json([
                'success' => true,
                'message' => 'Order tracking retrieved successfully.',
                'data' => [
                    'order_number'   => $order->order_number,
                    'current_status' => $order->status,
                    'timeline'       => $history,
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Order tracking retrieval failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve order tracking.',
            ], 500);
        }
    }

    /**
     * POST /api/orders/{order}/cancel
     */
    public function cancel(Request $request, Order $order)
    {
        try {
            if ($order->user_id !== $request->user()->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'Order not found.',
                ], 404);
            }

            $validated = $request->validate([
                'reason' => ['sometimes', 'nullable', 'string', 'max:500'],
            ]);

            $cancelled = $this->orderService->cancel(
                order: $order,
                reason: $validated['reason'] ?? 'Customer requested cancellation.',
                changedBy: $request->user()->id,
            );

            return response()->json([
                'success' => true,
                'message' => 'Order cancelled successfully.',
                'data'    => $cancelled,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Order cancellation failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to cancel order.',
            ], 500);
        }
    }
}
