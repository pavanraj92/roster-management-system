<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

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
        $staffId = $this->route('staff') ? (is_object($this->route('staff')) ? $this->route('staff')->id : $this->route('staff')) : null;

        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email,' . $staffId,
            'phone' => 'required|digits_between:7,15',
            'designation'  => 'required|string|max:255',
            'joining_date' => 'required|date',
            'avatar'       => 'nullable|image|max:2048',
            'status'       => 'nullable|boolean',
        ];
    }
}
