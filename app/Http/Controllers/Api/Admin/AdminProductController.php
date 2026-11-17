<?php
// app/Http/Controllers/Admin/ProductController.php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Throwable;

class AdminProductController extends Controller
{
    public function categories(): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => Category::with('children')->whereNull('parent_id')->get(),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch categories');
        }
    }

    public function storeCategory(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'parent_id' => 'nullable|exists:categories,id',
            ]);

            $validated['slug'] = Str::slug($validated['name']);
            $category = Category::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Category created',
                'data' => $category,
            ], 201);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to create category');
        }
    }

    public function index(Request $request): JsonResponse
    {
        try {
            $products = Product::with('category')
                ->when($request->category_id, fn($q, $id) => $q->where('category_id', $id))
                ->when($request->low_stock, fn($q) => $q->whereColumn('stock', '<=', 'low_stock_threshold'))
                ->latest()
                ->paginate(20);

            return response()->json(['status' => 'success', 'data' => $products]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch products');
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'sku' => 'required|string|unique:products,sku',
                'category_id' => 'required|exists:categories,id',
                'price' => 'required|numeric|min:0',
                'stock' => 'required|integer|min:0',
                'low_stock_threshold' => 'integer|min:1',
            ]);

            $product = Product::create($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Product created',
                'data' => $product->load('category'),
            ], 201);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to create product');
        }
    }

    public function update(Request $request, Product $product): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'price' => 'sometimes|numeric|min:0',
                'stock' => 'sometimes|integer|min:0',
                'low_stock_threshold' => 'sometimes|integer|min:1',
                'is_active' => 'sometimes|boolean',
            ]);

            $product->update($validated);

            return response()->json([
                'status' => 'success',
                'message' => 'Product updated',
                'data' => $product->fresh('category'),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to update product');
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
