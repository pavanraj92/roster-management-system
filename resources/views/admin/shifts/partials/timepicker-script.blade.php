@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (typeof flatpickr !== 'undefined') {
                flatpickr('.timepicker', {
                    enableTime: true,
                    noCalendar: true,
                    dateFormat: 'H:i',
                    time_24hr: true
                });
            }
        });
    </script>
@endpush

