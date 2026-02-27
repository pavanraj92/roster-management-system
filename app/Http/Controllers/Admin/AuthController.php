<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Spatie\Permission\Models\Role;
use App\Models\User;
use App\Http\Requests\Admin\LoginRequest;
use App\Http\Requests\Admin\RegisterRequest;
use App\Http\Requests\Admin\ForgotPasswordRequest;
use App\Http\Requests\Admin\ResetPasswordRequest;
use Illuminate\Support\Facades\Mail;
use App\Mail\AdminPasswordResetMail;

class AuthController extends Controller
{
    /**
     * Display the login page
     */
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    /**
     * Display the register page
     */
    public function showRegister()
    {
        return view('admin.auth.register');
    }

    /**
     * Handle login request (placeholder for future implementation)
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            // $request->session()->regenerate();
            if (!$request->has('remember')) {
                setcookie('admin_login_email', '', time() - 3600, "/");
                setcookie('admin_login_pass', '', time() - 3600, "/");
            } else {
                // If Remember checked → set long cookies
                setcookie('admin_login_email', $request->email, time() + (86400 * 100), "/");
                setcookie('admin_login_pass', $request->password, time() + (86400 * 100), "/");
            }

            // return redirect()->intended(route('admin.dashboard'));
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle register request
     */
    public function register(RegisterRequest $request)
    {

        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'status' => true,
        ]);

        $user->assignRole(Role::findByName($request->role, 'admin'));

        // Auth::login($user);

        return redirect()->route('admin.login')->with('success', 'Account created successfully.');
    }

    /**
     * Handle logout request (placeholder for future implementation)
     */
    public function logout(Request $request)
    {
        Auth::logout();

        // Invalidate the session
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    /**
     * Display the forgot password form
     */
    public function showForgotPasswordForm()
    {
        return view('admin.auth.forgot-password');
    }

    /**
     * Send reset link email
     */
    public function sendResetLinkEmail(ForgotPasswordRequest $request)
    {
        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors(['email' => 'We can\'t find a user with that email address.']);
        }

        $token = Password::createToken($user);

        try {
            Mail::to($user->email)->send(new AdminPasswordResetMail($user, $token));
            return back()->with('status', 'We have emailed your password reset link!');
        } catch (\Exception $e) {
            return back()->withErrors(['email' => 'Failed to send email. Please try again later.']);
        }
    }

    /**
     * Display the reset password form
     */
    public function showResetPasswordForm(Request $request, $token)
    {
        return view('admin.auth.reset-password', ['token' => $token, 'email' => $request->email]);
    }

    /**
     * Handle reset password request
     */
    public function resetPassword(ResetPasswordRequest $request)
    {

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, $password) {
                $user->forceFill([
                    'password' => Hash::make($password)
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('admin.login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
