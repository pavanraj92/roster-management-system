@extends('frontend.layouts.master')

@section('title', 'Sign Up')

@section('main_class', 'pages')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Create Account
        </div>
    </div>
</div>

<div class="page-content pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-xl-10 col-lg-11 col-md-12 m-auto">
                <div class="row align-items-center">
                    <div class="col-lg-5 pr-30 d-none d-lg-block">
                        <img class="border-radius-15" src="{{ asset('frontend/imgs/page/login-1.png') }}" alt="Register" />
                    </div>

                    <div class="col-lg-7 col-md-10">
                        <div class="login_wrap widget-taber-content background-white">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h1 class="mb-5">Create an Account</h1>
                                    <p class="mb-30">Already have an account? <a href="{{ route('login') }}">Login</a></p>
                                </div>

                                <div id="successAlert" class="alert alert-success mb-3" style="display: none;">
                                    <span id="successMessage"></span>
                                </div>

                                <form id="registerForm" method="POST" action="{{ route('register') }}" novalidate onsubmit="event.preventDefault();">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="first_name">First Name <span class="text-danger">*</span></label>
                                                <input type="text" name="first_name" id="first_name" value="{{ old('first_name') }}" class="form-control" required>
                                                <small class="text-danger d-none" id="error-first_name"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="last_name">Last Name</label>
                                                <input type="text" name="last_name" id="last_name" value="{{ old('last_name') }}" class="form-control">
                                                <small class="text-danger d-none" id="error-last_name"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label for="email">Email Address <span class="text-danger">*</span></label>
                                        <input type="email" name="email" id="email" value="{{ old('email') }}" class="form-control" required>
                                        <small class="text-danger d-none" id="error-email"></small>
                                    </div>

                                    <div class="form-group">
                                    <label for="phone">Mobile Number <span class="text-danger">*</span></label>
                                    <input type="tel" inputmode="numeric" pattern="[0-9]*" name="phone" id="phone" value="{{ old('phone') }}" class="form-control" required maxlength="15" autocomplete="tel">
                                    <small class="text-danger d-none" id="error-phone"></small>
                                    </div>

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password">Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password" id="password" class="form-control" required>
                                                <small class="text-danger d-none" id="error-password"></small>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label for="password_confirmation">Confirm Password <span class="text-danger">*</span></label>
                                                <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" required>
                                                <small class="text-danger d-none" id="error-password_confirmation"></small>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="login_footer form-group mb-40">
                                        <div class="chek-form">
                                            <div class="custome-checkbox" id="terms-container">
                                                <input class="form-check-input" type="checkbox" name="terms" id="terms" required />
                                                <label class="form-check-label" for="terms"><span>I agree to Terms &amp; Policy</span></label>
                                            </div>
                                        </div>
                                        <small class="text-danger d-none" id="error-terms"></small>
                                    </div>

                                    <div class="form-group mb-25">
                                        <button type="button" id="registerBtn" class="btn btn-heading btn-block hover-up">Register</button>
                                    </div>

                                    <p class="font-xs text-muted mb-0">
                                        <strong>Note:</strong> Your personal data will be used to support your experience throughout this website, to manage access to your account, and for other purposes described in our privacy policy.
                                    </p>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function(){
    var phone = document.getElementById('phone');
    if (phone) {
        phone.addEventListener('input', function () {
            this.value = this.value.replace(/\D/g, '');
        });
    }
});
</script>
<script src="{{ asset('frontend/js/register.js') }}?v={{ filemtime(public_path('frontend/js/register.js')) }}"></script>
@endsection
