<?php

namespace App\Http\Controllers\Api\Manager;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class ManagerAuthController extends Controller
{
    public function register(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:admins'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'role' => ['sometimes', 'string', Rule::in(['manager'])],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $admin = Admin::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->input('role', 'manager'),
            ]);

            event(new Registered($admin));

            $token = $admin->createToken('manager_auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Manager registered successfully.',
                'data' => [
                    'admin' => $admin,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation error',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Manager registration failed.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function login(Request $request): JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Validation failed',
                    'errors' => $validator->errors(),
                ], 422);
            }

            $admin = Admin::where('email', $request->email)->first();

            if (! $admin || ! Hash::check($request->password, $admin->password) || ! $admin->isManager()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Invalid manager credentials.',
                ], 401);
            }

            if (! $admin->hasVerifiedEmail()) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'Email not verified. Please verify first.',
                ], 403);
            }

            $admin->tokens()->delete();
            $token = $admin->createToken('manager_auth_token')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'Manager login successful.',
                'data' => [
                    'admin' => $admin,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Manager login failed.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        try {
            $admin = $request->user('manager');

            if ($admin) {
                $admin->currentAccessToken()?->delete();
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Logged out successfully.',
            ]);
        } catch (Throwable $exception) {
            return response()->json([
                'status' => 'error',
                'message' => 'Logout failed.',
                'error' => config('app.debug') ? $exception->getMessage() : null,
            ], 500);
        }
    }
}
