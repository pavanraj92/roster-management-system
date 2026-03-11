<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
     *
     * Same rules as store; 24-hour time and overnight shifts allowed.
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

