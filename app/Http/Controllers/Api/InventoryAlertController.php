<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Throwable;

class InventoryAlertController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    /**
     * GET /api/inventory/low-stock
     */
    public function lowStock(Request $request)
    {
        try {
            $perPage  = min((int) $request->query('per_page', 15), 100);
            $products = $this->inventoryService->getLowStockProducts($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Low stock products retrieved successfully.',
                'data'    => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                    'last_page'    => $products->lastPage(),
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Low stock retrieval failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve low stock products.',
            ], 500);
        }
    }

    /**
     * GET /api/inventory/out-of-stock
     */
    public function outOfStock(Request $request)
    {
        try {
            $perPage  = min((int) $request->query('per_page', 15), 100);
            $products = $this->inventoryService->getOutOfStockProducts($perPage);

            return response()->json([
                'success' => true,
                'message' => 'Out of stock products retrieved successfully.',
                'data'    => $products->items(),
                'pagination' => [
                    'current_page' => $products->currentPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                    'last_page'    => $products->lastPage(),
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Out of stock retrieval failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve out of stock products.',
            ], 500);
        }
    }

    /**
     * GET /api/inventory/summary
     * Counts of low-stock, out-of-stock, and total inventory value.
     */
    public function summary()
    {
        try {
            $lowStock = \App\Models\Product::query()
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
                ->count();

            $outOfStock = \App\Models\Product::query()
                ->where('is_active', true)
                ->where('stock_quantity', '<=', 0)
                ->count();

            $inStock = \App\Models\Product::query()
                ->where('is_active', true)
                ->where('stock_quantity', '>', 0)
                ->count();

            $totalValue = \App\Models\Product::query()
                ->where('is_active', true)
                ->selectRaw('COALESCE(SUM(stock_quantity * price), 0) as total')
                ->value('total');

            return response()->json([
                'success' => true,
                'message' => 'Inventory summary retrieved successfully.',
                'data' => [
                    'in_stock_count'    => $inStock,
                    'low_stock_count'   => $lowStock,
                    'out_of_stock_count' => $outOfStock,
                    'total_stock_value' => (float) $totalValue,
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Inventory summary failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve inventory summary.',
            ], 500);
        }
    }
}
