@php
    $setting = \App\Models\Setting::where('key', 'site_name')->first();
    $siteName = $setting->value ?? 'Roster';
@endphp
<footer class="main-footer font-xs">
    <div class="row pb-30 pt-15">
        <div class="col-sm-6">
            <script>
                document.write(new Date().getFullYear());
            </script>
            &copy; {{ $siteName }} Team. All rights reserved.
        </div>
        <div class="col-sm-6">
            <div class="text-sm-end">Design & Develop by Dotsquares India</div>
        </div>
    </div>
</footer>