<?php
// app/Http/Controllers/Admin/OrderController.php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class OrderController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $orders = Order::with('user', 'items.product')
                ->when($request->status, fn($q, $status) => $q->where('status', $status))
                ->when($request->payment_status, fn($q, $ps) => $q->where('payment_status', $ps))
                ->when($request->search, fn($q, $search) => $q->where('order_number', 'like', "%{$search}%"))
                ->latest()
                ->paginate(20);

            return response()->json(['status' => 'success', 'data' => $orders]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch orders');
        }
    }

    public function updateStatus(Request $request, Order $order): JsonResponse
    {
        try {
            $validated = $request->validate([
                'status' => 'required|in:pending,paid,shipped,delivered,cancelled',
            ]);

            $allowed = [
                'pending' => ['paid', 'cancelled'],
                'paid' => ['shipped', 'cancelled'],
                'shipped' => ['delivered'],
                'delivered' => [],
                'cancelled' => [],
            ];

            if (!in_array($validated['status'], $allowed[$order->status] ?? [])) {
                return response()->json([
                    'status' => 'error',
                    'message' => "Cannot transition from {$order->status} to {$validated['status']}",
                ], 422);
            }

            $order->update(['status' => $validated['status']]);

            return response()->json([
                'status' => 'success',
                'message' => 'Order status updated',
                'data' => $order->load('user', 'items.product'),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to update order status');
        }
    }

    private function handleException(Throwable $e, string $message): JsonResponse
    {
        if ($e instanceof ValidationException) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'errors' => $e->errors(),
            ], 422);
        }

        return response()->json([
            'status' => 'error',
            'message' => $message,
            'error' => config('app.debug') ? $e->getMessage() : null,
        ], 500);
    }
}
