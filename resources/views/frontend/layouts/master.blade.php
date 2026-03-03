<!DOCTYPE html>
<html class="no-js" lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('app.name', 'Roster'))</title>
    <!-- Admin panel matching fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <meta name="description" content="@yield('meta_description', 'Manage your staff and schedules with ease')" />
    <!-- Favicon -->
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('frontend/imgs/theme/favicon.svg') }}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Template CSS -->
    <link rel="stylesheet" href="{{ asset('frontend/css/plugins/animate.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('frontend/css/main.css') }}?v=6.0" />
    <style>
        :root{
            --brand-500: #3b95b7;
            --brand-700: #2a6b8f;
            --muted: #6c757d;
        }
        html,body{font-family: 'Lato', 'Quicksand', system-ui, -apple-system, 'Segoe UI', Roboto, 'Helvetica Neue', Arial; color: #223; font-weight: 400;}
        h1,h2,h3,h4,h5,h6{font-family: 'Quicksand', 'Lato', system-ui; font-weight: 600;}
        .btn-modern{border-radius: 8px; padding: .75rem 1.75rem; font-weight:600; box-shadow: 0 4px 12px rgba(42,63,95,0.12); font-size: 15px; transition: all 0.25s ease;}
        .btn-modern:hover{transform: translateY(-2px); box-shadow: 0 6px 16px rgba(42,63,95,0.16);}
        .card-soft{background:#fff;border-radius:14px;box-shadow: 0 8px 24px rgba(39,54,72,0.08);}
    </style>
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



    <!-- Scripts -->
    @include('frontend.partials.scripts')
</body>

</html>
