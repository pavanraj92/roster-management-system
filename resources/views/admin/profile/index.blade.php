@extends('admin.layouts.app')
@section('title', 'Profile Setting')

@section('content')
{{-- @dd(auth()->user()->roles) --}}
<section class="content-main">
    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Profile Setting</h2>
                <p class="listing-page-subtitle mb-3">Manage your personal information and account security.</p>
            </div>

            <!-- Right side: Breadcrumb -->
            <x-admin.breadcrumb :list="[['label' => 'Profile Setting']]" class="float-end" />
        </div>
    </div>

    <div class="content-header">
        <div>
        </div>
    </div>

    @if (session('success'))
    @include('admin.layouts.flash_message')
    @endif

    <div class="card">
        <div class="card-body">
            <div class="row gx-5">
                <!-- Sidebar -->
                <aside class="col-lg-3 border-end">
                    <nav class="nav nav-pills flex-lg-column mb-4">
                        <a class="nav-link {{ $tab == 'profile' ? 'active' : '' }}"
                            href="{{ route('admin.profile.index', ['tab' => 'profile']) }}">
                            Update Profile
                        </a>
                        <a class="nav-link {{ $tab == 'password' ? 'active' : '' }}"
                            href="{{ route('admin.profile.index', ['tab' => 'password']) }}">
                            Change Password
                        </a>
                    </nav>
                </aside>

                <div class="col-lg-9">
                    <section class="content-body p-xl-4">

                        {{-- ================= PROFILE TAB ================= --}}
                        @if ($tab == 'profile')
                        <div class="row">

                            <!-- LEFT SIDE FORM -->
                            <div class="col-lg-8">
                                <form action="{{ route('admin.profile.update') }}" method="POST">
                                    @csrf
                                    <div class="row gx-3">

                                        <div class="col-6 mb-3">
                                            <label class="form-label">First name</label>
                                            <input class="form-control" type="text" name="first_name"
                                                value="{{ old('first_name', $user->first_name) }}">
                                            @error('first_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-6 mb-3">
                                            <label class="form-label">Last name</label>
                                            <input class="form-control" type="text" name="last_name"
                                                value="{{ old('last_name', $user->last_name) }}">
                                            @error('last_name')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Email</label>
                                            <input class="form-control" type="email" name="email"
                                                value="{{ old('email', $user->email) }}" readonly
                                                style="background:#e0e0e0;">
                                        </div>

                                        <div class="col-lg-6 mb-3">
                                            <label class="form-label">Phone</label>
                                            <input class="form-control" type="tel" name="phone"
                                                value="{{ old('phone', $user->phone) }}">
                                            @error('phone')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                        <div class="col-lg-12 mb-3">
                                            <label class="form-label">Address</label>
                                            <input class="form-control" type="text" name="address_line1"
                                                value="{{ old('address_line1', optional($user->admin_address)->address_line1) }}">
                                            @error('address_line1')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </div>

                                    </div>

                                    <button class="btn btn-primary mt-3" type="submit">
                                        Save Changes
                                    </button>
                                </form>
                            </div>

                            <!-- RIGHT SIDE AVATAR (Separate Form) -->
                            <aside class="col-lg-4">
                                <figure class="text-lg-center">

                                    @php
                                    $avatarPath = $user->avatar
                                    ? storage_path('app/public/' . $user->avatar)
                                    : null;

                                    $avatarUrl =
                                    $avatarPath && file_exists($avatarPath)
                                    ? asset('storage/' . $user->avatar)
                                    : asset('backend/imgs/theme/avatar-1.png');
                                    @endphp

                                    <img src="{{ $avatarUrl }}" class="img-lg mb-3 img-avatar" id="avatar-preview"
                                        alt="Staff" />

                                    <figcaption>
                                        <form action="{{ route('admin.profile.update-avatar') }}" method="POST"
                                            enctype="multipart/form-data">
                                            @csrf
                                            <label class="btn btn-light rounded font-md">
                                                <i class="icons material-icons md-backup font-md me-1"></i>Upload
                                                <input type="file" name="avatar" class="d-none"
                                                    onchange="this.form.submit()">
                                            </label>
                                            @error('avatar')
                                            <span class="text-danger small">{{ $message }}</span>
                                            @enderror
                                        </form>
                                    </figcaption>

                                </figure>
                            </aside>

                        </div>
                        @endif

                        {{-- ================= PASSWORD TAB ================= --}}
                        @if ($tab == 'password')
                        <form action="{{ route('admin.profile.change-password') }}" method="POST">
                            @csrf

                            <input type="text" name="fake_user" style="display:none;">
                            <input type="password" name="fake_pass" style="display:none;">

                            <div class="mb-3">
                                <label class="form-label">Current Password</label>
                                <div class="position-relative">
                                    <input type="password" name="current_password" class="form-control pe-5">
                                    <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor:pointer;">
                                        <i class="ri-eye-off-line"></i>
                                    </span>
                                </div>
                                @error('current_password')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">New Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password" class="form-control pe-5">
                                    <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor:pointer;">
                                        <i class="ri-eye-off-line"></i>
                                    </span>
                                </div>
                                @error('password')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Confirm New Password</label>
                                <div class="position-relative">
                                    <input type="password" name="password_confirmation" class="form-control pe-5">
                                    <span class="password-toggle position-absolute top-50 end-0 translate-middle-y me-3"
                                        style="cursor:pointer;">
                                        <i class="ri-eye-off-line"></i>
                                    </span>
                                </div>
                                @error('password_confirmation')
                                <span class="text-danger small">{{ $message }}</span>
                                @enderror
                            </div>


                            <button type="submit" class="btn btn-primary">
                                Change Password
                            </button>
                        </form>
                        @endif

                    </section>
                </div>

            </div>
        </div>
    </div>
</section>
@endsection