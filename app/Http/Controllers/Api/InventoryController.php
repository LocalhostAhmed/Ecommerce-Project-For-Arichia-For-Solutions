<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Services\InventoryService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class InventoryController extends Controller
{
    public function __construct(
        protected InventoryService $inventoryService
    ) {}

    /**
     * GET /api/products/{product}/inventory
     * Show current stock + recent movements for one product.
     */
    public function show(Product $product)
    {
        try {
            $product->load(['inventoryMovements' => function ($q) {
                $q->limit(20);
            }]);

            return response()->json([
                'success' => true,
                'message' => 'Inventory retrieved successfully.',
                'data' => [
                    'product_id'          => $product->id,
                    'product_name'        => $product->name,
                    'stock_quantity'      => $product->stock_quantity,
                    'low_stock_threshold' => $product->low_stock_threshold,
                    'allow_backorder'     => $product->allow_backorder,
                    'is_low_stock'        => $product->isLowStock(),
                    'is_out_of_stock'     => $product->isOutOfStock(),
                    'is_purchasable'      => $product->isPurchasable(),
                    'recent_movements'    => $product->inventoryMovements,
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Inventory retrieval failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve inventory.',
            ], 500);
        }
    }

    /**
     * POST /api/products/{product}/inventory/add
     * Add stock.
     */
    public function add(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
                'reason'   => ['sometimes', 'string', 'max:50'],
                'note'     => ['sometimes', 'nullable', 'string', 'max:255'],
            ]);

            $movement = $this->inventoryService->addStock(
                product: $product,
                quantity: $validated['quantity'],
                reason: $validated['reason'] ?? 'manual',
                note: $validated['note'] ?? null,
                userId: $request->user()?->id,
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock added successfully.',
                'data' => [
                    'product_id'      => $product->id,
                    'stock_quantity'  => $product->fresh()->stock_quantity,
                    'movement'        => $movement,
                ],
            ], 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Inventory add failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
                'input'      => $request->only(['quantity', 'reason', 'note']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to add stock.',
            ], 500);
        }
    }

    /**
     * POST /api/products/{product}/inventory/remove
     * Remove stock.
     */
    public function remove(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'quantity' => ['required', 'integer', 'min:1', 'max:100000'],
                'reason'   => ['sometimes', 'string', 'max:50'],
                'note'     => ['sometimes', 'nullable', 'string', 'max:255'],
            ]);

            $movement = $this->inventoryService->removeStock(
                product: $product,
                quantity: $validated['quantity'],
                reason: $validated['reason'] ?? 'manual',
                note: $validated['note'] ?? null,
                userId: $request->user()?->id,
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock removed successfully.',
                'data' => [
                    'product_id'     => $product->id,
                    'stock_quantity' => $product->fresh()->stock_quantity,
                    'movement'       => $movement,
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Inventory remove failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
                'input'      => $request->only(['quantity', 'reason', 'note']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to remove stock.',
            ], 500);
        }
    }

    /**
     * PUT /api/products/{product}/inventory
     * Set an absolute stock value.
     */
    public function set(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'stock_quantity' => ['required', 'integer', 'min:0', 'max:1000000'],
                'reason'         => ['sometimes', 'string', 'max:50'],
                'note'           => ['sometimes', 'nullable', 'string', 'max:255'],
            ]);

            $movement = $this->inventoryService->setStock(
                product: $product,
                newQuantity: $validated['stock_quantity'],
                reason: $validated['reason'] ?? 'manual',
                note: $validated['note'] ?? null,
                userId: $request->user()?->id,
            );

            return response()->json([
                'success' => true,
                'message' => 'Stock level updated successfully.',
                'data' => [
                    'product_id'     => $product->id,
                    'stock_quantity' => $product->fresh()->stock_quantity,
                    'movement'       => $movement,
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Inventory set failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
                'input'      => $request->only(['stock_quantity', 'reason', 'note']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update stock level.',
            ], 500);
        }
    }

    /**
     * POST /api/inventory/bulk-update
     * Update stock for multiple products in one request.
     */
    public function bulkUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'items'                       => ['required', 'array', 'min:1', 'max:100'],
                'items.*.product_id'          => ['required', 'integer', 'exists:products,id'],
                'items.*.stock_quantity'      => ['required', 'integer', 'min:0', 'max:1000000'],
                'items.*.reason'              => ['sometimes', 'string', 'max:50'],
                'items.*.note'                => ['sometimes', 'nullable', 'string', 'max:255'],
            ]);

            $results = [];
            $errors  = [];

            foreach ($validated['items'] as $index => $item) {
                try {
                    $product = Product::findOrFail($item['product_id']);

                    $movement = $this->inventoryService->setStock(
                        product: $product,
                        newQuantity: $item['stock_quantity'],
                        reason: $item['reason'] ?? 'bulk_update',
                        note: $item['note'] ?? null,
                        userId: $request->user()?->id,
                    );

                    $results[] = [
                        'product_id'     => $product->id,
                        'stock_quantity' => $product->fresh()->stock_quantity,
                        'movement_id'    => $movement->id,
                    ];
                } catch (Throwable $e) {
                    $errors[] = [
                        'index'      => $index,
                        'product_id' => $item['product_id'] ?? null,
                        'message'    => $e->getMessage(),
                    ];
                }
            }

            return response()->json([
                'success' => empty($errors),
                'message' => empty($errors)
                    ? 'Bulk inventory update completed successfully.'
                    : 'Bulk inventory update completed with errors.',
                'data' => [
                    'updated'      => $results,
                    'failed'       => $errors,
                    'updated_count' => count($results),
                    'failed_count'  => count($errors),
                ],
            ], empty($errors) ? 200 : 207); // 207 Multi-Status

        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Bulk inventory update failed.', [
                'error' => $e->getMessage(),
                'input' => $request->only(['items']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to perform bulk inventory update.',
            ], 500);
        }
    }

    /**
     * GET /api/inventory/movements
     * List inventory movements (audit log).
     */
    public function movements(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_id' => ['sometimes', 'integer', 'exists:products,id'],
                'type'       => ['sometimes', Rule::in(['in', 'out', 'set', 'adjustment'])],
                'per_page'   => ['sometimes', 'integer', 'min:1', 'max:100'],
            ]);

            $query = \App\Models\InventoryMovement::query()
                ->with(['product:id,name', 'user:id,name'])
                ->orderByDesc('created_at');

            if (!empty($validated['product_id'])) {
                $query->where('product_id', $validated['product_id']);
            }

            if (!empty($validated['type'])) {
                $query->where('type', $validated['type']);
            }

            $movements = $query
                ->paginate($validated['per_page'] ?? 20)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Inventory movements retrieved successfully.',
                'data'    => $movements->items(),
                'pagination' => [
                    'current_page' => $movements->currentPage(),
                    'per_page'     => $movements->perPage(),
                    'total'        => $movements->total(),
                    'last_page'    => $movements->lastPage(),
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Inventory movements retrieval failed.', [
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve inventory movements.',
            ], 500);
        }
    }
}
