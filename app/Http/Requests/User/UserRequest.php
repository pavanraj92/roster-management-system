<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

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
        $user = $this->route('user');
        $isUpdate = $user !== null;

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'nullable|boolean',
            'roles' => 'required|array|min:1',
            'roles.*'    => [
                Rule::exists('roles', 'name')
                    ->where('guard_name', 'web')
                    ->whereNotIn('name', ['admin', 'super-admin']),
            ],
        ];

        if (!$isUpdate) {
            $rules['email'] = [
                'required', 'email',
                Rule::unique('users', 'email')->whereNull('deleted_at')
            ];
            $rules['phone'] = [
                'required', 'digits_between:7,15',
                Rule::unique('users', 'phone')->whereNull('deleted_at')
            ];
        }

        return $rules;
    }
}
