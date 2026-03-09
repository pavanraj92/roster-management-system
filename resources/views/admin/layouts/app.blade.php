<!DOCTYPE html>
<html lang="en" class="light">

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
    <title>@yield('title') | {{ $siteName }}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" type="image/x-icon" href="{{ $faviconPath }}" />
    <!-- Template CSS -->
    {{-- <script src="{{ asset('backend/js/vendors/color-modes.js') }}"></script> --}}
    <link href="{{ asset('backend/css/main.css?v=6.0') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('backend/css/custom.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
    <script src="https://cdn.lordicon.com/lusqsztk.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    @stack('styles')
</head>

<body>
    <div class="screen-overlay"></div>
    <script>
        // Immediately clear any stray overlay (runs during page parse)
        (function () {
            var overlay = document.querySelector('.screen-overlay');
            if (overlay) overlay.classList.remove('show');
            document.body.classList.remove('offcanvas-active');
            document.querySelectorAll('.mobile-offcanvas, .navbar-aside').forEach(function (el) { el.classList.remove('show'); });
        })();

        // if for some reason the overlay gets left visible later on,
        // clicking anywhere should dismiss it so buttons remain clickable.
        document.addEventListener('click', function (e) {
            var overlay = document.querySelector('.screen-overlay');
            if (overlay && overlay.classList.contains('show')) {
                overlay.classList.remove('show');
                document.body.classList.remove('offcanvas-active');
                document.querySelectorAll('.mobile-offcanvas, .navbar-aside')
                    .forEach(function (el) { el.classList.remove('show'); });
            }
        });
    </script>

    @include('admin.layouts.sidebar')

    <main class="main-wrap">
        @include('admin.layouts.header')
        {{-- global flash/toast messages --}}
        @include('admin.layouts.flash_message')

        @yield('content')

        @include('admin.layouts.footer')
    </main>

    <script src="{{ asset('backend/js/vendors/jquery-3.6.0.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendors/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendors/select2.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendors/perfect-scrollbar.js') }}"></script>
    <script src="{{ asset('backend/js/vendors/jquery.fullscreen.min.js') }}"></script>
    <script src="{{ asset('backend/js/vendors/chart.js') }}"></script>
    <!-- Main Script -->
    <script src="{{ asset('backend/js/main.js?v=6.0') }}" type="text/javascript"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('backend/js/custom.js') }}"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.4.2/classic/ckeditor.js"></script>
    <script>
        window.adminCkEditorInstances = window.adminCkEditorInstances || {};

        window.initAdminCkEditors = function (selectors, config) {
            const editorConfig = config || {};
            const selectorList = Array.isArray(selectors) ? selectors : [selectors];

            if (!window.ClassicEditor) {
                console.warn('CKEditor script is not loaded.');
                return;
            }

            selectorList.forEach(function (selector) {
                document.querySelectorAll(selector).forEach(function (element) {
                    if (element.dataset.ckeditorInitialized === '1') {
                        return;
                    }

                    ClassicEditor.create(element, editorConfig)
                        .then(function (editor) {

                            // Set minimum height
                            editor.editing.view.change(writer => {
                                writer.setStyle(
                                    'min-height',
                                    '250px',
                                    editor.editing.view.document.getRoot()
                                );
                            });

                            const key = element.name || element.id || selector;
                            window.adminCkEditorInstances[key] = editor;
                            element.dataset.ckeditorInitialized = '1';
                        })
                        .catch(function (error) {
                            console.error(error);
                        });
                });
            });
        };

        document.querySelectorAll('.password-toggle').forEach(toggle => {
            toggle.addEventListener('click', function () {
                let input = this.previousElementSibling;
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

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    @stack('scripts')
</body>

</html>