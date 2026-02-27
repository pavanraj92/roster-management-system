<?php

namespace App\Http\Requests\Frontend;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class LoginRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'email'    => [
                'required',
                'string',
                'max:255',
                function (string $attribute, mixed $value, \Closure $fail): void {
                    $input = trim((string) $value);
                    $isEmail = filter_var($input, FILTER_VALIDATE_EMAIL) !== false;
                    $isPhone = preg_match('/^[0-9]{10,20}$/', $input) === 1;

                    if (!$isEmail && !$isPhone) {
                        $fail('Please enter a valid email address or phone number.');
                    }
                },
            ],
            'password' => ['required', 'string', 'min:6'],
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'status'  => false,
            'code'    => 422,
            'message' => $validator->errors()->first(),
            'errors'  => $validator->errors(),
        ], 422));
    }
}
