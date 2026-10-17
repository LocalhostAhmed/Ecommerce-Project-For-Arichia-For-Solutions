<?php

namespace App\Services;

use App\Models\InventoryMovement;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use RuntimeException;
use Throwable;

class InventoryService
{
    /**
     * Add stock to a product.
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function addStock(
        Product $product,
        int $quantity,
        string $reason = 'manual',
        ?string $note = null,
        ?int $userId = null
    ): InventoryMovement {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => ['The quantity to add must be greater than zero.'],
            ]);
        }

        return $this->applyMovement(
            product: $product,
            type: 'in',
            change: $quantity,
            reason: $reason,
            note: $note,
            userId: $userId,
        );
    }

    /**
     * Remove stock from a product.
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function removeStock(
        Product $product,
        int $quantity,
        string $reason = 'manual',
        ?string $note = null,
        ?int $userId = null
    ): InventoryMovement {
        if ($quantity <= 0) {
            throw ValidationException::withMessages([
                'quantity' => ['The quantity to remove must be greater than zero.'],
            ]);
        }

        if (!$product->allow_backorder && $product->stock_quantity < $quantity) {
            throw ValidationException::withMessages([
                'quantity' => [
                    "Insufficient stock. Available: {$product->stock_quantity}, requested: {$quantity}.",
                ],
            ]);
        }

        return $this->applyMovement(
            product: $product,
            type: 'out',
            change: -$quantity,
            reason: $reason,
            note: $note,
            userId: $userId,
        );
    }

    /**
     * Set an absolute stock value (e.g. after a physical count).
     *
     * @throws ValidationException
     * @throws Throwable
     */
    public function setStock(
        Product $product,
        int $newQuantity,
        string $reason = 'manual',
        ?string $note = null,
        ?int $userId = null
    ): InventoryMovement {
        if ($newQuantity < 0) {
            throw ValidationException::withMessages([
                'stock_quantity' => ['Stock quantity cannot be negative.'],
            ]);
        }

        $change = $newQuantity - $product->stock_quantity;

        return $this->applyMovement(
            product: $product,
            type: 'set',
            change: $change,
            reason: $reason,
            note: $note,
            userId: $userId,
            absoluteValue: $newQuantity,
        );
    }

    /**
     * Internal: apply a movement atomically with row locking.
     *
     * @throws Throwable
     */
    protected function applyMovement(
        Product $product,
        string $type,
        int $change,
        string $reason,
        ?string $note,
        ?int $userId,
        ?int $absoluteValue = null
    ): InventoryMovement {
        $movement = DB::transaction(function () use (
            $product,
            $type,
            $change,
            $reason,
            $note,
            $userId,
            $absoluteValue
        ) {
            // Lock the product row to serialize concurrent stock changes.
            $locked = Product::query()
                ->whereKey($product->id)
                ->lockForUpdate()
                ->firstOrFail();

            $before = $locked->stock_quantity;
            $after  = $absoluteValue !== null ? $absoluteValue : $before + $change;

            if ($after < 0 && !$locked->allow_backorder) {
                throw new RuntimeException(
                    'Resulting stock would be negative and backorders are not allowed.'
                );
            }

            $locked->stock_quantity = $after;
            $locked->save();

            $movement = InventoryMovement::create([
                'product_id'      => $locked->id,
                'type'            => $type,
                'quantity_change' => $after - $before,
                'quantity_before' => $before,
                'quantity_after'  => $after,
                'reason'          => $reason,
                'note'            => $note,
                'user_id'         => $userId,
            ]);

            // Refresh the original instance so the controller sees new values.
            $product->refresh();

            return $movement;
        });

        try {
            if ($product->isLowStock()) {
                app(NotificationService::class)->sendLowStockAlert($product);
            }
        } catch (Throwable $e) {
            Log::error('Low stock notification dispatch failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);
        }

        return $movement;
    }

    /**
     * Products whose stock is between 1 and their low_stock_threshold.
     */
    public function getLowStockProducts(int $perPage = 15)
    {
        return Product::query()
            ->where('is_active', true)
            ->where('stock_quantity', '>', 0)
            ->whereColumn('stock_quantity', '<=', 'low_stock_threshold')
            ->orderBy('stock_quantity', 'asc')
            ->paginate($perPage);
    }

    /**
     * Products with zero stock.
     */
    public function getOutOfStockProducts(int $perPage = 15)
    {
        return Product::query()
            ->where('is_active', true)
            ->where('stock_quantity', '<=', 0)
            ->orderBy('updated_at', 'desc')
            ->paginate($perPage);
    }
}
