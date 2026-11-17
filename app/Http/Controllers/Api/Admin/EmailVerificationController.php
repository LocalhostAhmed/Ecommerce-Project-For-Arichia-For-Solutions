<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;

class EmailVerificationController extends Controller
{

    public function verify(EmailVerificationRequest $request): JsonResponse
    {
        try {
            $admin = $request->user('admin') ?? $request->user() ?? \App\Models\Admin::findOrFail($request->route('id'));

            if ($admin->hasVerifiedEmail()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Email already verified'
                ]);
            }

            if ($admin->markEmailAsVerified()) {
                event(new Verified($admin));
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Email verified successfully'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Verification failed.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }



    public function resend(Request $request): JsonResponse
    {
        try {
            $admin = $request->user('admin');

            if ($admin->hasVerifiedEmail()) {
                return response()->json([
                    'status' => 'success',
                    'message' => 'Email already verified'
                ]);
            }

            $admin->sendEmailVerificationNotification();

            return response()->json([
                'status' => 'success',
                'message' => 'Verification link sent'
            ]);
        } catch (Throwable $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Failed to send verification email.',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }
}
