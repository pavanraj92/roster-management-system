<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ShiftStoreRequest extends FormRequest
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
     * We use 24-hour time (H:i) and allow overnight shifts,
     * so end_time does NOT need to be after start_time.
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255', 'unique:shifts,name'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i', function ($attribute, $value, $fail) {
                $start = $this->input('start_time');

                // Convert times to minutes for comparison
                [$startHour, $startMin] = explode(':', $start);
                [$endHour, $endMin] = explode(':', $value);

                $startTotal = $startHour * 60 + $startMin;
                $endTotal = $endHour * 60 + $endMin;

                if ($endTotal <= $startTotal) {
                    $fail('End time must be after start time.');
                }
            }],
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'name.required'       => 'Shift name is required.',
            'name.string'         => 'Shift name must be a valid string.',
            'name.max'            => 'Shift name cannot exceed 255 characters.',
            'name.unique'         => 'Shift name already exists.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Start time must be in 24-hour format (HH:MM).',
            'end_time.required'   => 'End time is required.',
            'end_time.date_format' => 'End time must be in 24-hour format (HH:MM).',
        ];
    }
}
