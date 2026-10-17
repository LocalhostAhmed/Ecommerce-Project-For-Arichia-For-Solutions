<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;
use Throwable;

class AuthController extends Controller
{
    /**
     * Register a new user.
     */
    public function register(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => [
                    'required',
                    'string',
                    'email',
                    'max:255',
                    'unique:users,email',
                ],
                'password' => [
                    'required',
                    'string',
                    'min:8',
                    'confirmed',
                ],
                'address' => ['required', 'string', 'max:255']
            ]);

            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'address' => $validated['address'],
            ]);

            // Send the verification email.
            try {
                $user->sendEmailVerificationNotification();
            } catch (Throwable $exception) {
                Log::error('Verification email delivery failed.', [
                    'user_id' => $user->id,
                    'exception' => $exception->getMessage(),
                ]);

                return response()->json([
                    'success' => false,
                    'message' => 'Account created, but the verification email could not be sent. Please request a new verification email.',
                    'data' => [
                        'user' => $user,
                    ],
                ], 201);
            }

            return response()->json([
                'success' => true,
                'message' => 'Registration successful. Please verify your email address.',
                'data' => [
                    'user' => $user,
                ],
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Registration failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred during registration.',
            ], 500);
        }
    }

    /**
     * Authenticate a user and issue a Sanctum token.
     */
    public function login(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'email' => ['required', 'email'],
                'password' => ['required', 'string'],
            ]);

            $user = User::where(
                'email',
                $validated['email']
            )->first();

            if (
                !$user ||
                !Hash::check(
                    $validated['password'],
                    $user->password
                )
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email or password.',
                ], 401);
            }

            // Do not issue tokens to unverified users.
            if (!$user->hasVerifiedEmail()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Please verify your email before logging in.',
                    'email_verified' => false,
                ], 403);
            }

            $token = $user->createToken('auth-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Login successful.',
                'data' => [
                    'user' => $user,
                    'token' => $token,
                    'token_type' => 'Bearer',
                ],
            ], 200);
        } catch (ValidationException $exception) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed.',
                'errors' => $exception->errors(),
            ], 422);
        } catch (Throwable $exception) {
            Log::error('Login failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred during login.',
            ], 500);
        }
    }

    /**
     * Verify a user's email using a signed URL.
     */
    public function verifyEmail(
        Request $request,
        string $id,
        string $hash
    ): JsonResponse {
        try {
            $user = User::find($id);

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found.',
                ], 404);
            }

            // Verify that the URL hash matches the user's email.
            if (!hash_equals(sha1($user->getEmailForVerification()), $hash)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid email verification link.',
                ], 403);
            }

            if ($user->hasVerifiedEmail()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Email address has already been verified.',
                ], 200);
            }

            // The signed middleware validates the URL signature.
            $user->markEmailAsVerified();

            event(new Verified($user));

            return response()->json([
                'success' => true,
                'message' => 'Email verified successfully. You can now log in.',
                'email_verified' => true,
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Email verification failed.', [
                'user_id' => $id,
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred during email verification.',
            ], 500);
        }
    }

    /**
     * Resend the email verification notification.
     */
    public function resendVerificationEmail(
        Request $request
    ): JsonResponse {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            if ($user->hasVerifiedEmail()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Your email is already verified.',
                ], 409);
            }

            $user->sendEmailVerificationNotification();

            return response()->json([
                'success' => true,
                'message' => 'Verification email sent successfully.',
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Resending verification email failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to send the verification email. Please try again later.',
            ], 500);
        }
    }

    /**
     * Revoke the current API token.
     */
    public function logout(Request $request): JsonResponse
    {
        try {
            $user = $request->user();

            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated.',
                ], 401);
            }

            $token = $user->currentAccessToken();

            if (!$token) {
                return response()->json([
                    'success' => false,
                    'message' => 'No revocable API token was found.',
                ], 400);
            }

            $token->delete();

            return response()->json([
                'success' => true,
                'message' => 'Logout successful.',
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Logout failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'An unexpected error occurred during logout.',
            ], 500);
        }
    }

    /**
     * Return the authenticated user's profile.
     */
    public function profile(Request $request): JsonResponse
    {
        try {
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $request->user(),
                    'email_verified' => $request->user()
                        ->hasVerifiedEmail(),
                ],
            ], 200);
        } catch (Throwable $exception) {
            Log::error('Profile retrieval failed.', [
                'exception' => $exception->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to retrieve your profile.',
            ], 500);
        }
    }
}
