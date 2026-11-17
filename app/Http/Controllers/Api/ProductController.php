<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Throwable;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        try {
            $validated = $request->validate([
                'search' => ['sometimes', 'nullable', 'string', 'max:255'],

                'category_id' => [
                    'sometimes',
                    'nullable',
                    'integer',
                    'min:1',
                    'exists:categories,id',
                ],

                'min_price' => ['sometimes', 'nullable', 'numeric', 'min:0'],

                'max_price' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                    'gte:min_price',
                ],

                'sort_by' => [
                    'sometimes',
                    'nullable',
                    'string',
                    Rule::in(['price', 'date', 'rating']),
                ],

                'sort_order' => [
                    'sometimes',
                    'nullable',
                    'string',
                    Rule::in(['asc', 'desc']),
                ],

                'per_page' => [
                    'sometimes',
                    'nullable',
                    'integer',
                    'min:1',
                    'max:50',
                ],

                'page' => ['sometimes', 'nullable', 'integer', 'min:1'],
            ]);
            $query = Product::query()->where('is_active', true);

            $query->with([
                'category',
                'images',
                'primaryImage',
            ]);

            if (! empty($validated['search'])) {
                $search = trim($validated['search']);

                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }
            if (! empty($validated['category_id'])) {
                $query->where('category_id', $validated['category_id']);
            }
            if (isset($validated['min_price'])) {
                $query->where('price', '>=', $validated['min_price']);
            }

            if (isset($validated['max_price'])) {
                $query->where('price', '<=', $validated['max_price']);
            }
            $sortBy    = $validated['sort_by'] ?? 'date';
            $sortOrder = $validated['sort_order'] ?? 'desc';

            switch ($sortBy) {
                case 'price':
                    $query->orderBy('price', $sortOrder);
                    break;

                case 'rating':
                    $query->orderBy('rating', $sortOrder);
                    $query->orderBy('rating_count', 'desc');
                    break;

                case 'date':
                default:
                    $query->orderBy('created_at', $sortOrder);
                    break;
            }

            $query->orderBy('id', 'desc');


            $products = $query
                ->paginate($validated['per_page'] ?? 10)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully.',
                'filters' => [
                    'search'      => $validated['search']      ?? null,
                    'category_id' => $validated['category_id'] ?? null,
                    'min_price'   => $validated['min_price']   ?? null,
                    'max_price'   => $validated['max_price']   ?? null,
                    'sort_by'     => $sortBy,
                    'sort_order'  => $sortOrder,
                ],
                'data' => $products->items(),
                'pagination' => [
                    'current_page'      => $products->currentPage(),
                    'per_page'          => $products->perPage(),
                    'total'             => $products->total(),
                    'last_page'         => $products->lastPage(),
                    'from'              => $products->firstItem(),
                    'to'                => $products->lastItem(),
                    'next_page_url'     => $products->nextPageUrl(),
                    'previous_page_url' => $products->previousPageUrl(),
                ],
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Failed to retrieve products.', [
                'error'   => $e->getMessage(),
                'filters' => $request->only([
                    'search',
                    'category_id',
                    'min_price',
                    'max_price',
                    'sort_by',
                    'sort_order',
                    'per_page',
                    'page',
                ]),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve products.',
            ], 500);
        }
    }


    public function store(Request $request)
    {
        try {
            if (blank($request->input('slug')) && $request->filled('name')) {
                $request->merge([
                    'slug' => Str::slug($request->input('name')),
                ]);
            }

            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'alpha_dash',
                    Rule::unique('products', 'slug'),
                ],
                'description' => ['required', 'string'],
                'price' => ['required', 'numeric', 'min:0'],
                'compare_at_price' => [
                    'nullable',
                    'numeric',
                    'gt:price',
                ],
                'sku' => [
                    'required',
                    'string',
                    'max:100',
                    'unique:products,sku',
                ],
                'category_id' => [
                    'required',
                    'integer',
                    'exists:categories,id',
                ],
                'brand' => ['nullable', 'string', 'max:255'],
                'stock' => ['required', 'integer', 'min:0'],

                'image' => ['nullable', 'string', 'max:2048'],

                'is_active' => ['sometimes', 'boolean'],
            ]);

            $product = Product::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'data' => $product->load('category'),
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Creating product failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the product.',
            ], 500);
        }
    }


    public function show(Product $product)
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Product retrieved successfully.',
                'data' => $product->load('category'),
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Retrieving product failed.', [
                'product_id' => $product->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve the product.',
            ], 500);
        }
    }

    public function update(Request $request, Product $product)
    {
        try {
            if (blank($request->input('slug')) && $request->filled('name')) {
                $request->merge([
                    'slug' => Str::slug($request->input('name')),
                ]);
            }

            $validated = $request->validate([
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'slug' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    'alpha_dash',
                    Rule::unique('products', 'slug')
                        ->ignore($product->id),
                ],
                'description' => ['sometimes', 'required', 'string'],
                'price' => [
                    'sometimes',
                    'required',
                    'numeric',
                    'min:0',
                ],
                'compare_at_price' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                ],
                'sku' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:100',
                    Rule::unique('products', 'sku')
                        ->ignore($product->id),
                ],
                'category_id' => [
                    'sometimes',
                    'required',
                    'integer',
                    'exists:categories,id',
                ],
                'brand' => ['sometimes', 'nullable', 'string', 'max:255'],
                'stock' => [
                    'sometimes',
                    'required',
                    'integer',
                    'min:0',
                ],
                'image' => ['sometimes', 'nullable', 'string', 'max:2048'],
                'is_active' => ['sometimes', 'boolean'],
            ]);

            $product->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
                'data' => $product->fresh()->load('category'),
            ], 200);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Updating product failed.', [
                'product_id' => $product->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the product.',
            ], 500);
        }
    }

    public function destroy(Product $product)
    {
        try {
            $product->delete();

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.',
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Deleting product failed.', [
                'product_id' => $product->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete the product.',
            ], 500);
        }
    }

    public function index1(Request $request)
    {
        try {
            $validated = $request->validate([
                'search' => ['sometimes', 'nullable', 'string', 'max:255'],

                'category_id' => [
                    'sometimes',
                    'nullable',
                    'integer',
                    'min:1',
                    'exists:categories,id',
                ],

                'min_price' => ['sometimes', 'nullable', 'numeric', 'min:0'],

                'max_price' => [
                    'sometimes',
                    'nullable',
                    'numeric',
                    'min:0',
                    'gte:min_price',
                ],

                'sort_by' => [
                    'sometimes',
                    'nullable',
                    'string',
                    Rule::in(['price', 'date', 'rating']),
                ],

                'sort_order' => [
                    'sometimes',
                    'nullable',
                    'string',
                    Rule::in(['asc', 'desc']),
                ],

                'per_page' => [
                    'sometimes',
                    'nullable',
                    'integer',
                    'min:1',
                    'max:50',
                ],

                'page' => ['sometimes', 'nullable', 'integer', 'min:1'],
            ]);

            $query = Product::query()->where('is_active', true);

            $query->with([
                'category',
                'images',
                'primaryImage',
            ]);


            if (!empty($validated['search'])) {
                $search = trim($validated['search']);

                $query->where(function ($subQuery) use ($search) {
                    $subQuery
                        ->where('name', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%");
                });
            }

            if (!empty($validated['category_id'])) {
                $query->where('category_id', $validated['category_id']);
            }

            if (isset($validated['min_price'])) {
                $query->where('price', '>=', $validated['min_price']);
            }

            if (isset($validated['max_price'])) {
                $query->where('price', '<=', $validated['max_price']);
            }
            $sortBy    = $validated['sort_by'] ?? 'date';
            $sortOrder = $validated['sort_order'] ?? 'desc';

            switch ($sortBy) {
                case 'price':
                    $query->orderBy('price', $sortOrder);
                    break;

                case 'rating':
                    $query->orderBy('rating', $sortOrder);
                    $query->orderBy('rating_count', 'desc');
                    break;

                case 'date':
                default:
                    $query->orderBy('created_at', $sortOrder);
                    break;
            }

            $query->orderBy('id', 'desc');

            $products = $query
                ->paginate($validated['per_page'] ?? 10)
                ->withQueryString();

            return response()->json([
                'success' => true,
                'message' => 'Products retrieved successfully.',
                'filters' => [
                    'search'      => $validated['search']      ?? null,
                    'category_id' => $validated['category_id'] ?? null,
                    'min_price'   => $validated['min_price']   ?? null,
                    'max_price'   => $validated['max_price']   ?? null,
                    'sort_by'     => $sortBy,
                    'sort_order'  => $sortOrder,
                ],
                'data' => $products->items(),
                'pagination' => [
                    'current_page'      => $products->currentPage(),
                    'per_page'          => $products->perPage(),
                    'total'             => $products->total(),
                    'last_page'         => $products->lastPage(),
                    'from'              => $products->firstItem(),
                    'to'                => $products->lastItem(),
                    'next_page_url'     => $products->nextPageUrl(),
                    'previous_page_url' => $products->previousPageUrl(),
                ],
            ]);
        } catch (ValidationException $e) {
            // Let Laravel's default validation response pass through.
            throw $e;
        } catch (Throwable $e) {
            Log::error('Failed to retrieve products.', [
                'error'   => $e->getMessage(),
                'filters' => $request->only([
                    'search',
                    'category_id',
                    'min_price',
                    'max_price',
                    'sort_by',
                    'sort_order',
                    'per_page',
                    'page',
                ]),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve products. Please try again later.',
            ], 500);
        }
    }

    public function store1(Request $request)
    {
        try {
            $validated = $request->validate([
                'name'        => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string'],
                'price'       => ['required', 'numeric', 'min:0'],
                'category_id' => ['required', 'integer', 'exists:categories,id'],
                'is_active'   => ['sometimes', 'boolean'],
                'image'       => [
                    'sometimes',
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ]);

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('products', 'public');

                if ($imagePath === false) {
                    throw new \RuntimeException('Failed to store the product image.');
                }
            }

            $product = DB::transaction(function () use ($validated, $imagePath) {
                $product = Product::create([
                    'name'        => $validated['name'],
                    'description' => $validated['description'] ?? null,
                    'price'       => $validated['price'],
                    'category_id' => $validated['category_id'],
                    'is_active'   => $validated['is_active'] ?? true,
                    'image'       => $imagePath,
                ]);

                return $product;
            });

            $product->load(['category', 'images', 'primaryImage']);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully.',
                'data'    => $product,
            ], 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            Log::error('Product creation failed.', [
                'error' => $e->getMessage(),
                'input' => $request->except(['image']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the product.',
            ], 500);
        }
    }
    public function show1(Product $product)
    {
        try {
            $product->load([
                'category',
                'images',
                'primaryImage',
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Product retrieved successfully.',
                'data'    => $product,
            ]);
        } catch (Throwable $e) {
            Log::error('Product retrieval failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve the product.',
            ], 500);
        }
    }

    public function update1(Request $request, Product $product)
    {
        try {
            $validated = $request->validate([
                'name'        => ['sometimes', 'string', 'max:255'],
                'description' => ['sometimes', 'nullable', 'string'],
                'price'       => ['sometimes', 'numeric', 'min:0'],
                'category_id' => ['sometimes', 'integer', 'exists:categories,id'],
                'is_active'   => ['sometimes', 'boolean'],
                'image'       => [
                    'sometimes',
                    'nullable',
                    'image',
                    'mimes:jpg,jpeg,png,webp',
                    'max:5120',
                ],
            ]);

            $newImagePath = null;
            $oldImagePath = $product->image;

            if ($request->hasFile('image')) {
                $newImagePath = $request->file('image')->store('products', 'public');

                if ($newImagePath === false) {
                    throw new \RuntimeException('Failed to store the new product image.');
                }

                $validated['image'] = $newImagePath;
            }

            DB::transaction(function () use ($product, $validated) {
                $product->update($validated);
            });

            // Delete the old file only after the DB update succeeds.
            if ($newImagePath && $oldImagePath) {
                Storage::disk('public')->delete($oldImagePath);
            }

            $product->load(['category', 'images', 'primaryImage']);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully.',
                'data'    => $product,
            ]);
        } catch (ValidationException $e) {
            throw $e;
        } catch (Throwable $e) {
            // Cleanup: remove the newly uploaded file if the update failed.
            if (!empty($newImagePath)) {
                Storage::disk('public')->delete($newImagePath);
            }

            Log::error('Product update failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
                'input'      => $request->except(['image']),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the product.',
            ], 500);
        }
    }

    public function destroy1(Product $product)
    {
        try {
            $imagePaths = [];

            // Collect all physical image paths before deleting.
            if (!empty($product->image)) {
                $imagePaths[] = $product->image;
            }

            $imagePaths = array_merge(
                $imagePaths,
                $product->images()->pluck('image_path')->all()
            );

            DB::transaction(function () use ($product) {
                $product->delete();
            });

            // Delete physical files only after the DB commit succeeds.
            if (!empty($imagePaths)) {
                Storage::disk('public')->delete($imagePaths);
            }

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully.',
            ]);
        } catch (Throwable $e) {
            Log::error('Product deletion failed.', [
                'product_id' => $product->id,
                'error'      => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete the product.',
            ], 500);
        }
    }
}
