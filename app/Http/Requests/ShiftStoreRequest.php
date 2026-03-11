<?php

namespace App\Http\Requests;

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
     * so we do NOT require end_time to be after start_time.
     */
    public function rules(): array
    {
        return [
            'name'       => ['required', 'string', 'max:255'],
            'start_time' => ['required', 'date_format:H:i'],
            'end_time'   => ['required', 'date_format:H:i'],
        ];
    }
}

