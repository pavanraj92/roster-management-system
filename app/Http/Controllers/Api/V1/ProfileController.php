<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\JsonResponse;
use App\Http\Requests\Frontend\UpdateProfileRequest;
use App\Http\Requests\Frontend\ChangePasswordRequest;
use App\Http\Requests\Frontend\UpdateProfileImageRequest;

class ProfileController extends BaseController
{
    public function updateProfile(UpdateProfileRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();

            $user->update([
                'first_name' => $request->first_name,
                'last_name'  => $request->last_name,
                'phone'      => $request->phone,
            ]);

            // address update (same as admin logic)
            if (method_exists($user, 'admin_address')) {
                $user->admin_address()->updateOrCreate(
                    ['user_id' => $user->id],
                    [
                        'name'          => $user->first_name . ' ' . $user->last_name,
                        'phone'         => $user->phone,
                        'address_line1' => $request->address_line1,
                    ]
                );
            }

            return $this->successResponse(
                'Profile updated successfully.',
                $user->fresh() // avatar_url automatically included
            );
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    public function changePassword(ChangePasswordRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();

            // check current password
            if (!Hash::check($request->current_password, $user->password)) {
                return $this->errorResponse('Current password is incorrect.', [], 422);
            }

            // prevent same password
            if (Hash::check($request->password, $user->password)) {
                return $this->errorResponse('New password cannot be same as old password.', [], 422);
            }

            $user->update([
                'password' => Hash::make($request->password)
            ]);

            return $this->successResponse('Password changed successfully.');
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    public function updateProfileImage(UpdateProfileImageRequest $request): JsonResponse
    {
        try {
            $user = auth()->user();

            if ($request->hasFile('avatar')) {

                // delete old avatar
                if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $path = $request->file('avatar')->store('users', 'public');

                $user->update([
                    'avatar' => $path
                ]);
            }

            // fresh() will include avatar_url automatically
            return $this->successResponse(
                'Profile image updated successfully.',
                $user->fresh()
            );
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }
}