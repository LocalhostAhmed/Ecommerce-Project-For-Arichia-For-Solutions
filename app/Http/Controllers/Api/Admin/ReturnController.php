<?php
// app/Http/Controllers/Admin/ReturnController.php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ReturnRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class ReturnController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $returns = ReturnRequest::with('order.user')
                ->when($request->status, fn($q, $s) => $q->where('status', $s))
                ->latest()
                ->paginate(20);

            return response()->json(['status' => 'success', 'data' => $returns]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch returns');
        }
    }

    public function approve(Request $request, ReturnRequest $return): JsonResponse
    {
        try {
            $validated = $request->validate([
                'refund_amount' => 'required|numeric|min:0.01',
            ]);

            DB::transaction(function () use ($return, $validated) {
                $order = Order::lockForUpdate()->findOrFail($return->order_id);

                if ($return->status !== 'pending') {
                    throw new \RuntimeException('Return already processed');
                }

                if ($validated['refund_amount'] > $order->total) {
                    throw new \RuntimeException('Refund amount exceeds order total');
                }

                $return->update([
                    'status' => 'refunded',
                    'refund_amount' => $validated['refund_amount'],
                    'processed_at' => now(),
                ]);

                $order->update(['payment_status' => 'refunded']);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Refund processed successfully',
                'data' => $return->fresh('order'),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Refund processing failed');
        }
    }

    public function reject(ReturnRequest $return): JsonResponse
    {
        try {
            if ($return->status !== 'pending') {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Only pending returns can be rejected',
                ], 422);
            }

            $return->update(['status' => 'rejected', 'processed_at' => now()]);

            return response()->json([
                'status' => 'success',
                'message' => 'Return rejected',
                'data' => $return,
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to reject return');
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
