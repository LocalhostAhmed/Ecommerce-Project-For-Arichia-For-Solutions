<?php
// app/Http/Controllers/Admin/UserController.php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class UserController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        try {
            $users = User::query()
                ->when($request->search, fn($q, $search) => $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%"))
                ->latest()
                ->paginate(20);

            return response()->json(['status' => 'success', 'data' => $users]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch users');
        }
    }

    public function show(User $user): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => $user->loadCount('orders'),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch user');
        }
    }

    public function toggleActive(User $user): JsonResponse
    {
        try {
            $user->update(['is_active' => !$user->is_active]);

            return response()->json([
                'status' => 'success',
                'message' => 'User status updated',
                'data' => $user,
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to update user status');
        }
    }

    /**
     * Inline error handler (no Trait).
     */
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
