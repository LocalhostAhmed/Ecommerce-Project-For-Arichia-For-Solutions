<?php
// app/Http/Controllers/Admin/InventoryController.php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class InventoryController extends Controller
{
    public function lowStock(): JsonResponse
    {
        try {
            $products = Product::whereColumn('stock', '<=', 'low_stock_threshold')
                ->orderBy('stock')
                ->get();

            return response()->json(['status' => 'success', 'data' => $products]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch low stock report');
        }
    }

    public function adjust(Request $request, Product $product): JsonResponse
    {
        try {
            $validated = $request->validate([
                'quantity' => 'required|integer',
                'reason' => 'required|string|max:255',
            ]);

            DB::transaction(function () use ($product, $validated) {
                $product->refreshForUpdate();

                $newStock = $product->stock + $validated['quantity'];
                if ($newStock < 0) {
                    throw new \RuntimeException('Insufficient stock for adjustment');
                }

                $product->update(['stock' => $newStock]);
            });

            return response()->json([
                'status' => 'success',
                'message' => 'Inventory adjusted',
                'data' => $product->fresh(),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Inventory adjustment failed');
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
