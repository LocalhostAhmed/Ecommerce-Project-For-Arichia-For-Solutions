<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class CouponController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Coupons retrieved successfully.',
                'data' => Coupon::latest()->paginate(20),
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Retrieving coupons failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve coupons.',
            ], 500);
        }
    }

    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'code' => ['required', 'string', 'max:64', 'unique:coupons,code'],
                'type' => ['required', 'string', Rule::in(['percentage', 'fixed'])],
                'value' => ['required', 'numeric', 'min:0'],
                'min_order_amount' => ['nullable', 'numeric', 'min:0'],
                'max_discount' => ['nullable', 'numeric', 'min:0'],
                'usage_limit' => ['nullable', 'integer', 'min:1'],
                'starts_at' => ['nullable', 'date'],
                'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
                'is_active' => ['sometimes', 'boolean'],
            ]);

            $coupon = Coupon::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Coupon created successfully.',
                'data' => $coupon,
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Creating coupon failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to create the coupon.',
            ], 500);
        }
    }

    public function show(Coupon $coupon): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'message' => 'Coupon retrieved successfully.',
                'data' => $coupon,
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Retrieving coupon failed.', [
                'coupon_id' => $coupon->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve the coupon.',
            ], 500);
        }
    }

    public function update(Request $request, Coupon $coupon): JsonResponse
    {
        try {
            $validated = $request->validate([
                'code' => ['sometimes', 'required', 'string', 'max:64', Rule::unique('coupons', 'code')->ignore($coupon->id)],
                'type' => ['sometimes', 'required', 'string', Rule::in(['percentage', 'fixed'])],
                'value' => ['sometimes', 'required', 'numeric', 'min:0'],
                'min_order_amount' => ['nullable', 'numeric', 'min:0'],
                'max_discount' => ['nullable', 'numeric', 'min:0'],
                'usage_limit' => ['nullable', 'integer', 'min:1'],
                'starts_at' => ['nullable', 'date'],
                'expires_at' => ['nullable', 'date', 'after_or_equal:starts_at'],
                'is_active' => ['sometimes', 'boolean'],
            ]);

            $coupon->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Coupon updated successfully.',
                'data' => $coupon->fresh(),
            ], 200);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Updating coupon failed.', [
                'coupon_id' => $coupon->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to update the coupon.',
            ], 500);
        }
    }

    public function destroy(Coupon $coupon): JsonResponse
    {
        try {
            $coupon->delete();

            return response()->json([
                'success' => true,
                'message' => 'Coupon deleted successfully.',
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Deleting coupon failed.', [
                'coupon_id' => $coupon->id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to delete the coupon.',
            ], 500);
        }
    }
}
