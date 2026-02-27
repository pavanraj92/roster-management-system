<footer class="main">
    @php
        $websiteSettings = $websiteSettings ?? [];
        $bannerSettings = $bannerSettings ?? [];
        $footerServiceHighlights = collect($footerServiceHighlights ?? []);
        $footerSocialIcons = collect($footerSocialIcons ?? []);

        $siteName = $websiteSettings['site_name'] ?? config('app.name', 'Roster');
        $siteEmail = $websiteSettings['site_email'] ?? ('support@' . strtolower(config('app.name', 'Roster')) . '.com');
        $sitePhone = $websiteSettings['site_phone'] ?? '+1 800 900';
        $siteAddress = $websiteSettings['site_address'] ?? 'Your Address Here';
        $footerText = $websiteSettings['footer_text'] ?? '';

        $footerLogo = !empty($websiteSettings['logo'])
        ? asset('storage/' . ltrim($websiteSettings['logo'], '/'))
            : asset('frontend/imgs/theme/logo.png');
    @endphp

    @php
        $banner = is_array($bannerSettings) && count($bannerSettings) ? $bannerSettings[0] : null;
        $bannerTitle = $banner['title'] ?? 'Stay home & get your daily needs from our shop';
        // ensure title displays on two lines when appropriate
        $bannerTitleHtml = $bannerTitle;
        if (strpos($bannerTitleHtml, '<br') === false && strpos($bannerTitleHtml, "\n") === false) {
            $words = preg_split('/\s+/', trim($bannerTitleHtml));
            if (count($words) > 6) {
                $half = (int) floor(count($words) / 2);
                $bannerTitleHtml = implode(' ', array_slice($words, 0, $half)) . ' <br /> ' . implode(' ', array_slice($words, $half));
            }
        }
        $bannerSubtitle = $banner['sub_title'] ?? "Start Your Daily Shopping with <span class=\"text-brand\">{$siteName}</span>";
        $bannerImage = $banner['image'] ?? 'frontend/imgs/banner/banner-13.png';
        $bannerImageUrl = str_starts_with($bannerImage, 'frontend/') ? asset($bannerImage) : asset('storage/' . ltrim($bannerImage, '/'));
    @endphp

    <section class="newsletter mb-15 wow animate__animated animate__fadeIn">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="position-relative newsletter-inner">
                        <div class="newsletter-content">
                            <h2 class="mb-20">{!! $bannerTitleHtml !!}</h2>
                            <p class="mb-45">{!! $bannerSubtitle !!}</p>
                            <form class="form-subcriber d-flex" action="#" method="post">
                                @csrf
                                <input type="email" name="email" placeholder="Your email address" />
                                <button class="btn" type="submit">Subscribe</button>
                            </form>
                        </div>
                        <img src="{{ $bannerImageUrl }}" alt="newsletter" />
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="featured section-padding">
        <div class="container">
            <div class="row">
                @forelse ($footerServiceHighlights as $highlight)
                    @php
                        $highlightImage = !empty($highlight['image'])
                            ? (str_starts_with($highlight['image'], 'frontend/') ? asset($highlight['image']) : asset('storage/' . ltrim($highlight['image'], '/')))
                            : asset('frontend/imgs/theme/icons/icon-' . (($loop->index % 5) + 1) . '.svg');
                    @endphp
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 {{ $loop->first ? 'mb-md-4 mb-xl-0' : '' }}">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ $highlightImage }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">{{ $highlight['title'] ?? '' }}</h3>
                                <p>{{ $highlight['sub_title'] ?? '' }}</p>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6 mb-md-4 mb-xl-0">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('frontend/imgs/theme/icons/icon-1.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Free Shipping</h3>
                                <p>On all orders over $99</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('frontend/imgs/theme/icons/icon-2.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Daily Surprise Offers</h3>
                                <p>Save up to 25% off</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('frontend/imgs/theme/icons/icon-3.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Support 24/7</h3>
                                <p>Contact us 24 hours a day</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('frontend/imgs/theme/icons/icon-4.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Affordable Prices</h3>
                                <p>Get factory direct price</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-1-5 col-md-4 col-12 col-sm-6">
                        <div class="banner-left-icon d-flex align-items-center wow fadeIn animated">
                            <div class="banner-icon">
                                <img src="{{ asset('frontend/imgs/theme/icons/icon-5.svg') }}" alt="" />
                            </div>
                            <div class="banner-text">
                                <h3 class="icon-box-title">Secure Payment</h3>
                                <p>100% secure payment</p>
                            </div>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-padding footer-mid">
        <div class="container pt-15 pb-20">
            <div class="row">
                <div class="col">
                    <div class="widget-about font-md mb-md-3 mb-lg-3 mb-xl-0">
                        <div class="logo mb-30">
                            <a href="{{ route('home') }}" class="mb-15"><img src="{{ $footerLogo }}" alt="logo" /></a>
                            <p class="font-lg text-heading">Your one-stop e-commerce shopping destination</p>
                        </div>
                        <ul class="contact-infor">
                            @if (!empty($websiteSettings['site_address']))
                                <li>
                                    <img src="{{ asset('frontend/imgs/theme/icons/icon-location.svg') }}" alt="" />
                                    <strong>Address: </strong> <span>{{ $siteAddress }}</span>
                                </li>
                            @endif

                            @if (!empty($websiteSettings['site_phone']))
                                <li>
                                    <img src="{{ asset('frontend/imgs/theme/icons/icon-contact.svg') }}" alt="" />
                                    <strong>Call Us:</strong><span>{{ $sitePhone }}</span>
                                </li>
                            @endif

                            @if (!empty($websiteSettings['site_email']))
                                <li>
                                    <img src="{{ asset('frontend/imgs/theme/icons/icon-email-2.svg') }}" alt="" />
                                    <strong>Email:</strong><span>{{ $siteEmail }}</span>
                                </li>
                            @endif

                            {{-- <li><img src="{{ asset('frontend/imgs/theme/icons/icon-clock.svg') }}" alt="" /><strong>Hours:</strong><span>10:00 - 18:00, Mon - Sat</span></li> --}}
                        </ul>
                    </div>
                </div>

                <div class="footer-link-widget col">
                    <h4 class="widget-title">Company</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{ route('home') }}">About Us</a></li>
                        <li><a href="{{ route('home') }}">Delivery Information</a></li>
                        <li><a href="{{ route('home') }}">Privacy Policy</a></li>
                        <li><a href="{{ route('home') }}">Terms & Conditions</a></li>
                        <li><a href="{{ route('home') }}">Contact Us</a></li>
                    </ul>
                </div>

                <div class="footer-link-widget col">
                    <h4 class="widget-title">Account</h4>
                    <ul class="footer-list mb-sm-5 mb-md-0">
                        <li><a href="{{ route('login') }}">Sign In</a></li>
                        <li><a href="{{ route('register') }}">Create Account</a></li>
                        <li><a href="{{ route('home') }}">View Cart</a></li>
                        <li><a href="{{ route('home') }}">Track My Order</a></li>
                    </ul>
                </div>

                <div class="footer-link-widget widget-install-app col">
                    <h4 class="widget-title">Install App</h4>
                    <p class="">From App Store or Google Play</p>
                    <div class="download-app">
                        <a href="#" class="hover-up mb-sm-2 mb-lg-0"><img class="active" src="{{ asset('frontend/imgs/theme/app-store.jpg') }}" alt="app-store" /></a>
                        <a href="#" class="hover-up mb-sm-2"><img src="{{ asset('frontend/imgs/theme/google-play.jpg') }}" alt="google-play" /></a>
                    </div>
                    <p class="mb-20">Secured Payment Gateways</p>
                    <img class="" src="{{ asset('frontend/imgs/theme/payment-method.png') }}" alt="payment-methods" />
                </div>

            </div>
        </div>
    </section>

    <div class="container pb-30">
        <div class="row align-items-center">
            <div class="col-12 mb-30">
                <div class="footer-bottom"></div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6">
                @if (!empty($footerText))
                    <p class="font-sm mb-0">&copy; {{ date('Y') }}, {{ $footerText }}</p>
                @else
                    <p class="font-sm mb-0">&copy; {{ date('Y') }}, <strong class="text-brand">{{ $siteName }}</strong> - E-Commerce Platform. All rights reserved.</p>
                @endif
            </div>
            <div class="col-xl-4 col-lg-6 text-center d-none d-xl-block">
                <div class="hotline d-lg-inline-flex mr-30">
                    <img src="{{ asset('frontend/imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                    <p>1900 - 6666<span>Working 8:00 - 22:00</span></p>
                </div>
                <div class="hotline d-lg-inline-flex">
                    <img src="{{ asset('frontend/imgs/theme/icons/phone-call.svg') }}" alt="hotline" />
                    <p>1900 - 8888<span>24/7 Support Center</span></p>
                </div>
            </div>
            <div class="col-xl-4 col-lg-6 col-md-6 text-end d-none d-md-block">
                <div class="mobile-social-icon">
                    <h6>Follow Us</h6>
                    @forelse ($footerSocialIcons as $social)
                        @php
                            $socialIcon = !empty($social['icon'])
                                ? asset('storage/' . ltrim($social['icon'], '/'))
                                : asset('frontend/imgs/theme/icons/icon-facebook-white.svg');
                            $socialUrl = !empty($social['url']) ? $social['url'] : '#';
                        @endphp
                        <a href="{{ $socialUrl }}"><img src="{{ $socialIcon }}" alt="" /></a>
                    @empty
                        <a href="#"><img src="{{ asset('frontend/imgs/theme/icons/icon-facebook-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('frontend/imgs/theme/icons/icon-twitter-white.svg') }}" alt="" /></a>
                        <a href="#"><img src="{{ asset('frontend/imgs/theme/icons/icon-instagram-white.svg') }}" alt="" /></a>
                    @endforelse
                </div>
                <p class="font-sm">Up to 15% discount on your first subscribe</p>
            </div>
        </div>
    </div>
</footer>
