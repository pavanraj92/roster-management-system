@extends('admin.layouts.auth-layout')

@section('title', 'Reset Password')

@section('content')
    @php
        // Site settings
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
                        <!-- Welcome / Site Name -->
                        <div class="text-center mt-4">
                            <h4 class="text-primary">Reset Your Password</h4>
                            <p class="text-muted">Enter a new password to continue to {{ $siteName }}.</p>
                        </div>

                        <div class="card-body">
                            <form method="POST" action="{{ route('admin.password.update') }}">
                                @csrf
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="email" value="{{ $email ?? old('email') }}">

                                <div class="mb-3 position-relative">
                                    <input type="password" name="password" placeholder="New Password"
                                        class="form-control @error('password') is-invalid @enderror"
                                        style="padding-right:45px;" autofocus>

                                    <span class="password-toggle"
                                        style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                                        <i class="ri-eye-off-line"></i>
                                    </span>

                                    @error('password')
                                        <span class="invalid-feedback d-block" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-3 position-relative">
                                    <input type="password" name="password_confirmation" placeholder="Confirm Password"
                                        class="form-control" style="padding-right:45px;">

                                    <span class="password-toggle"
                                        style="position:absolute; right:15px; top:50%; transform:translateY(-50%); cursor:pointer;">
                                        <i class="ri-eye-off-line"></i>
                                    </span>
                                </div>

                                <div class="mb-4">
                                    <button type="submit"
                                        class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
                                        Reset Password
                                    </button>
                                </div>
                            </form>
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
