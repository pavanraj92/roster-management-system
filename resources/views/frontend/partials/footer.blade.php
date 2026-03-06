<footer class="main" style="background: #0b2540; color: #e8f1f8; padding: 60px 0 20px;">
    <div class="container">
        <div class="row mb-5">
            <!-- Brand & About -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="fw-bold mb-3" style="color: #ffffff">{{ config('app.name', 'Roster') }}</h5>
                <p style="opacity: 0.9; font-size: 14px; line-height: 1.6; color: #dbeaf6;">
                    Simplifying workforce management with intelligent scheduling solutions.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="fw-bold mb-3" style="color: #ffffff">Quick Links</h6>
                <ul class="list-unstyled" style="font-size: 14px;">
                    <li class="mb-2">
                        <a href="{{ route('admin.dashboard') }}" style="color: #dbeaf6; text-decoration: none; opacity: 0.9; transition: all 0.15s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">
                            → Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('pages.about', 'about') }}" style="color: white; text-decoration: none; opacity: 0.85; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                            → About
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.login') }}" style="color: white; text-decoration: none; opacity: 0.85; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                            → Login
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('admin.register') }}" style="color: white; text-decoration: none; opacity: 0.85; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                            → Sign Up
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="fw-bold mb-3" style="color: #ffffff">Support</h6>
                <ul class="list-unstyled" style="font-size: 14px; color: #dbeaf6; opacity: 0.95;">
                    <li class="mb-2">
                        <i class="bi bi-envelope" style="margin-right: 8px; color:#cfe7fb"></i>
                        <span style="color:#dbeaf6">support@roster.local</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone" style="margin-right: 8px; color:#cfe7fb"></i>
                        <span style="color:#dbeaf6">+1 (800) 900-0000</span>
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock" style="margin-right: 8px; color:#cfe7fb"></i>
                        <span style="color:#dbeaf6">Mon-Fri, 9AM-6PM</span>
                    </li>
                </ul>
            </div>

            <!-- Social -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3" style="color: #ffffff">Connect With Us</h6>
                <div class="d-flex gap-3">
                    <a href="#" style="color: white; font-size: 20px; opacity: 0.85; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.15)'" onmouseout="this.style.opacity='0.85'; this.style.transform='scale(1)'">
                        <i class="bi bi-facebook"></i>
                    </a>
                    <a href="#" style="color: white; font-size: 20px; opacity: 0.85; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.15)'" onmouseout="this.style.opacity='0.85'; this.style.transform='scale(1)'">
                        <i class="bi bi-twitter"></i>
                    </a>
                    <a href="#" style="color: white; font-size: 20px; opacity: 0.85; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.15)'" onmouseout="this.style.opacity='0.85'; this.style.transform='scale(1)'">
                        <i class="bi bi-linkedin"></i>
                    </a>
                    <a href="#" style="color: white; font-size: 20px; opacity: 0.85; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.opacity='1'; this.style.transform='scale(1.15)'" onmouseout="this.style.opacity='0.85'; this.style.transform='scale(1)'">
                        <i class="bi bi-instagram"></i>
                    </a>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr style="opacity: 0.08; margin: 30px 0; border-color: rgba(255,255,255,0.06)">

        <!-- Footer Bottom -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0" style="font-size: 12px; opacity: 0.9; color: #cfe7fb;">
                    &copy; 2026 {{ config('app.name', 'Roster') }}. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0" style="font-size: 12px; color: #dbeaf6; opacity: 0.9;">
                    <a href="#" style="color: #dbeaf6; text-decoration: none; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">Privacy Policy</a> | 
                    <a href="#" style="color: #dbeaf6; text-decoration: none; opacity: 0.9;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.9'">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endpush
