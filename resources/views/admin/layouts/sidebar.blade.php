@php
    $setting = \App\Models\Setting::where('key', 'logo')->first();
    $logoPath = $setting && $setting->value ? storage_path('app/public/' . $setting->value) : null;
@endphp
<aside class="navbar-aside" id="offcanvas_aside">
    <div class="aside-top">
        <a href="{{ route('admin.dashboard') }}" class="brand-wrap">
            <img src="{{ $setting && $setting->value && $logoPath && file_exists($logoPath) ? asset('storage/' . $setting->value) : asset('backend/imgs/theme/logo.png') }}"
                class="logo" alt="Logo" />
        </a>
        <div>
            <button class="btn btn-icon btn-aside-minimize"><i
                    class="text-muted material-icons md-menu_open"></i></button>
        </div>
    </div>
    <nav>
        <ul class="menu-aside">
            @can('dashboard_access')
                <li class="menu-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.dashboard') }}">
                        <i class="icon material-icons md-home"></i>
                        <span class="text">Dashboard</span>
                    </a>
                </li>
            @endcan

            @can('user_access')
                <li class="menu-item {{ request()->routeIs('admin.staff.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.staff.index') }}">
                        <i class="icon material-icons md-person"></i>
                        <span class="text">Staff Manager</span>
                    </a>
                </li>
            @endcan

            @can('role_access')
                <li
                    class="menu-item has-submenu {{ request()->routeIs('admin.roles.*', 'admin.permissions.*') ? 'active' : '' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-security"></i>
                        <span class="text">Roles & Permissions</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('admin.roles.index') }}"
                            class="{{ request()->routeIs('admin.roles.*') ? 'active' : '' }}">Roles</a>
                        <a href="{{ route('admin.permissions.index') }}"
                            class="{{ request()->routeIs('admin.permissions.*') ? 'active' : '' }}">Permissions</a>
                    </div>
                </li>
            @endcan

            @can('page_access')
                <li class="menu-item {{ request()->routeIs('admin.pages.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.pages.index') }}">
                        <i class="icon material-icons md-description"></i>
                        <span class="text">Pages</span>
                    </a>
                </li>
            @endcan

            @can('email_template_access')
                <li class="menu-item {{ request()->routeIs('admin.email-templates.*') ? 'active' : '' }}">
                    <a class="menu-link" href="{{ route('admin.email-templates.index') }}">
                        <i class="icon material-icons md-email"></i>
                        <span class="text">Email Templates</span>
                    </a>
                </li>
            @endcan
        </ul>
        <hr />
        <ul class="menu-aside">
            @can('setting_access')
                <li class="menu-item has-submenu {{ request()->routeIs('admin.settings.*') ? 'active' : '' }}">
                    <a class="menu-link" href="#">
                        <i class="icon material-icons md-settings"></i>
                        <span class="text">Settings</span>
                    </a>
                    <div class="submenu">
                        <a href="{{ route('admin.settings.index', ['tab' => 'website']) }}"
                            class="{{ request()->routeIs('admin.settings.index') ? 'active' : '' }}">Website
                            Setting</a>
                        {{-- <a href="{{ route('admin.settings.banners.index') }}"
                        class="{{ request()->is('admin/settings/banners*') ? 'active' : '' }}">Banner Setting</a> --}}
                        <a href="{{ route('admin.settings.visibility.index') }}"
                            class="{{ request()->routeIs('admin.settings.visibility.*') ? 'active' : '' }}">Visibility
                            Setting</a>
                    </div>
                </li>
            @endcan
            <!-- <li class="menu-item">
                <a class="menu-link" href="#">
                    <i class="icon material-icons md-local_offer"></i>
                    <span class="text"> Starter page </span>
                </a>
            </li> -->
        </ul>
        <br />
        <br />
    </nav>
</aside>
