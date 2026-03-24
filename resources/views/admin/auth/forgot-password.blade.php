@extends('admin.layouts.auth-layout')

@section('title', 'Forgot Password')

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
                            <h4 class="text-primary">Forgot Password?</h4>
                            <p class="text-muted">Enter your email to reset your password</p>
                        </div>

                        <div class="card-body">
                            @if (session('status'))
                                <div class="alert alert-success" role="alert">
                                    {{ session('status') }}
                                </div>
                            @endif

                            <form method="POST" action="{{ route('admin.password.email') }}" novalidate>
                                @csrf
                                <div class="mb-3">
                                    <input class="form-control @error('email') is-invalid @enderror" name="email"
                                        value="{{ old('email') }}" placeholder="Enter your email" type="email" required
                                        autofocus />
                                    @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <button type="submit"
                                        class="btn btn-primary w-100 d-flex justify-content-center align-items-center">
                                        Send Reset Link
                                    </button>
                                </div>
                            </form>

                            <p class="text-center mb-0">
                                Remember your Password? <a href="{{ route('admin.login') }}">Back to login</a>
                            </p>
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