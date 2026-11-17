<?php

namespace App\Http\Controllers\Api\Support;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\Review;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Throwable;

class SupportController extends Controller
{
    protected function ensureSupport(Request $request): ?Admin
    {
        $admin = $request->user('support');

        if (! $admin || ! $admin->isSupport()) {
            return null;
        }

        return $admin;
    }

    public function dashboard(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Support dashboard retrieved successfully.',
                'data' => [
                    'products' => Product::count(),
                    'categories' => Category::count(),
                    'orders' => Order::count(),
                    'users' => User::count(),
                    'pending_reviews' => Review::where('status', 'pending')->count(),
                ],
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve support dashboard.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function products(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => Product::with('category')->latest()->paginate(20),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve products.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function categories(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => Category::withCount('products')->latest()->paginate(20),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve categories.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function inventory(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => Product::with('category')->orderBy('stock_quantity', 'asc')->paginate(20),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve inventory.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function orders(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => Order::with('user')->latest()->paginate(20),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve orders.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function users(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => User::latest()->paginate(20),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve users.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function reviews(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            return response()->json([
                'success' => true,
                'data' => Review::with(['product', 'user'])->latest()->paginate(20),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve reviews.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function updateProfile(Request $request): JsonResponse
    {
        try {
            $admin = $this->ensureSupport($request);

            if (! $admin) {
                return response()->json([
                    'success' => false,
                    'message' => 'Forbidden. Support access required.',
                ], 403);
            }

            $validated = $request->validate([
                'name' => ['sometimes', 'string', 'max:255'],
                'email' => ['sometimes', 'email', 'max:255', 'unique:admins,email,' . $admin->id],
                'password' => ['sometimes', 'string', 'min:8', 'confirmed'],
            ]);

            if (isset($validated['password'])) {
                $validated['password'] = Hash::make($validated['password']);
            }

            $admin->fill($validated)->save();

            return response()->json([
                'success' => true,
                'message' => 'Profile updated successfully.',
                'data' => $admin->fresh(),
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Unable to update profile.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }
}
