<?php

namespace App\Helpers;

use Illuminate\Support\Carbon;

class OtpHelper
{
    /**
     * Generate a numeric OTP string.
     */
    public static function generate(int $length = 6): string
    {
        $min = (int) str_pad('1', $length, '0');
        $max = (int) str_pad('', $length, '9');

        return (string) random_int($min, $max);
    }

    /**
     * Verify OTP value and expiry window.
     *
     * @return array{valid: bool, message: string|null}
     */
    public static function verify(
        ?string $storedOtp,
        ?string $inputOtp,
        mixed $otpGeneratedAt,
        int $expiryMinutes = 10
    ): array {
        if (empty($storedOtp) || empty($inputOtp) || !hash_equals((string) $storedOtp, (string) $inputOtp)) {
            return [
                'valid' => false,
                'message' => 'Invalid OTP.',
            ];
        }

        if (empty($otpGeneratedAt)) {
            return [
                'valid' => false,
                'message' => 'OTP expired. Please request a new one.',
            ];
        }

        $generatedAt = Carbon::parse($otpGeneratedAt);
        if ($generatedAt->lt(now()->subMinutes($expiryMinutes))) {
            return [
                'valid' => false,
                'message' => 'OTP expired. Please request a new one.',
            ];
        }

        return [
            'valid' => true,
            'message' => null,
        ];
    }
}
