<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\Profile\ProfileUpdateRequest;
use App\Http\Requests\Profile\PasswordUpdateRequest;
use App\Http\Requests\Profile\ProfileImageUpdateRequest;

class ProfileController extends Controller
{
    /**
     * Show profile page with tab support
     */
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'profile');

        return view('admin.profile.index', [
            'user' => Auth::user(),
            'tab' => $tab
        ]);
    }

    public function updateProfile(ProfileUpdateRequest $request)
    {
        $user = Auth::user();

        $user->update($request->only([
            'first_name',
            'last_name',
            // 'email',
            'phone'
        ]));

        // Update or Create Admin Address
        $user->admin_address()->updateOrCreate(
        ['user_id' => $user->id], // condition
        [
            'name' => $user->first_name . ' ' . $user->last_name,
            'phone' => $user->phone,
            'address_line1' => $request->address_line1,
        ]
        );
        return redirect()
            ->route('admin.profile.index', ['tab' => 'profile'])
            ->with('success', 'Profile updated successfully.');
    }

    public function changePassword(PasswordUpdateRequest $request)
    {
        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()
                ->route('admin.profile.index', ['tab' => 'password'])
                ->withErrors(['current_password' => 'Current password is incorrect'])
                ->withInput();
        }

        // Prevent same password reuse
        if (Hash::check($request->password, $user->password)) {
            return redirect()
                ->route('admin.profile.index', ['tab' => 'password'])
                ->withErrors(['password' => 'New password cannot be same as old password'])
                ->withInput();
        }

        $user->update([
            'password' => Hash::make($request->password)
        ]);

        return redirect()
            ->route('admin.profile.index', ['tab' => 'password'])
            ->with('success', 'Password changed successfully.');
    }

    public function updateProfileImage(ProfileImageUpdateRequest $request)
    {
        $user = Auth::user();

        if ($request->hasFile('avatar')) {
            $user->uploadMedia($request->file('avatar'), 'avatar');
        }

        return redirect()
            ->route('admin.profile.index', ['tab' => 'profile'])
            ->with('success', 'Profile image updated successfully.');
    }
}
