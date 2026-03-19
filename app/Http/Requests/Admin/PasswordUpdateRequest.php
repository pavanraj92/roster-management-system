<?php

namespace App\Http\Requests\Admin;

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
        return [
            'current_password' => 'required',
            'password' => 'required|min:8|confirmed',
        ];
    }

    protected function getRedirectUrl()
    {
        return route('admin.profile.index', ['tab' => 'password']);
    }
}
