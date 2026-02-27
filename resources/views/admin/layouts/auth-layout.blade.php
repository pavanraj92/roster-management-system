<!DOCTYPE html>
<html lang="en">

<head>
    @php
        $siteNameSetting = \App\Models\Setting::where('key', 'site_name')->first();
        $siteName = $siteNameSetting->value ?? 'Roster';

        $faviconSetting = \App\Models\Setting::where('key', 'favicon')->first();
        $faviconPath =
            $faviconSetting && $faviconSetting->value
                ? asset('storage/' . $faviconSetting->value)
                : asset('backend/imgs/theme/favicon.svg');
    @endphp

    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge" />
    <meta name="description" content="" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta property="og:title" content="" />
    <meta property="og:type" content="" />
    <meta property="og:url" content="" />
    <meta property="og:image" content="" />
    <title>@yield('title') | {{ $siteName}}</title>
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconPath }}" />
    <!-- Template CSS -->
    <script src="{{ asset('backend/js/vendors/color-modes.js') }}"></script>
    <link href="{{ asset('backend/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    @stack('styles')
</head>

<body>
    <main>
        <!-- Centered Logo Section -->
        <!-- <div class="text-center pt-5 pb-4">
            <a href="{{ route('admin.dashboard') }}" class="d-inline-block">
                <img src="{{ asset('backend/imgs/theme/logo.png') }}" class="logo" alt="Roster Logo"
                    style="max-width: 180px;" />
            </a>
        </div> -->

        @yield('content')
    </main>

    <script src="{{ asset('backend/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('backend/js/main.js?v=6.0') }}" type="text/javascript"></script>
    <script>
        document.querySelectorAll('.password-toggle').forEach(toggle => {
            toggle.addEventListener('click', function() {
                let input = this.parentElement.querySelector('input');
                let icon = this.querySelector('i');

                if (input.type === 'password') {
                    input.type = 'text';
                    icon.classList.remove('ri-eye-off-line');
                    icon.classList.add('ri-eye-line');
                } else {
                    input.type = 'password';
                    icon.classList.remove('ri-eye-line');
                    icon.classList.add('ri-eye-off-line');
                }
            });
        });
    </script>


    @stack('scripts')
</body>

</html>
