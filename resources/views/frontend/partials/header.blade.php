@php
    $mainLogo = !empty($websiteSettings['logo']) ?  asset('storage/' . ltrim($websiteSettings['logo'], '/')) 
     : asset('frontend/imgs/theme/logo.png');
@endphp

<header class="header-area" style="position: sticky; top: 0; z-index: 1050;">
    <!-- Main Header -->
    <nav class="navbar navbar-expand-lg navbar-light" style="padding: 12px 0;">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand me-auto me-lg-5" href="{{ route('admin.dashboard') }}" style="display: flex; align-items: center;">
                <img src="{{ $mainLogo }}" alt="logo" style="height: 50px; width: auto;">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: rgba(255,255,255,0.12); padding: 0.25rem 0.6rem;">
                <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 30 30%22%3e%3cpath stroke=%23dbeaf6%22 stroke-linecap=%22round%22 stroke-miterlimit=%2210%22 stroke-width=%222%22 d=%22M4 7h22M4 15h22M4 23h22%22/%3e%3c/svg%3e');"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav" style="flex-grow: 1;">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0" style="gap: 30px;">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" style="color: #dbeaf6; font-weight: 600; position: relative;">
                            Home
                            @if(request()->routeIs('home'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.about', 'about') }}" style="color: #dbeaf6; font-weight: 600;">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #dbeaf6; font-weight: 600;">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right Side - Support and account link -->
            <div class="d-flex align-items-center" style="gap: 30px;">                             

                <!-- conditional action -->
                @auth
                    <a href="{{ route('admin.home') }}" class="btn btn-outline-light btn-sm" style="font-weight:600;">Dashboard</a>
                @else
                    <a href="{{ route('admin.login') }}" class="btn btn-outline-light btn-sm" style="font-weight:600;">Login</a>
                @endauth
            </div>
        </div>
    </nav>
</header>

<style>
    .header-area{background: #0b2540; color: #e8f1f8; box-shadow:0 4px 12px rgba(11,37,64,0.2); border-bottom:1px solid rgba(255,255,255,0.06); padding: 0;}
    .navbar{padding: 14px 0 !important;}
    .navbar-brand{display:flex;align-items:center;gap:.8rem; margin-right: auto !important;}
    .navbar-brand img{height:45px; width: auto;}
    .nav-link{transition:all .25s ease;border-radius:6px;padding:8px 12px !important;color:#dbeaf6;font-weight:500; font-size: 14px;}
    .nav-link:hover{color:#ffffff !important;background:rgba(255,255,255,0.08)}
    .nav-link.active{color:#ffffff !important; background:rgba(59,149,183,0.15);}
    
    @media (max-width: 992px){
        .navbar-collapse{margin-top:14px;padding-top:14px;border-top:1px solid rgba(255,255,255,0.04)}
        .nav-link{padding:8px 0 !important}
        .navbar-brand img{height: 40px;}
    }
</style>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endpush
