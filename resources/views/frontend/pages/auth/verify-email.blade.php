@extends('frontend.layouts.master')

@section('title', 'Verify Email')

@section('main_class', 'pages')

@section('content')
<div class="page-header breadcrumb-wrap">
    <div class="container">
        <div class="breadcrumb">
            <a href="{{ route('home') }}" rel="nofollow"><i class="fi-rs-home mr-5"></i>Home</a>
            <span></span> Verify Email
        </div>
    </div>
</div>
<div class="page-content pt-150 pb-150">
    <div class="container">
        <div class="row">
            <div class="col-xl-8 col-lg-10 col-md-12 m-auto">
                <div class="row align-items-center">
                    <div class="col-lg-6 d-none d-lg-block">
                        <img class="border-radius-15" src="{{ asset('frontend/imgs/page/login-1.png') }}" alt="Verify Email" />
                    </div>
                    <div class="col-lg-6 col-md-8">
                        <div class="login_wrap widget-taber-content background-white">
                            <div class="padding_eight_all bg-white">
                                <div class="heading_s1">
                                    <h1 class="mb-10">Verify Your Email</h1>
                                    <p class="mb-25">
                                        Thanks for registering. We have sent a verification link to
                                        <strong>{{ auth()->user()?->email }}</strong>.
                                    </p>
                                    <p class="mb-30">
                                        Please check your inbox (and spam folder) and click the verification link.
                                    </p>
                                </div>

                                @if (session('status'))
                                    <div class="alert alert-success mb-3" role="alert">
                                        {{ session('status') }}
                                    </div>
                                @endif

                                <form method="POST" action="{{ route('verification.send') }}">
                                    @csrf
                                    <div class="form-group mb-20">
                                        <button type="submit" class="btn btn-heading btn-block hover-up">
                                            Resend Verification Email
                                        </button>
                                    </div>
                                </form>

                                <div class="d-flex justify-content-between align-items-center">
                                    <a href="{{ route('home') }}" class="text-muted">Back to Home</a>
                                    <a href="{{ route('logout') }}"
                                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                                       class="text-muted">
                                        Logout
                                    </a>
                                    <form id="logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                                        @csrf
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
