<?php
// app/Http/Controllers/Admin/SettingController.php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Throwable;

class SettingController extends Controller
{
    public function index(): JsonResponse
    {
        try {
            return response()->json([
                'status' => 'success',
                'data' => StoreSetting::all()->pluck('value', 'key'),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to fetch settings');
        }
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'settings' => 'required|array',
                'settings.*.key' => 'required|string',
                'settings.*.value' => 'nullable|string',
            ]);

            foreach ($validated['settings'] as $item) {
                StoreSetting::set($item['key'], $item['value']);
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Settings updated',
                'data' => StoreSetting::all()->pluck('value', 'key'),
            ]);
        } catch (Throwable $e) {
            return $this->handleException($e, 'Failed to update settings');
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
