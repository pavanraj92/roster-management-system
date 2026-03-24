<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
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
        return [
            'title' => 'required|string|max:255',
            'description' => [
                'required',
                'string',
                function (string $attribute, mixed $value, \Closure $fail) {
                    $plain = html_entity_decode(strip_tags((string) $value), ENT_QUOTES | ENT_HTML5);
                    $plain = preg_replace('/[\s\x{00A0}]+/u', '', $plain ?? '');
                    if ($plain === '') {
                        $fail('The description field is required.');
                    }
                },
            ],
            'status' => 'nullable|boolean',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'title.required' => 'The task title is required.',
            'description.required' => 'The task description is required.',
        ];
    }
}
