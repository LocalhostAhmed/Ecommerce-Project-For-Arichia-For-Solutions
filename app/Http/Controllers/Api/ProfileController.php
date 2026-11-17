<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Throwable;

class ProfileController extends Controller
{
    private function publicStorageUrl(?string $path): ?string
    {
        if ($path === null || $path === '') {
            return null;
        }

        return asset('storage/' . ltrim($path, '/'));
    }

    public function show(Request $request)
    {
        $user = $request->user();

        return response()->json([
            'status' => true,
            'message' => 'Profile retrieved successfully.',
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'email_verified_at' => $user->email_verified_at,
                'profile_photo_url' => $this->publicStorageUrl(
                    $user->profile_photo_path
                ),
                'created_at' => $user->created_at,
            ],
        ]);
    }

    public function update(Request $request)
    {
        $user = $request->user();

        // Validate incoming data.
        $validated = $request->validate([
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'sometimes',
                'required',
                'email',
                'max:255',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'current_password' => [
                'required_with:password,email',
                'string',
            ],

            'password' => [
                'sometimes',
                'required',
                'string',
                'min:8',
                'confirmed',
            ],

            'profile_photo' => [
                'sometimes',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:2048',
            ],

            'remove_profile_photo' => [
                'sometimes',
                'boolean',
            ],
        ]);

        // Verify the current password when changing sensitive data.
        $emailIsChanging = isset($validated['email'])
            && $validated['email'] !== $user->email;

        $passwordIsChanging = isset($validated['password']);

        if ($emailIsChanging || $passwordIsChanging) {
            if (
                empty($validated['current_password'])
                || ! Hash::check(
                    $validated['current_password'],
                    $user->password
                )
            ) {
                return response()->json([
                    'status' => false,
                    'message' => 'The current password is incorrect.',
                    'errors' => [
                        'current_password' => [
                            'The current password is incorrect.',
                        ],
                    ],
                ], 422);
            }
        }

        try {
            $oldPhoto = $user->profile_photo_path;
            $newPhoto = null;

            // Upload a new profile photo if provided.
            if ($request->hasFile('profile_photo')) {
                $newPhoto = $request->file('profile_photo')
                    ->store('profile-photos', 'public');

                $user->profile_photo_path = $newPhoto;
            }

            // Update only the fields that were submitted.
            if (array_key_exists('name', $validated)) {
                $user->name = $validated['name'];
            }

            if ($emailIsChanging) {
                $user->email = $validated['email'];

                // Require verification of the new email address.
                $user->email_verified_at = null;
            }

            if ($passwordIsChanging) {
                // The User model's hashed cast hashes this password.
                $user->password = $validated['password'];
            }

            // Remove the existing photo if explicitly requested.
            if (
                ($validated['remove_profile_photo'] ?? false)
                && ! $request->hasFile('profile_photo')
            ) {
                $user->profile_photo_path = null;
            }

            $user->save();

            // Delete the old photo only after the new profile is saved.
            if (
                $oldPhoto
                && $oldPhoto !== $user->profile_photo_path
            ) {
                Storage::disk('public')->delete($oldPhoto);
            }

            // Send a verification link if the email changed.
            if ($emailIsChanging) {
                $user->sendEmailVerificationNotification();
            }

            return response()->json([
                'status' => true,
                'message' => $emailIsChanging
                    ? 'Profile updated. Please verify your new email address.'
                    : 'Profile updated successfully.',
                'data' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'email_verified_at' => $user->email_verified_at,
                    'profile_photo_url' => $this->publicStorageUrl(
                        $user->profile_photo_path
                    ),
                ],
            ]);
        } catch (Throwable $e) {
            Log::error('Profile update failed', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to update profile at this time.',
            ], 500);
        }
    }
}