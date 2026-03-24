<?php

namespace App\Http\Requests\Profile;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class PasswordUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        // return [
        //     'current_password' => 'required',
        //     'password' => 'required|min:8|confirmed',
        //     'password_confirmation' => 'required|min:8'
        // ];

        return [
            'current_password' => 'required',
            'password' => [
                'required',
                'string',
                'min:8', // Minimum 8 characters
                'regex:/[a-z]/', // At least one lowercase letter
                'regex:/[A-Z]/', // At least one uppercase letter
                'regex:/[0-9]/', // At least one number
                'regex:/[@$!%*?&#^-_]/', // At least one special character
                'confirmed', // Must match password_confirmation
            ],
            'password_confirmation' => 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            'current_password.required' => 'Current password is required.',
            'password.required' => 'New password is required.',
            'password.min' => 'Password must be at least 8 characters long.',
            'password.regex' => 'Password must contain at least one uppercase letter, one lowercase letter, one number, and one special character (@$!%*?&#^-_).',
            'password.confirmed' => 'New password and confirmation do not match.',
            'password_confirmation.required' => 'Please confirm your new password.',
            'password_confirmation.min' => 'Confirmation password must be at least 8 characters long.',
        ];
    }


    protected function getRedirectUrl()
    {
        return route('admin.profile.index', ['tab' => 'password']);
    }
}
