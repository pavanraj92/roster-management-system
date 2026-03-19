<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $userId = $this->route('user') ? (is_object($this->route('user')) ? $this->route('user')->id : $this->route('user')) : null;

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
            'roles' => 'required|array|min:1',
            'roles.*' => 'exists:roles,name',
        ];

        if (!$userId) {
            $rules['email'] = 'required|email|unique:users,email';
            $rules['phone'] = 'required|digits_between:7,15';
        }

        return $rules;
    }
}
