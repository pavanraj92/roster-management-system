<div class="mobile-header-active mobile-header-wrapper-style">
    <div class="mobile-header-wrapper-inner">
        <div class="mobile-header-top">
            <div class="mobile-header-logo">
                <a href="{{ route('home') }}"><img src="{{ asset('frontend/imgs/theme/logo.png') }}" alt="logo" /></a>
            </div>
            <div class="mobile-menu-close close-style-wrap close-style-position-inherit">
                <button class="close-style search-close">
                    <i class="icon-top"></i>
                    <i class="icon-bottom"></i>
                </button>
            </div>
        </div>
        <div class="mobile-header-content-area">
            <div class="mobile-search search-style-3 mobile-header-border">
                <form action="{{ route('home') }}" method="get">
                    <input type="text" name="q" placeholder="Search for items…" />
                    <button type="submit"><i class="fi-rs-search"></i></button>
                </form>
            </div>
            <div class="mobile-menu-wrap mobile-header-border">
                <nav>
                    <ul class="mobile-menu font-heading">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('home') }}">Deals</a></li>
                        <li><a href="{{ route('home') }}">About</a></li>
                        <li><a href="{{ route('home') }}">Contact</a></li>
                        @guest
                            <li><a href="{{ route('login') }}">Login</a></li>
                            <li><a href="{{ route('register') }}">Sign Up</a></li>
                        @else
                             @if(Route::has('logout'))
                                            <li>
                                                <a href="{{ route('logout') }}"
                                                   onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();">
                                                    <i class="fi fi-rs-sign-out mr-10"></i>Sign out
                                                </a>
                                                <form id="header-logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                                                    @csrf
                                                </form>
                                            </li>
                                            @endif
                        @endguest
                    </ul>
                </nav>
            </div>
            <div class="mobile-header-info-wrap">
                <div class="single-mobile-header-info">
                    <a href="{{ route('home') }}"><i class="fi-rs-marker"></i> Our location</a>
                </div>
                <div class="single-mobile-header-info">
                    <a href="{{ route('login') }}"><i class="fi-rs-user"></i>Log In / Sign Up</a>
                </div>
            </div>
            <div class="mobile-social-icon mb-50">
                <h6 class="mb-15">Follow Us</h6>
                <a href="#"><img src="{{ asset('frontend/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                <a href="#"><img src="{{ asset('frontend/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
            </div>
            <div class="site-copyright">© {{ date('Y') }} {{ config('app.name', 'Roster') }}. All rights reserved.</div>
        </div>
    </div>
</div>
