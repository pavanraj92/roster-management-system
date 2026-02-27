<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

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
            'tab'  => $tab
        ]);
    }

    /**
     * Update general profile details
     */
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            // 'email'      => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone'      => 'required|regex:/^[0-9]{10,20}$/|unique:users,phone,' . $user->id,
            'address_line1' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.profile.index', ['tab' => 'profile'])
                ->withErrors($validator)
                ->withInput();
        }

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
                'name'          => $user->first_name . ' ' . $user->last_name,
                'phone'         => $user->phone,
                'address_line1' => $request->address_line1,
            ]
        );
        return redirect()
            ->route('admin.profile.index', ['tab' => 'profile'])
            ->with('success', 'Profile updated successfully.');
    }

    /**
     * Change user password
     */
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password'         => 'required|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.profile.index', ['tab' => 'password'])
                ->withErrors($validator)
                ->withInput();
        }

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

    /**
     * Update profile avatar separately
     */
    public function updateProfileImage(Request $request)
    {
        $user = Auth::user();

        $validator = Validator::make($request->all(), [
            'avatar' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->route('admin.profile.index', ['tab' => 'profile'])
                ->withErrors($validator)
                ->withInput();
        }

        if ($request->hasFile('avatar')) {

            // Delete old avatar if exists
            if ($user->avatar && Storage::disk('public')->exists($user->avatar)) {
                Storage::disk('public')->delete($user->avatar);
            }

            // Store new avatar
            $path = $request->file('avatar')->store('users', 'public');

            $user->update([
                'avatar' => $path
            ]);
        }

        return redirect()
            ->route('admin.profile.index', ['tab' => 'profile'])
            ->with('success', 'Profile image updated successfully.');
    }
}
