@php
    $mainLogo = !empty($websiteSettings['logo']) ?  asset('storage/' . ltrim($websiteSettings['logo'], '/')) 
     : asset('frontend/imgs/theme/logo.png');
@endphp

<header class="header-area" style="background-color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.08); position: sticky; top: 0; z-index: 1000;">
    <!-- Top Promo Bar -->
    <div class="mobile-promotion" style="background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); color: white; padding: 10px; text-align: center; font-size: 13px;">
        <span>Welcome to <strong>{{ config('app.name', 'Roster') }}</strong> – manage your staff and schedules</span>
    </div>

    <!-- Main Header -->
    <nav class="navbar navbar-expand-lg navbar-light" style="padding: 15px 0;">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand me-auto me-lg-5" href="{{ route('home') }}" style="display: flex; align-items: center;">
                <img src="{{ $mainLogo }}" alt="logo" style="height: 50px; width: auto;">
            </a>

            <!-- Mobile Toggle -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" style="border-color: #3b95b7; padding: 0.25rem 0.6rem;">
                <span class="navbar-toggler-icon" style="background-image: url('data:image/svg+xml,%3csvg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 30 30%22%3e%3cpath stroke=%223b95b7%22 stroke-linecap=%22round%22 stroke-miterlimit=%2210%22 stroke-width=%222%22 d=%22M4 7h22M4 15h22M4 23h22%22/%3e%3c/svg%3e');"></span>
            </button>

            <!-- Navigation Menu -->
            <div class="collapse navbar-collapse" id="navbarNav" style="flex-grow: 1;">
                <ul class="navbar-nav mx-auto mb-2 mb-lg-0" style="gap: 30px;">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" style="color: #2a3f5f; font-weight: 500; position: relative;">
                            Home
                            @if(request()->routeIs('home'))
                                <span style="position: absolute; bottom: -8px; left: 0; right: 0; height: 3px; background: linear-gradient(135deg, #3b95b7 0%, #2a6b8f 100%); border-radius: 2px;"></span>
                            @endif
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pages.about', 'about') }}" style="color: #2a3f5f; font-weight: 500;">
                            About
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" style="color: #2a3f5f; font-weight: 500;">
                            Contact
                        </a>
                    </li>
                </ul>
            </div>

            <!-- Right Side - Account & Support -->
            <div class="d-flex align-items-center" style="gap: 30px;">
                <!-- Support (Desktop Only) -->
                <div class="d-none d-lg-flex align-items-center" style="gap: 8px; padding-left: 30px; border-left: 1px solid #e9ecef;">
                    <div style="color: #3b95b7; font-size: 20px;">
                        <i class="bi bi-telephone"></i>
                    </div>
                    <div style="font-size: 13px;">
                        <div style="color: #3b95b7; font-weight: 600;">24/7 Support</div>
                        <div style="color: #6c757d;">Customer Care</div>
                    </div>
                </div>

                <!-- Account Menu (Mobile & Desktop) -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="accountDropdown" role="button" data-bs-toggle="dropdown" style="color: #3b95b7; font-weight: 500; display: flex; align-items: center; gap: 8px;">
                        <i class="bi bi-person-circle" style="font-size: 20px;"></i>
                        <span class="d-none d-lg-inline">Account</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="accountDropdown" style="border: 1px solid #e9ecef; border-radius: 8px; box-shadow: 0 4px 12px rgba(0,0,0,0.1);">
                        @auth
                            <li><a class="dropdown-item" href="#" style="color: #2a3f5f;"><i class="bi bi-person me-2"></i>My Account</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();" style="color: #dc3545;">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sign out
                                </a>
                                <form id="header-logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                                    @csrf
                                </form>
                            </li>
                        @else
                            <li><a class="dropdown-item" href="{{ route('login') }}" style="color: #2a3f5f;"><i class="bi bi-box-arrow-in-right me-2"></i>Login</a></li>
                            <li><a class="dropdown-item" href="{{ route('register') }}" style="color: #2a3f5f;"><i class="bi bi-person-plus me-2"></i>Sign Up</a></li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
    </nav>
</header>

<style>
    .navbar-brand:hover {
        opacity: 0.85;
    }

    .nav-link {
        transition: all 0.3s ease;
        border-radius: 4px;
        padding: 8px 12px !important;
    }

    .nav-link:hover {
        color: #3b95b7 !important;
    }

    .nav-link.active {
        color: #3b95b7 !important;
    }

    .dropdown-item:hover {
        background-color: #f0f7fb !important;
        color: #3b95b7 !important;
    }

    .dropdown-item.active {
        background-color: #e8f4f8;
        color: #3b95b7;
    }

    @media (max-width: 992px) {
        .navbar-collapse {
            margin-top: 15px;
            padding-top: 15px;
            border-top: 1px solid #e9ecef;
        }

        .nav-link {
            padding: 10px 0 !important;
        }
    }
</style>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
@endpush
