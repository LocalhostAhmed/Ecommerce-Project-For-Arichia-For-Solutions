<?php
// app/Http/Controllers/Admin/DashboardController.php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\ReturnRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Throwable;

class DashboardController extends Controller
{
    public function stats(): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => [
                    'total_users' => User::count(),
                    'total_orders' => Order::count(),
                    'pending_returns' => ReturnRequest::where('status', 'pending')->count(),
                    'low_stock_count' => Product::whereColumn('stock', '<=', 'low_stock_threshold')->count(),
                ],
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch dashboard stats');
        }
    }

    public function bestSelling(): JsonResponse
    {
        try {
            $products = DB::table('order_items')
                ->join('products', 'order_items.product_id', '=', 'products.id')
                ->select('products.id', 'products.name', DB::raw('SUM(order_items.quantity) as total_sold'))
                ->groupBy('products.id', 'products.name')
                ->orderByDesc('total_sold')
                ->limit(10)
                ->get();

            return response()->json(['status' => 'success', 'data' => $products]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch best selling products');
        }
    }

    public function paymentReport(): JsonResponse
    {
        try {
            $report = Order::select(
                'payment_status',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(total) as total_amount')
            )->groupBy('payment_status')->get();

            return response()->json(['status' => 'success', 'data' => $report]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch payment report');
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
