@extends('admin.layouts.auth-layout')

@section('title', 'Admin Login')

@section('content')
    @php
        $login_email = $login_pass = $is_remember = '';
        if (isset($_COOKIE['admin_login_email']) && isset($_COOKIE['admin_login_pass'])) {
            $login_email = $_COOKIE['admin_login_email'];
            $login_pass = $_COOKIE['admin_login_pass'];
            $is_remember = "checked='checked'";
        }
    @endphp

    @php
        $setting = \App\Models\Setting::where('key', 'site_name')->first();
        $siteName = $setting->value ?? 'Roster';

        $setting = \App\Models\Setting::where('key', 'logo')->first();
        $logoPath = $setting && $setting->value ? storage_path('app/public/' . $setting->value) : null;
    @endphp

    <section class="content-main auth-page">
        <div class="container">
            <div class="row justify-content-center">
                <!-- Logo -->
                <div class="col-12 text-center mb-4">
                    <img src="{{ $setting && $setting->value && $logoPath && file_exists($logoPath) ? asset('storage/' . $setting->value) : asset('backend/imgs/theme/logo.png') }}"
                        class="logo" alt="Logo" />
                </div>
                <!-- Card -->
                <div class="col-md-6 col-lg-5">
                    <div class="card card-login">
                        <div class="text-center mt-4">
                            <h4 class="text-primary ">Welcome Back !</h4>
                            <p class="text-muted">Sign in to continue to {{ $siteName }}.</p>
                        </div>
                        <div class="card-body">
                            @if (session('error'))
                                <div class="alert alert-danger">
                                    {{ session('error') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.login') }}">
                                @csrf

                                <div class="mb-3">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email', $login_email ?? '') }}" placeholder="Username or email"
                                        type="text" />
                                    @error('email')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <input type="password" name="password" placeholder="Password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        style="padding-right: 45px;" value="{{ isset($login_pass) ? $login_pass : '' }}">

                                    <span class="password-toggle"
                                        style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                                        <i class="ri-eye-off-line"></i>
                                    </span>

                                    @error('password')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <a href="{{ route('admin.password.request') }}"
                                        class="float-end font-sm text-muted">Forgot password?</a>

                                    <label class="form-check">
                                        <input type="checkbox" class="form-check-input" name="remember"
                                            @checked(old('remember', !empty($is_remember))) />
                                        <span class="form-check-label">Remember</span>
                                    </label>
                                </div>

                                <div class="mb-4">
                                    <button type="submit"
                                        class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
                                        Login
                                    </button>
                                </div>
                            </form>

                            {{-- <p class="text-center mb-0">
                                Don't have an account?
                                <a href="{{ route('admin.register') }}">Sign up</a>
                            </p> --}}
                        </div>
                    </div>
                </div>

                {{-- <div class="col-12 text-center mb-4">
                    <p class="mb-0 text-muted">
                        <script>
                            document.write(new Date().getFullYear());
                        </script>
                        &copy; {{ $siteName }} Team. All rights reserved.
                    </p>
                </div> --}}
            </div>
        </div>
    </section>
    <!-- Footer Added -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-2 text-muted">
                            <script>
                                document.write(new Date().getFullYear());
                            </script>
                            &copy; {{ $siteName }} Team. All rights reserved.
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
@endsection
