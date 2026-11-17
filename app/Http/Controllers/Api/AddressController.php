<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Throwable;

class AddressController extends Controller
{

    public function index(Request $request)
    {
        $addresses = $request->user()
            ->addresses()
            ->latest()
            ->paginate(10);

        return response()->json([
            'status' => true,
            'message' => 'Addresses retrieved successfully.',
            'data' => $addresses,
        ]);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'label' => ['sometimes', 'string', 'max:100'],
            'recipient_name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'country' => ['required', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'city' => ['required', 'string', 'max:100'],
            'street_address' => ['required', 'string', 'max:255'],
            'apartment' => ['nullable', 'string', 'max:255'],
            'postal_code' => ['nullable', 'string', 'max:20'],
            'delivery_instructions' => ['nullable', 'string', 'max:2000'],

            'is_shipping' => ['sometimes', 'boolean'],
            'is_billing' => ['sometimes', 'boolean'],
            'is_default_shipping' => ['sometimes', 'boolean'],
            'is_default_billing' => ['sometimes', 'boolean'],
        ]);

        $isShipping = $validated['is_shipping'] ?? true;
        $isBilling = $validated['is_billing'] ?? false;

        if (($validated['is_default_shipping'] ?? false) && ! $isShipping) {
            throw ValidationException::withMessages([
                'is_default_shipping' => [
                    'The default shipping address must be enabled for shipping.',
                ],
            ]);
        }

        if (($validated['is_default_billing'] ?? false) && ! $isBilling) {
            throw ValidationException::withMessages([
                'is_default_billing' => [
                    'The default billing address must be enabled for billing.',
                ],
            ]);
        }

        if (! $isShipping && ! $isBilling) {
            throw ValidationException::withMessages([
                'is_shipping' => [
                    'An address must be enabled for shipping, billing, or both.',
                ],
            ]);
        }

        try {
            $address = DB::transaction(function () use (
                $request,
                $validated,
                $isShipping,
                $isBilling
            ) {
                $user = $request->user();

                $makeShippingDefault =
                    $validated['is_default_shipping'] ?? false;

                $makeBillingDefault =
                    $validated['is_default_billing'] ?? false;

                // Make the first eligible address the default automatically.
                if ($isShipping && ! $makeShippingDefault) {
                    $makeShippingDefault = ! $user->addresses()
                        ->where('is_default_shipping', true)
                        ->exists();
                }

                if ($isBilling && ! $makeBillingDefault) {
                    $makeBillingDefault = ! $user->addresses()
                        ->where('is_default_billing', true)
                        ->exists();
                }

                if ($makeShippingDefault) {
                    $user->addresses()->update([
                        'is_default_shipping' => false,
                    ]);
                }

                if ($makeBillingDefault) {
                    $user->addresses()->update([
                        'is_default_billing' => false,
                    ]);
                }

                return $user->addresses()->create(array_merge(
                    $validated,
                    [
                        'is_shipping' => $isShipping,
                        'is_billing' => $isBilling,
                        'is_default_shipping' => $makeShippingDefault,
                        'is_default_billing' => $makeBillingDefault,
                    ]
                ));
            });

            return response()->json([
                'status' => true,
                'message' => 'Address created successfully.',
                'data' => $address,
            ], 201);
        } catch (Throwable $e) {
            Log::error('Address creation failed', [
                'user_id' => $request->user()->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to create the address.',
            ], 500);
        }
    }


    public function show(Request $request, string $address)
    {
        $address = $request->user()
            ->addresses()
            ->findOrFail($address);

        return response()->json([
            'status' => true,
            'message' => 'Address retrieved successfully.',
            'data' => $address,
        ]);
    }


    public function update(Request $request, string $address)
    {
        $address = $request->user()
            ->addresses()
            ->findOrFail($address);

        $validated = $request->validate([
            'label' => ['sometimes', 'required', 'string', 'max:100'],
            'recipient_name' => ['sometimes', 'required', 'string', 'max:255'],
            'phone' => ['sometimes', 'required', 'string', 'max:30'],
            'country' => ['sometimes', 'required', 'string', 'max:100'],
            'state' => ['sometimes', 'nullable', 'string', 'max:100'],
            'city' => ['sometimes', 'required', 'string', 'max:100'],
            'street_address' => ['sometimes', 'required', 'string', 'max:255'],
            'apartment' => ['sometimes', 'nullable', 'string', 'max:255'],
            'postal_code' => ['sometimes', 'nullable', 'string', 'max:20'],
            'delivery_instructions' => [
                'sometimes',
                'nullable',
                'string',
                'max:2000',
            ],

            'is_shipping' => ['sometimes', 'boolean'],
            'is_billing' => ['sometimes', 'boolean'],
            'is_default_shipping' => ['sometimes', 'boolean'],
            'is_default_billing' => ['sometimes', 'boolean'],
        ]);

        $isShipping = $validated['is_shipping']
            ?? $address->is_shipping;

        $isBilling = $validated['is_billing']
            ?? $address->is_billing;

        if (! $isShipping && ! $isBilling) {
            throw ValidationException::withMessages([
                'is_shipping' => [
                    'An address must be enabled for shipping, billing, or both.',
                ],
            ]);
        }

        if (($validated['is_default_shipping'] ?? false) && ! $isShipping) {
            throw ValidationException::withMessages([
                'is_default_shipping' => [
                    'A default shipping address must be enabled for shipping.',
                ],
            ]);
        }

        if (($validated['is_default_billing'] ?? false) && ! $isBilling) {
            throw ValidationException::withMessages([
                'is_default_billing' => [
                    'A default billing address must be enabled for billing.',
                ],
            ]);
        }

        try {
            DB::transaction(function () use (
                $request,
                $address,
                $validated,
                $isShipping,
                $isBilling
            ) {
                $user = $request->user();

                $makeShippingDefault =
                    $validated['is_default_shipping']
                    ?? $address->is_default_shipping;

                $makeBillingDefault =
                    $validated['is_default_billing']
                    ?? $address->is_default_billing;

                // If an address stops being eligible, it cannot remain default.
                if (! $isShipping) {
                    $makeShippingDefault = false;
                }

                if (! $isBilling) {
                    $makeBillingDefault = false;
                }

                if ($makeShippingDefault) {
                    $user->addresses()
                        ->where('id', '!=', $address->id)
                        ->update(['is_default_shipping' => false]);
                }

                if ($makeBillingDefault) {
                    $user->addresses()
                        ->where('id', '!=', $address->id)
                        ->update(['is_default_billing' => false]);
                }

                $address->fill($validated);

                $address->is_shipping = $isShipping;
                $address->is_billing = $isBilling;
                $address->is_default_shipping = $makeShippingDefault;
                $address->is_default_billing = $makeBillingDefault;

                $address->save();
            });

            return response()->json([
                'status' => true,
                'message' => 'Address updated successfully.',
                'data' => $address->fresh(),
            ]);
        } catch (Throwable $e) {
            Log::error('Address update failed', [
                'user_id' => $request->user()->id,
                'address_id' => $address->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to update the address.',
            ], 500);
        }
    }


    public function setDefault(Request $request, string $address)
    {
        $validated = $request->validate([
            'type' => ['required', 'in:shipping,billing'],
        ]);

        $user = $request->user();

        $address = $user->addresses()->findOrFail($address);

        $type = $validated['type'];

        if ($type === 'shipping' && ! $address->is_shipping) {
            throw ValidationException::withMessages([
                'type' => ['This address is not enabled for shipping.'],
            ]);
        }

        if ($type === 'billing' && ! $address->is_billing) {
            throw ValidationException::withMessages([
                'type' => ['This address is not enabled for billing.'],
            ]);
        }

        try {
            DB::transaction(function () use ($user, $address, $type) {
                if ($type === 'shipping') {
                    $user->addresses()->update([
                        'is_default_shipping' => false,
                    ]);

                    $address->is_default_shipping = true;
                } else {
                    $user->addresses()->update([
                        'is_default_billing' => false,
                    ]);

                    $address->is_default_billing = true;
                }

                $address->save();
            });

            return response()->json([
                'status' => true,
                'message' => "Default {$type} address updated successfully.",
                'data' => $address->fresh(),
            ]);
        } catch (Throwable $e) {
            Log::error('Default address update failed', [
                'user_id' => $user->id,
                'address_id' => $address->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to set the default address.',
            ], 500);
        }
    }

    public function destroy(Request $request, string $address)
    {
        $user = $request->user();

        $address = $user->addresses()->findOrFail($address);

        try {
            DB::transaction(function () use ($user, $address) {
                $wasDefaultShipping = $address->is_default_shipping;
                $wasDefaultBilling = $address->is_default_billing;

                $address->delete();

                // Promote another eligible address if the default was deleted.
                if ($wasDefaultShipping) {
                    $replacement = $user->addresses()
                        ->where('is_shipping', true)
                        ->oldest('id')
                        ->first();

                    if ($replacement) {
                        $replacement->is_default_shipping = true;
                        $replacement->save();
                    }
                }

                if ($wasDefaultBilling) {
                    $replacement = $user->addresses()
                        ->where('is_billing', true)
                        ->oldest('id')
                        ->first();

                    if ($replacement) {
                        $replacement->is_default_billing = true;
                        $replacement->save();
                    }
                }
            });

            return response()->json([
                'status' => true,
                'message' => 'Address deleted successfully.',
            ]);
        } catch (Throwable $e) {
            Log::error('Address deletion failed', [
                'user_id' => $user->id,
                'address_id' => $address->id,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'status' => false,
                'message' => 'Unable to delete the address.',
            ], 500);
        }
    }
}