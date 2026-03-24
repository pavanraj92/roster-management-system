<?php

namespace App\Http\Requests\Shift;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ShiftUpdateRequest extends FormRequest
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
     */
    public function rules(): array
    {
        $shiftId = $this->route('shift');

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('shifts', 'name')->ignore($shiftId)->whereNull('deleted_at'),
            ],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time' => ['required', 'date_format:H:i', 'different:start_time'],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Shift name is required.',
            'name.string' => 'Shift name must be a valid string.',
            'name.max' => 'Shift name cannot exceed 255 characters.',
            'name.unique' => 'Shift name already exists.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Start time must be in 24-hour format (HH:MM).',
            'end_time.required' => 'End time is required.',
            'end_time.date_format' => 'End time must be in 24-hour format (HH:MM).',
        ];
    }
}
