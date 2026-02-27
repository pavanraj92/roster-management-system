@extends('admin.layouts.auth-layout')

@section('title', 'Admin Register')

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
                            <h4 class="text-primary">Welcome!</h4>
                            <p class="text-muted">Create an account to continue to {{ $siteName }}.</p>
                        </div>

                        <div class="card-body">
                            <h4 class="card-title mb-4 text-center">Create an Account</h4>

                            <form method="POST" action="{{ route('admin.register') }}">
                                @csrf

                                <div class="mb-3">
                                    <div class="row gx-2">
                                        <div class="col-6">
                                            <label class="form-label">First Name</label>
                                            <input class="form-control @error('first_name') is-invalid @enderror"
                                                name="first_name" type="text" placeholder="First Name"
                                                value="{{ old('first_name') }}" />
                                            @error('first_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-6">
                                            <label class="form-label">Last Name</label>
                                            <input class="form-control @error('last_name') is-invalid @enderror"
                                                name="last_name" placeholder="Last Name" type="text"
                                                value="{{ old('last_name') }}" />
                                            @error('last_name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input class="form-control @error('email') is-invalid @enderror" name="email"
                                        placeholder="Email" type="text" value="{{ old('email') }}" />
                                    @error('email')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Phone</label>
                                    <input class="form-control @error('phone') is-invalid @enderror" name="phone"
                                        placeholder="Phone" type="text" value="{{ old('phone') }}" />
                                    @error('phone')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Role</label>
                                    <select class="form-select @error('role') is-invalid @enderror" name="role">
                                        <option value="">Select Role</option>
                                        <option value="Admin" {{ old('role') == 'Admin' ? 'selected' : '' }}>Admin
                                        </option>
                                    </select>
                                    @error('role')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Create password</label>
                                    <input class="form-control @error('password') is-invalid @enderror" name="password"
                                        placeholder="Password" type="password" />
                                    @error('password')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Confirm password</label>
                                    <input class="form-control" name="password_confirmation" placeholder="Confirm Password"
                                        type="password" />
                                </div>

                                <!-- Terms -->
                                <div class="mb-3">
                                    <p class="small text-center text-muted">By signing up, you confirm that you've read and
                                        accepted our
                                        User Notice and Privacy Policy.</p>
                                </div>

                                <!-- Submit -->
                                <div class="mb-4">
                                    <button type="submit"
                                        class="btn btn-primary w-100 d-flex justify-content-center align-items-center">Register</button>
                                </div>
                            </form>

                            <p class="text-center mb-0">Already have an account? <a href="{{ route('admin.login') }}">Sign
                                    in now</a>
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
