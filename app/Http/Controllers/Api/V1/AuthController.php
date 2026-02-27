<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Api\V1\BaseController;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Http\Requests\Frontend\LoginRequest;
use App\Http\Requests\Frontend\ForgotPasswordRequest;
use App\Http\Requests\Frontend\ResetPasswordRequest;
use App\Http\Requests\Frontend\VerifyEmailOtpRequest;
use App\Mail\Api\EmailVerificationOtpMail;

class AuthController extends BaseController
{
    /**
     * Register API
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::create([
                'first_name' => $validated['first_name'],
                'last_name'  => $validated['last_name'] ?? null,
                'email'      => $validated['email'],
                'phone'      => $validated['phone'] ?? null,
                'password'   => Hash::make($validated['password']),
            ]);

            // Generate OTP (5 min expiry)
            $otp = (string) random_int(100000, 999999);

            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->otp_verified_at = null;
            $user->save();

            Mail::to($user->email)
                ->send(new EmailVerificationOtpMail($user, $otp));

            return $this->successResponse(
                'User registered successfully. Please verify your email using the OTP sent.',
                $user->only(['id', 'first_name', 'last_name', 'email', 'phone']),
                200
            );
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Login API
     */
    public function login(LoginRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                return $this->errorResponse('Account not found.', null, 404);
            }

            if ($user->status == 0) {
                return $this->errorResponse('Your account has been temporarily locked.', null, 403);
            }

            if (!$user->email_verified_at) {
                return $this->errorResponse('Please verify your email first.', null, 403);
            }

            if (!Hash::check($validated['password'], $user->password)) {
                return $this->errorResponse('Invalid email or password.', null, 401);
            }

            $user->tokens()->delete();
            $token = $user->createToken('mobile')->plainTextToken;

            return $this->successResponse(
                'User logged in successfully.',
                $user->only(['id', 'first_name', 'last_name', 'email', 'phone']),
                200,
                ['token' => $token]
            );
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Verify OTP (Used for Register + Forgot Password)
     */
    public function verifyEmailOtp(VerifyEmailOtpRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                return $this->errorResponse('Account not found.', null, 404);
            }

            if (!$user->otp) {
                return $this->errorResponse('No OTP found. Please request a new one.', null, 422);
            }

            if ($user->otp !== $validated['otp']) {
                return $this->errorResponse('Invalid OTP.', null, 422);
            }

            // 5 minute expiry check
            if (!$user->otp_expires_at || now()->gt($user->otp_expires_at)) {
                return $this->errorResponse('OTP expired. Please request a new one.', null, 422);
            }

            // Mark OTP verified
            $user->otp_verified_at = now();

            // If email not verified → this is Register flow
            if (!$user->email_verified_at) {
                $user->email_verified_at = now();
            }

            // Clear OTP
            $user->otp = null;
            $user->otp_expires_at = null;
            $user->save();

            return $this->successResponse('OTP verified successfully.');
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Forgot Password
     */
    public function forgotPassword(ForgotPasswordRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                return $this->errorResponse('This email address is not registered with us.', null, 404);
            }

            if ($user->status == 0) {
                return $this->errorResponse('Your account has been temporarily locked.', null, 403);
            }

            if (!$user->email_verified_at) {
                return $this->errorResponse('Please first verify your email!', null, 403);
            }

            // Generate OTP (5 min expiry)
            $otp = (string) random_int(100000, 999999);

            $user->otp = $otp;
            $user->otp_expires_at = now()->addMinutes(5);
            $user->otp_verified_at = null;
            $user->save();

            Mail::to($user->email)
                ->send(new EmailVerificationOtpMail($user, $otp));

            return $this->successResponse('Verification OTP sent to your email.');
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Reset Password (OTP verification required)
     */
    public function resetPassword(ResetPasswordRequest $request): JsonResponse
    {
        try {
            $validated = $request->validated();

            $user = User::where('email', $validated['email'])->first();

            if (!$user) {
                return $this->errorResponse('User not found.', null, 404);
            }

            // Ensure OTP was verified first
            if (!$user->otp_verified_at) {
                return $this->errorResponse('Please verify OTP first.', null, 422);
            }

            // Update password
            $user->password = Hash::make($validated['password']);

            // Reset OTP verification flag after password change
            $user->otp_verified_at = null;
            $user->save();

            return $this->successResponse('Password reset successfully.');
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Logout
     */
    public function logout(): JsonResponse
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return $this->errorResponse('Unauthenticated.', [], 401);
            }

            $user->currentAccessToken()->delete();

            return $this->successResponse('Logged out successfully.');
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }

    /**
     * Get Authenticated User
     */
    public function user(): JsonResponse
    {
        try {
            $user = auth()->user();

            if (!$user) {
                return $this->errorResponse('Unauthenticated.', [], 401);
            }

            return $this->successResponse(
                'User profile fetched successfully.',
                $user->only(['id', 'first_name', 'last_name', 'email', 'phone'])
            );
        } catch (\Throwable $e) {
            return $this->errorResponse('Something went wrong.', $e->getMessage(), 500);
        }
    }
}
