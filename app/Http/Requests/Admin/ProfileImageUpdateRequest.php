<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class ProfileImageUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'avatar' => 'required|image|mimes:jpg,jpeg,png,svg|max:2048',
        ];
    }

    protected function getRedirectUrl()
    {
        return route('admin.profile.index', ['tab' => 'profile']);
    }
}
