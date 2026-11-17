<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class OrderAdminController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}


    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'status'   => ['sometimes', Rule::in(Order::STATUSES)],
                'search'   => ['sometimes', 'string', 'max:64'],
                'per_page' => ['sometimes', 'integer', 'min:1', 'max:100'],
            ]);

            $query = Order::with(['user:id,name,email', 'items'])
                ->orderByDesc('created_at');

            if (!empty($validated['status'])) {
                $query->where('status', $validated['status']);
            }

            if (!empty($validated['search'])) {
                $search = trim($validated['search']);
                $query->where(function ($q) use ($search) {
                    $q->where('order_number', 'like', "%{$search}%")
                        ->orWhere('shipping_name', 'like', "%{$search}%")
                        ->orWhere('shipping_email', 'like', "%{$search}%");
                });
            }

            $orders = $query
                ->paginate($validated['per_page'] ?? 20)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Admin orders retrieved successfully.',
                'data'    => $orders->items(),
                'pagination' => [
                    'current_page' => $orders->currentPage(),
                    'per_page'     => $orders->perPage(),
                    'total'        => $orders->total(),
                    'last_page'    => $orders->lastPage(),
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Admin orders retrieval failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve orders.',
            ], 500);
        }
    }


    public function updateStatus(Request $request, Order $order)
    {
        try {
            $validated = $request->validate([
                'status' => ['required', Rule::in(Order::STATUSES)],
                'note'   => ['sometimes', 'nullable', 'string', 'max:500'],
            ]);

            $updated = $this->orderService->updateStatus(
                order: $order,
                newStatus: $validated['status'],
                changedBy: $request->user()->id,
                note: $validated['note'] ?? null,
            );

            return response()->json([
                'success' => true,
                'message' => 'Order status updated successfully.',
                'data'    => $updated,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Admin order status update failed.', [
                'order_id' => $order->id,
                'error'    => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update order status.',
            ], 500);
        }
    }
}