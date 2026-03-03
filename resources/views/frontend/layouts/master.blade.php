<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Roster'))</title>
    <meta name="description" content="@yield('meta_description', 'Manage your staff and schedules with ease')" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/imgs/theme/favicon.svg') }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}?v=6.0" />
    @stack('styles')
</head>

<body>
    <!-- Header (Top of page) -->
    @include('frontend.partials.header')
    
    <!-- Mobile Menu -->
    @include('frontend.partials.mobile-menu')

    <!-- Main Content -->
    <main class="main @yield('main_class', '')">
        @yield('content')
    </main>

    <!-- Footer -->
    @include('frontend.partials.footer')

    <!-- Preloader Start -->
    <div id="preloader-active">
        <div class="preloader d-flex align-items-center justify-content-center">
            <div class="preloader-inner position-relative">
                <div class="text-center">
                    <img src="{{ asset('frontend/imgs/theme/loading.gif') }}" alt="" />
                </div>
            </div>
        </div>
    </div>

    <style>
        #preloader-active {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 9999;
        }

        #preloader-active .preloader {
            background: transparent;
        }

        #preloader-active .preloader-inner {
            animation: spin 2s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    <!-- Scripts -->
    @include('frontend.partials.scripts')
</body>

</html>
