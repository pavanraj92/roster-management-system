<?php

namespace App\Http\Controllers\Frontend;

use App\Helpers\OtpHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\ForgotPasswordRequest;
use App\Http\Requests\Frontend\LoginRequest;
use App\Http\Requests\Frontend\RegisterRequest;
use App\Http\Requests\Frontend\ResetPasswordRequest;
use App\Models\User;
use App\Services\CommunicationService;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Log;

class AuthController extends Controller
{
    public function __construct(private readonly CommunicationService $communicationService)
    {
    }

    /**
     * Display the frontend login page.
     */
    public function showLoginForm()
    {
        return view('frontend.pages.auth.login');
    }

    /**
     * Display the frontend registration page.
     */
    public function showRegistrationForm()
    {
        return view('frontend.pages.auth.register');
    }

    /**
     * Display the forgot-password page.
     */
    public function showForgotPasswordForm()
    {
        return view('frontend.pages.auth.forgot-password');
    }

    /**
     * Send a password-reset link to the submitted email.
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('status', __($status))
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Display the reset-password form with token and email.
     */
    public function showResetPasswordForm(Request $request, string $token)
    {
        return view('frontend.pages.auth.reset-password', [
            'token' => $token,
            'email' => $request->email,
        ]);
    }

    /**
     * Reset the user's password using Laravel's password broker.
     */
    public function resetPassword(ResetPasswordRequest $request)
    {
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Register a new frontend staff and trigger email verification.
     */
    public function register(RegisterRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'first_name' => $validated['first_name'],
            'last_name' => $validated['last_name'] ?? null,
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'password' => Hash::make($validated['password']),
        ]);

        if (method_exists($user, 'assignRole')) {
            $user->assignRole('staff');
        }

        event(new Registered($user));

        Auth::login($user);
        // merge any guest cart (prefer persistent cookie token) into this user's cart
        // try {
        //     $this->cartService->mergeSessionCartIntoUser($request->cookie('cart_token') ?? $request->session()->getId(), $user->id);
        // } catch (\Throwable $e) {
        //     // swallow merge errors to avoid blocking login
        // }
      
        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Registration successful! Please verify your email.',
                'redirect' => route('verification.notice')
            ]);
        }

        return redirect()->route('verification.notice');
    }

    /**
     * Log in with email/phone + password.
     */
    public function login(LoginRequest $request)
    {
        $request->validated();

        $loginValue = $request->input('email');
        $password = $request->input('password');
        $loginField = str_contains($loginValue, '@') ? 'email' : 'phone';

        $user = User::where($loginField, $loginValue)->first();
        if (!$user) {
            $message = $loginField === 'email'
                ? 'Email does not match our records.'
                : 'Mobile number does not match our records.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['email' => [$message]],
                ], 422);
            }

            throw ValidationException::withMessages([
                'email' => [$message],
            ]);
        }

        if (!Hash::check($password, $user->password)) {
            $message = 'Password is incorrect.';

            if ($request->expectsJson() || $request->ajax()) {
                return response()->json([
                    'success' => false,
                    'errors' => ['password' => [$message]],
                ], 422);
            }

            throw ValidationException::withMessages([
                'password' => [$message],
            ]);
        }

        // Save old cart token or session id BEFORE regeneration
        $oldSessionId = $request->cookie('cart_token') ?? $request->session()->getId();

        Auth::login($user, $request->boolean('remember'));

        // Regenerate session for security
        $request->session()->regenerate();

        // Merge guest cart into user cart (using old cart token or session id)
        // try {
        //     $this->cartService->mergeSessionCartIntoUser($oldSessionId, $user->id);
        // } catch (\Throwable $e) {
        //     Log::error('Cart merge failed: ' . $e->getMessage());
        // }

        if ($request->expectsJson() || $request->ajax()) {
            return response()->json([
                'success' => true,
                'redirect' => route('home'),
            ]);
        }

        return redirect()->intended(route('home'));
    }

    /**
     * Generate and send/store login OTP for email/phone based login.
     */
    public function sendLoginOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string'],
        ]);

        $loginValue = trim($validated['email']);
        $loginField = str_contains($loginValue, '@') ? 'email' : 'phone';
        $user = User::where($loginField, $loginValue)->first();

        if (!$user) {
            $message = $loginField === 'email'
                ? 'Email does not match our records.'
                : 'Mobile number does not match our records.';

            return response()->json([
                'success' => false,
                'errors' => ['email' => [$message]],
            ], 422);
        }

        // Store OTP directly on user table as requested.
        $otp = OtpHelper::generate();
        $user->otp = $otp;
        $user->otp_verified_at = now();
        $user->save();

        $recipient = $loginField === 'email' ? (string) $user->email : (string) $user->phone;
        $sendResult = $this->communicationService->sendOtp($loginField, $recipient, $otp);
        if (!$sendResult['success']) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => [$sendResult['message']]],
            ], 422);
        }

        $response = [
            'success' => true,
            'message' => $sendResult['message'],
        ];

        return response()->json(array_merge(
            $response,
            $this->communicationService->otpDebugPayload($otp)
        ));
    }

    /**
     * Verify OTP and authenticate the user.
     */
    public function verifyLoginOtp(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'string'],
            'otp' => ['required', 'digits:6'],
            'remember' => ['nullable'],
        ]);

        $loginValue = trim($validated['email']);
        $loginField = str_contains($loginValue, '@') ? 'email' : 'phone';
        $user = User::where($loginField, $loginValue)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'errors' => ['email' => ['Account not found.']],
            ], 422);
        }

        $otpCheck = OtpHelper::verify($user->otp, $validated['otp'], $user->otp_verified_at);
        if (!$otpCheck['valid']) {
            return response()->json([
                'success' => false,
                'errors' => ['otp' => [$otpCheck['message']]],
            ], 422);
        }

        $user->otp = null;
        $user->otp_verified_at = now();
        $user->save();

        Auth::login($user, $request->boolean('remember'));
        $request->session()->regenerate();

        return response()->json([
            'success' => true,
            'redirect' => route('home'),
        ]);
    }

    /**
     * Log out the current user and clear the session.
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
