<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Throwable;

class ProductImageController extends Controller
{
    private function publicStorageUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    /**
     * GET /api/products/{product}/images
     */
    public function index(Product $product)
    {
        $images = $product->images()->get();

        return response()->json([
            'success' => true,
            'message' => 'Product images retrieved successfully.',
            'data' => $images->map(fn(ProductImage $image) => [
                'id' => $image->id,
                'product_id' => $image->product_id,
                'image_path' => $image->image_path,
                'image_url' => $this->publicStorageUrl($image->image_path),
                'is_primary' => $image->is_primary,
            ]),
        ]);
    }

    /**
     * POST /api/products/{product}/images
     */
    public function store(Request $request, Product $product)
    {
        $validated = $request->validate([
            'images' => ['required', 'array', 'min:1', 'max:10'],
            'images.*' => [
                'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
            'primary_image' => [
                'sometimes',
                'required',
                'integer',
                'min:0',
            ],
        ]);

        $files = $request->file('images');

        if (
            isset($validated['primary_image']) &&
            $validated['primary_image'] >= count($files)
        ) {
            throw ValidationException::withMessages([
                'primary_image' => [
                    'The primary_image index must match an uploaded image.',
                ],
            ]);
        }

        $storedPaths = [];

        try {
            // Store files first so we can clean them up if the DB fails.
            foreach ($files as $file) {
                $path = $file->store('products', 'public');

                if ($path === false) {
                    throw new \RuntimeException(
                        'Failed to store a product image.'
                    );
                }

                $storedPaths[] = $path;
            }

            $images = DB::transaction(function () use (
                $product,
                $storedPaths,
                $validated
            ) {
                // Serialize image changes for this product.
                Product::query()
                    ->whereKey($product->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $hasPrimary = $product->images()
                    ->where('is_primary', true)
                    ->exists();

                $primaryIndex = $validated['primary_image'] ?? null;

                foreach ($storedPaths as $index => $path) {
                    $makePrimary = $primaryIndex !== null
                        ? $index === $primaryIndex
                        : (!$hasPrimary && $index === 0);

                    if ($makePrimary) {
                        $product->images()
                            ->update(['is_primary' => false]);
                    }

                    $product->images()->create([
                        'image_path' => $path,
                        'is_primary' => $makePrimary,
                    ]);
                }

                return $product->images()->get();
            });

            return response()->json([
                'success' => true,
                'message' => 'Product images uploaded successfully.',
                'data' => $images->map(fn(ProductImage $image) => [
                    'id' => $image->id,
                    'image_url' => $this->publicStorageUrl($image->image_path),
                    'is_primary' => $image->is_primary,
                ]),
            ], 201);
        } catch (Throwable $e) {
            // Database rollback does not delete uploaded files.
            Storage::disk('public')->delete($storedPaths);

            Log::error('Product image upload failed.', [
                'product_id' => $product->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to upload product images.',
            ], 500);
        }
    }

    /**
     * PATCH /api/products/{product}/images/{image}/primary
     */
    public function setPrimary(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'This image does not belong to the selected product.',
            ], 404);
        }

        try {
            DB::transaction(function () use ($product, $image) {
                Product::query()
                    ->whereKey($product->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $product->images()
                    ->update(['is_primary' => false]);

                $image->update(['is_primary' => true]);
            });

            return response()->json([
                'success' => true,
                'message' => 'Main product image updated successfully.',
                'data' => [
                    'id' => $image->id,
                    'image_url' => $this->publicStorageUrl($image->image_path),
                    'is_primary' => true,
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Setting primary product image failed.', [
                'product_id' => $product->id,
                'image_id' => $image->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the main product image.',
            ], 500);
        }
    }

    /**
     * DELETE /api/products/{product}/images/{image}
     */
    public function destroy(Product $product, ProductImage $image)
    {
        if ($image->product_id !== $product->id) {
            return response()->json([
                'success' => false,
                'message' => 'This image does not belong to the selected product.',
            ], 404);
        }

        try {
            $deletedPath = DB::transaction(function () use (
                $product,
                $image
            ) {
                Product::query()
                    ->whereKey($product->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $wasPrimary = $image->is_primary;
                $path = $image->image_path;

                $image->delete();

                if ($wasPrimary) {
                    $nextImage = $product->images()
                        ->orderBy('id')
                        ->first();

                    if ($nextImage instanceof ProductImage) {
                        $nextImage->update(['is_primary' => true]);
                    }
                }

                return $path;
            });

            // Delete the physical file after the DB transaction succeeds.
            Storage::disk('public')->delete($deletedPath);

            return response()->json([
                'success' => true,
                'message' => 'Product image deleted successfully.',
            ]);
        } catch (Throwable $e) {
            Log::error('Product image deletion failed.', [
                'product_id' => $product->id,
                'image_id' => $image->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete the product image.',
            ], 500);
        }
    }
}