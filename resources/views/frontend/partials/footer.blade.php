<footer class="main" style="background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); color: white; padding: 60px 0 20px;">
    <div class="container">
        <div class="row mb-5" style="color: white">
            <!-- Brand & About -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h5 class="fw-bold mb-3" style="color: white">{{ config('app.name', 'Roster') }}</h5>
                <p style="opacity: 0.85; font-size: 14px; line-height: 1.6;" style="color: white">
                    Simplifying workforce management with intelligent scheduling solutions.
                </p>
            </div>

            <!-- Quick Links -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="fw-bold mb-3">Quick Links</h6>
                <ul class="list-unstyled" style="font-size: 14px;">
                    <li class="mb-2">
                        <a href="{{ route('home') }}" style="color: white; text-decoration: none; opacity: 0.85; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                            → Home
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('pages.about', 'about') }}" style="color: white; text-decoration: none; opacity: 0.85; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                            → About
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('login') }}" style="color: white; text-decoration: none; opacity: 0.85; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                            → Login
                        </a>
                    </li>
                    <li class="mb-2">
                        <a href="{{ route('register') }}" style="color: white; text-decoration: none; opacity: 0.85; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.85'">
                            → Sign Up
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Support -->
            <div class="col-lg-3 col-md-6 mb-4 mb-lg-0">
                <h6 class="fw-bold mb-3">Support</h6>
                <ul class="list-unstyled" style="font-size: 14px; opacity: 0.85;">
                    <li class="mb-2">
                        <i class="bi bi-envelope" style="margin-right: 8px;"></i>
                        support@roster.local
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-telephone" style="margin-right: 8px;"></i>
                        +1 (800) 900-0000
                    </li>
                    <li class="mb-2">
                        <i class="bi bi-clock" style="margin-right: 8px;"></i>
                        Mon-Fri, 9AM-6PM
                    </li>
                </ul>
            </div>

            <!-- Social -->
            <div class="col-lg-3 col-md-6">
                <h6 class="fw-bold mb-3">Connect With Us</h6>
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
        <hr style="opacity: 0.2; margin: 30px 0;">

        <!-- Footer Bottom -->
        <div class="row align-items-center">
            <div class="col-md-6">
                <p class="mb-0" style="font-size: 12px; opacity: 0.75;">
                    &copy; 2026 {{ config('app.name', 'Roster') }}. All rights reserved.
                </p>
            </div>
            <div class="col-md-6 text-md-end">
                <p class="mb-0" style="font-size: 12px; opacity: 0.75;">
                    <a href="#" style="color: white; text-decoration: none; opacity: 0.75;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.75'">Privacy Policy</a> | 
                    <a href="#" style="color: white; text-decoration: none; opacity: 0.75;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.75'">Terms of Service</a>
                </p>
            </div>
        </div>
    </div>
</footer>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endpush
