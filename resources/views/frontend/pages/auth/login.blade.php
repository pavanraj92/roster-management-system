@extends('frontend.layouts.master')

@section('title', 'Login')

@section('main_class', 'pages')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Login
        </div>
    </div>
</div>
<div class="page-content pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                <div class="row">
                    <div class="col-lg-6 pr-30 d-none d-lg-block">
                        <img class="border-radius-15" src="{{ asset('frontend/imgs/page/login-1.png') }}" alt="Login" />
                    </div>
                    <div class="col-lg-6 col-md-8">
                        <div class="login_wrap widget-taber-content background-white">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h1 class="mb-5">Login</h1>
                                    <p class="mb-30">Don't have an account? <a href="{{ route('register') }}">Create here</a></p>
                                </div>
                                @if (session('status'))
                                    <div class="alert alert-success mb-3" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif
                                <form id="loginForm" method="POST" action="{{ route('login') }}" novalidate>
                                    @csrf
                                    <div class="form-group">
                                        <label>Login With <span class="text-danger">*</span></label>
                                        <div class="d-flex gap-3">
                                            <div class="custome-radio mr-20">
                                                <input class="form-check-input" type="radio" name="login_type" id="login_type_password" value="password" checked />
                                                <label class="form-check-label" for="login_type_password"><span>Password</span></label>
                                            </div>
                                            <div class="custome-radio">
                                                <input class="form-check-input" type="radio" name="login_type" id="login_type_otp" value="otp" />
                                                <label class="form-check-label" for="login_type_otp"><span>OTP</span></label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="login_email">Email or Mobile <span class="text-danger">*</span></label>
                                        <input type="text" id="login_email" name="email" value="{{ old('email') }}" class="form-control" required />
                                        <small class="text-danger d-none" id="error-email"></small>
                                    </div>
                                    <div class="form-group" id="passwordGroup">
                                        <label for="login_password">Password <span class="text-danger">*</span></label>
                                        <input required type="password" id="login_password" name="password" class="form-control" />
                                        <small class="text-danger d-none" id="error-password"></small>
                                    </div>
                                    <div class="form-group d-none" id="otpGroup">
                                        <label for="login_otp">OTP <span class="text-danger">*</span></label>
                                        <div class="d-flex">
                                            <input type="text" id="login_otp" name="otp" class="form-control mr-10" maxlength="6" />
                                            <button type="button" id="sendOtpBtn" class="btn btn-border">Send OTP</button>
                                        </div>
                                        <small class="text-muted d-block mt-5" id="otpHelp">Use Send OTP to generate a code.</small>
                                        <small class="text-danger d-none" id="error-otp"></small>
                                    </div>
                                    <div class="login_footer form-group mb-50">
                                        <div class="chek-form">
                                            <div class="custome-checkbox">
                                                <input class="form-check-input" type="checkbox" name="remember" id="remember" />
                                                <label class="form-check-label" for="remember"><span>Remember me</span></label>
                                            </div>
                                        </div>
                                        @if(Route::has('password.request'))
                                            <a class="text-muted" href="{{ route('password.request') }}">Forgot password?</a>
                                        @endif
                                    </div>
                                    <div class="form-group">
                                        <button type="button" id="loginBtn" class="btn btn-heading btn-block hover-up" name="login">Log in</button>
                                    </div>
                                </form>
                                <script>
                                    window.loginOtpSendUrl = @json(route('login.otp.send'));
                                    window.loginOtpVerifyUrl = @json(route('login.otp.verify'));
                                </script>
                                <script src="{{ asset('frontend/js/login.js') }}?v={{ filemtime(public_path('frontend/js/login.js')) }}"></script>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
