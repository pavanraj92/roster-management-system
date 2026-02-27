@php
    $mainLogo = !empty($websiteSettings['logo']) ?  asset('storage/' . ltrim($websiteSettings['logo'], '/')) 
     : asset('frontend/imgs/theme/logo.png');
    $selectedParentIdentifier = '';
@endphp

<header class="header-area header-style-1 header-height-2">
    <div class="mobile-promotion">
        <span>Welcome to <strong>{{ config('app.name', 'Roster') }}</strong> – manage your staff and schedules</span>
    </div>
    <div class="header-middle header-middle-ptb-1 d-none d-lg-block">
        <div class="container">
            <div class="header-wrap">
                <div class="logo logo-width-1">
                    <a href="{{ route('home') }}"><img src="{{ $mainLogo ?? asset('frontend/imgs/theme/logo.png') }}" alt="logo" /></a>
                </div>
                <div class="header-right">
                    <div class="header-action-right">
                        <div class="header-action-2">
                            <div class="header-action-icon-2">
                                @auth
                                    <a href="{{ route('home') }}">
                                        <img class="svgInject" alt="Account" src="{{ asset('frontend/imgs/theme/icons/icon-user.svg') }}" />
                                    </a>
                                    <a href="{{ route('home') }}"><span class="lable ml-0">Account</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <li><a href="{{ route('home') }}"><i class="fi fi-rs-user mr-10"></i>My Account</a></li>
                                            @if(Route::has('logout'))
                                                <li>
                                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('header-logout-form').submit();">
                                                        <i class="fi fi-rs-sign-out mr-10"></i>Sign out
                                                    </a>
                                                    <form id="header-logout-form" method="POST" action="{{ route('logout') }}" class="d-none">
                                                        @csrf
                                                    </form>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                @else
                                    <a href="{{ route('login') }}">
                                        <img class="svgInject" alt="Login" src="{{ asset('frontend/imgs/theme/icons/icon-user.svg') }}" />
                                    </a>
                                    <a href="{{ route('login') }}"><span class="lable ml-0">Login</span></a>
                                    <div class="cart-dropdown-wrap cart-dropdown-hm2 account-dropdown">
                                        <ul>
                                            <li><a href="{{ route('login') }}"><i class="fi fi-rs-user mr-10"></i>Login</a></li>
                                            <li><a href="{{ route('register') }}"><i class="fi fi-rs-user mr-10"></i>Sign Up</a></li>
                                        </ul>
                                    </div>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="header-bottom header-bottom-bg-color">
        <div class="container">
            {{-- <div class="header-subcategory-row d-none d-lg-block" id="header-subcategory-row" style="display: none;">
                <div class="header-subcategory-items" id="header-subcategory-items"></div>
            </div> --}}
            <div class="header-wrap header-space-between position-relative">
                <div class="logo logo-width-1 d-block d-lg-none">
                    <a href="{{ route('home') }}"><img src="{{ asset('frontend/imgs/theme/logo.png') }}" alt="logo" /></a>
                </div>
                <div class="header-nav d-none d-lg-flex">
                    <div class="main-menu main-menu-padding-1 main-menu-lh-2 d-none d-lg-block font-heading">
                        <nav>
                            <ul>
                                <li>
                                    <a class="{{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                                </li>
                                <li>
                                    <a href="{{ route('home') }}">Deals</a>
                                </li>
                                <li>
                                    <a href="{{ route('pages.about', 'about') }}">About</a>
                                </li>
                                <li>
                                    <a href="{{ route('home') }}">Contact</a>
                                </li>
                                @guest
                                    <li><a href="{{ route('login') }}">Login</a></li>
                                    <li><a href="{{ route('register') }}">Sign Up</a></li>
                                @endguest
                            </ul>
                        </nav>
                    </div>
                </div>
                <div class="hotline d-none d-lg-flex">
                    <img src="{{ asset('frontend/imgs/theme/icons/icon-headphone.svg') }}" alt="hotline" />
                    <p>24/7 Support<span>Customer Care</span></p>
                </div>
                <div class="header-action-icon-2 d-block d-lg-none">
                    <div class="burger-icon burger-icon-white">
                        <span class="burger-icon-top"></span>
                        <span class="burger-icon-mid"></span>
                        <span class="burger-icon-bottom"></span>
                    </div>
                </div>
                <!-- mobile wishlist/cart icons removed for roster app -->
            </div>
        </div>
    </div>
</header>

<style>
    /* ecommerce header subcategory styles removed */
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const selectElement = document.getElementById('header-category-select');
        const searchFormElement = document.getElementById('header-search-form');
        const rowElement = document.getElementById('header-subcategory-row');
        const itemsElement = document.getElementById('header-subcategory-items');

        if (!selectElement) {
            return;
        }


        const renderSubcategories = (selectedOption) => {
            if (!rowElement || !itemsElement) {
                return;
            }

            const parentId = selectedOption?.dataset?.categoryId;
           
            const selectedCategory = parentId ? categoriesById[String(parentId)] : null;
            const subcategories = selectedCategory?.subcategories?.length ? selectedCategory.subcategories : allSubcategories;

            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.slick && window.jQuery(itemsElement).hasClass('slick-initialized')) {
                window.jQuery(itemsElement).slick('unslick');
            }

            itemsElement.innerHTML = '';

            if (!subcategories.length) {
                rowElement.style.display = 'none';
                return;
            }

            subcategories.forEach((subcategory) => {
                const link = document.createElement('a');
                link.className = 'header-subcategory-card';
                link.href = ``;
                link.innerHTML = `<img src="${subcategory.image}" alt="${subcategory.name}"><span>${subcategory.name}</span>`;
                itemsElement.appendChild(link);
            });

            rowElement.style.display = 'block';

            if (window.jQuery && window.jQuery.fn && window.jQuery.fn.slick) {
                window.jQuery(itemsElement).slick({
                    infinite: false,
                    slidesToShow: 6,
                    slidesToScroll: 2,
                    arrows: true,
                    dots: false,
                    prevArrow: '<button type="button" class="slick-prev" aria-label="Previous"><i class="fi-rs-angle-small-left"></i></button>',
                    nextArrow: '<button type="button" class="slick-next" aria-label="Next"><i class="fi-rs-angle-small-right"></i></button>',
                    responsive: [
                        {
                            breakpoint: 1400,
                            settings: { slidesToShow: 5, slidesToScroll: 2 }
                        },
                        {
                            breakpoint: 1200,
                            settings: { slidesToShow: 4, slidesToScroll: 2 }
                        },
                        {
                            breakpoint: 992,
                            settings: { slidesToShow: 3, slidesToScroll: 1 }
                        }
                    ]
                });
            }
        };

        const onCategoryChange = () => {
            const selectedOption = selectElement.options[selectElement.selectedIndex];
            renderSubcategories(selectedOption);
            if (searchFormElement) {
                searchFormElement.submit();
            }
        };

        renderSubcategories(selectElement.options[selectElement.selectedIndex]);
        selectElement.addEventListener('change', onCategoryChange);

        if (window.jQuery) {
            window.jQuery(selectElement).on('change select2:select', onCategoryChange);
        }
    });
</script>
