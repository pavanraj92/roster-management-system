@php
    // map session keys to bootstrap toast classes
    // success toasts get an extra class so we can override the colour
    $toastClasses = [
        'success' => 'text-bg-success toast-success-custom',
        'error'   => 'text-bg-danger',
        'warning' => 'text-bg-warning',
    ];
@endphp

<div class="toast-container position-fixed top-0 end-0 p-3" id="adminToastContainer">
    @foreach (['success','error','warning'] as $key)
        @if (session()->has($key))
            @php
                // inline style override for success as final safety
                $style = $key === 'success' ? 'style="background-color: #3b95b7 !important;"' : '';
            @endphp
            <div class="toast align-items-center {{ $toastClasses[$key] }} border-0" {!! $style !!} role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ ucfirst($key) }}! {{ session($key) }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endif
    @endforeach

    @if (session()->has('errors'))
        @foreach (session('errors')->all() as $error)
            <div class="toast align-items-center text-bg-danger border-0" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="d-flex">
                    <div class="toast-body">
                        {{ $error }}
                    </div>
                    <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
            </div>
        @endforeach
    @endif
</div>

<script>
    // Global toast helper for the admin panel.
    // Use this instead of SweetAlert "toast" so we keep one consistent design.
    window.adminToast = function (type, message, delay) {
        try {
            var container = document.getElementById('adminToastContainer');
            if (!container) return;

            var toastClasses = {
                success: 'text-bg-success toast-success-custom',
                error: 'text-bg-danger',
                warning: 'text-bg-warning',
                info: 'text-bg-info',
            };

            var klass = toastClasses[type] || toastClasses.info;
            var toastEl = document.createElement('div');
            toastEl.className = 'toast align-items-center ' + klass + ' border-0';
            toastEl.setAttribute('role', 'alert');
            toastEl.setAttribute('aria-live', 'assertive');
            toastEl.setAttribute('aria-atomic', 'true');

            // keep success colour consistent with existing override
            if (type === 'success') {
                toastEl.style.backgroundColor = '#3b95b7';
            }

            toastEl.innerHTML =
                '<div class="d-flex">' +
                '  <div class="toast-body">' + (message || '') + '</div>' +
                '  <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>' +
                '</div>';

            container.appendChild(toastEl);

            if (window.bootstrap && bootstrap.Toast) {
                var toast = new bootstrap.Toast(toastEl, { delay: delay || 2000 });
                toast.show();
                toastEl.addEventListener('hidden.bs.toast', function () {
                    toastEl.remove();
                });
            }
        } catch (e) {
            // ignore toast failures; never block UX
        }
    };

    document.addEventListener('DOMContentLoaded', function () {
        var toastElList = [].slice.call(document.querySelectorAll('#adminToastContainer .toast'));
        toastElList.forEach(function (toastEl) {
            var toast = new bootstrap.Toast(toastEl, { delay: 2000 });
            toast.show();
        });
    });
</script>