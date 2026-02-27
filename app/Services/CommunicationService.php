<?php

namespace App\Services;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class CommunicationService
{
    /**
     * Send OTP using configured communication channel.
     *
     * @return array{success: bool, message: string}
     */
    public function sendOtp(string $channel, string $recipient, string $otp): array
    {
        if ($channel === 'email') {
            try {
                Mail::raw("Your login OTP is: {$otp}. It is valid for 10 minutes.", function ($message) use ($recipient) {
                    $message->to($recipient)->subject('Your Login OTP');
                });

                return [
                    'success' => true,
                    'message' => 'OTP sent to your email.',
                ];
            } catch (\Throwable $e) {
                return [
                    'success' => false,
                    'message' => 'Failed to send OTP email. Please try again.',
                ];
            }
        }

        // SMS provider is not integrated yet, so log OTP for now.
        Log::info('Phone OTP generated', [
            'phone' => $recipient,
            'otp' => $otp,
        ]);

        return [
            'success' => true,
            'message' => 'OTP generated for your mobile number.',
        ];
    }

    /**
     * Return OTP in response for local/development environments only.
     */
    public function otpDebugPayload(string $otp): array
    {
        if (app()->environment(['local', 'development'])) {
            return ['otp' => $otp];
        }

        return [];
    }
}
