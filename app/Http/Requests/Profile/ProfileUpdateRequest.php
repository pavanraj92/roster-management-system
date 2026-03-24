<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        $user = Auth::user();
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'phone' => 'nullable|regex:/^[0-9]{10,20}$/|unique:users,phone,' . $user->id,
            'address_line1' => 'nullable|string|max:255',
        ];
    }

    protected function getRedirectUrl()
    {
        return route('admin.profile.index', ['tab' => 'profile']);
    }
}
