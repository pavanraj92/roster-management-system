<?php

namespace App\Http\Requests\Staff;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StaffRequest extends FormRequest
{
    /**
     * Determine if the staff is authorized to make this request.
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
        $staffId = $this->route('staff');
        $id = $staffId instanceof \App\Models\User ? $staffId->id : $staffId;

        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'designation' => 'required|string|max:255',
            'joining_date' => 'required|date',
            'avatar' => 'nullable|image|max:2048',
            'status' => 'nullable',
        ];

        if (!$id) {
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
