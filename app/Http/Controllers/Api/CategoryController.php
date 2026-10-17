<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;
use Throwable;

class CategoryController extends Controller
{
    /**
     * GET: Retrieve all categories.
     */
    public function index()
    {
        try {
            $categories = Category::withCount('products')
                ->latest()
                ->paginate(10);

            return response()->json([
                'success' => true,
                'message' => 'Categories retrieved successfully.',
                'data' => $categories,
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Retrieving categories failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve categories.',
            ], 500);
        }
    }

    /**
     * POST: Create a category.
     */
    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => [
                    'required',
                    'string',
                    'max:255',
                    'unique:categories,name',
                ],
                'slug' => [
                    'required',
                    'string',
                    'max:255',
                    'alpha_dash',
                    'unique:categories,slug',
                ],
                'description' => [
                    'nullable',
                    'string',
                ],
                'image' => [
                    'nullable',
                    'string',
                    'max:2048',
                ],
                'is_active' => [
                    'sometimes',
                    'boolean',
                ],
            ]);

            $category = Category::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully.',
                'data' => $category,
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Creating category failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the category.',
            ], 500);
        }
    }

    /**
     * GET: Retrieve one category and its products.
     */
    public function show(Category $category)
    {
        try {
            $category->load('products');

            return response()->json([
                'success' => true,
                'message' => 'Category retrieved successfully.',
                'data' => $category,
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Retrieving category failed.', [
                'category_id' => $category->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve the category.',
            ], 500);
        }
    }

    /**
     * PUT/PATCH: Update a category.
     */
    public function update(
        Request $request,
        Category $category
    ) {
        try {
            $validated = $request->validate([
                'name' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    Rule::unique('categories', 'name')
                        ->ignore($category->id),
                ],
                'slug' => [
                    'sometimes',
                    'required',
                    'string',
                    'max:255',
                    'alpha_dash',
                    Rule::unique('categories', 'slug')
                        ->ignore($category->id),
                ],
                'description' => [
                    'sometimes',
                    'nullable',
                    'string',
                ],
                'image' => [
                    'sometimes',
                    'nullable',
                    'string',
                    'max:2048',
                ],
                'is_active' => [
                    'sometimes',
                    'boolean',
                ],
            ]);

            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully.',
                'data' => $category->fresh(),
            ], 200);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Updating category failed.', [
                'category_id' => $category->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the category.',
            ], 500);
        }
    }

    /**
     * DELETE: Delete a category without products.
     */
    public function destroy(Category $category)
    {
        try {
            if ($category->products()->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Cannot delete this category because it contains products.',
                ], 409);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully.',
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Deleting category failed.', [
                'category_id' => $category->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete the category.',
            ], 500);
        }
    }
}