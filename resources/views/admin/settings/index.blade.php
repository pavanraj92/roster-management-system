@extends('admin.layouts.app')
@section('title', 'Profile setting')
@section('content')
    <section class="content-main admin-form-page">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Website Settings</h2>
                    <p class="listing-page-subtitle mb-3">Configure general site information, home page content, and social links.</p>
                </div>
                <x-admin.breadcrumb :list="[['label' => 'Website Settings']]" class="float-end" />
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="row gx-5">
                    <aside class="col-lg-3 border-end">
                        <nav class="nav nav-pills flex-lg-column mb-4">
                            <a class="nav-link {{ $tab == 'website' ? 'active' : '' }}"
                                href="{{ route('admin.settings.index', ['tab' => 'website']) }}">General</a>
                            <a class="nav-link {{ $tab == 'system' ? 'active' : '' }}"
                                href="{{ route('admin.settings.index', ['tab' => 'system']) }}">System Settings</a>
                            <a class="nav-link {{ $tab == 'social-icons' ? 'active' : '' }}"
                                href="{{ route('admin.settings.index', ['tab' => 'social-icons']) }}">Social Media Links</a>
                        </nav>
                    </aside>
                    <div class="col-lg-9">
                        <section class="content-body p-xl-4">
                            <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="group" value="{{ $tab }}">
                                @if($tab == 'website')
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row gx-3">
                                                <div class="col-12 mb-3">
                                                    <label class="form-label" for="site_name">Site Name</label>
                                                    <input class="form-control @error('site_name') is-invalid @enderror" type="text" name="site_name" id="site_name"
                                                        placeholder="Type here" value="{{ old('site_name', $settings['site_name'] ?? '') }}" />
                                                    @error('site_name')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label" for="site_tagline">Site Tagline</label>
                                                    <input class="form-control @error('site_tagline') is-invalid @enderror" type="text" name="site_tagline" id="site_tagline"
                                                        placeholder="e.g. Best Roster Management System" value="{{ old('site_tagline', $settings['site_tagline'] ?? '') }}" />
                                                    @error('site_tagline')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="site_email">Email</label>
                                                    <input class="form-control @error('site_email') is-invalid @enderror" type="email" name="site_email" id="site_email"
                                                        placeholder="example@mail.com"
                                                        value="{{ old('site_email', $settings['site_email'] ?? '') }}" />
                                                    @error('site_email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="site_phone">Phone</label>
                                                    <input class="form-control @error('site_phone') is-invalid @enderror" type="tel" name="site_phone" id="site_phone"
                                                        placeholder="+1234567890" value="{{ old('site_phone', $settings['site_phone'] ?? '') }}" />
                                                    @error('site_phone')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-12 mb-3">
                                                    <label class="form-label" for="site_address">Address</label>
                                                    <input class="form-control @error('site_address') is-invalid @enderror" type="text" name="site_address"
                                                        id="site_address" placeholder="Type here"
                                                        value="{{ old('site_address', $settings['site_address'] ?? '') }}" />
                                                    @error('site_address')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="col-12 mb-3">
                                                    <label class="form-label" for="footer_text">Footer Copyright Text</label>
                                                    <input class="form-control" type="text" name="footer_text" id="footer_text"
                                                        placeholder="Type here" value="{{ $settings['footer_text'] ?? '' }}" />
                                                </div>
                                            </div>
                                        </div>
                                        <aside class="col-lg-4">
                                            <figure class="text-lg-center">
                                                <label class="form-label d-block text-start">Logo</label>
                                                <a href="{{ isset($settings['logo']) ? asset('storage/' . $settings['logo']) : asset('backend/imgs/theme/upload.svg') }}"
                                                    class="image-popup" id="logo-popup">
                                                    <img class="img-lg mb-3 img-avatar border p-2 bg-white"
                                                        src="{{ isset($settings['logo']) ? asset('storage/' . $settings['logo']) : asset('backend/imgs/theme/upload.svg') }}"
                                                        id="logo-preview" alt="Logo Photo"
                                                        style="width: 100px; height: 100px; object-fit: contain;" />
                                                </a>
                                                <figcaption>
                                                    <label class="btn btn-light rounded font-md" for="logo-input">
                                                        <i class="icons material-icons md-backup font-md"></i> Upload
                                                    </label>
                                                    <input type="file" name="logo" id="logo-input" class="d-none">
                                                </figcaption>
                                            </figure>
                                            <hr>
                                            <figure class="text-lg-center mt-4">
                                                <label class="form-label d-block text-start">Favicon</label>
                                                <a href="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('backend/imgs/theme/upload.svg') }}"
                                                    class="image-popup" id="favicon-popup">
                                                    <img class="img-sm mb-3 img-avatar border p-1 bg-white"
                                                        src="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('backend/imgs/theme/upload.svg') }}"
                                                        id="favicon-preview" alt="Favicon Photo"
                                                        style="width: 32px; height: 32px; object-fit: contain;" />
                                                </a>
                                                <figcaption>
                                                    <label class="btn btn-light rounded font-md" for="favicon-input">
                                                        <i class="icons material-icons md-backup font-md"></i> Upload
                                                    </label>
                                                    <input type="file" name="favicon" id="favicon-input" class="d-none">
                                                </figcaption>
                                            </figure>
                                        </aside>
                                    </div>
                                @elseif($tab == 'system')
                                    <div class="row">
                                        <div class="col-lg-8">
                                            <div class="row gx-3">
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="date_format">Date Format</label>
                                                    <select class="form-select" name="date_format" id="date_format">
                                                        <option value="d-m-Y" {{ ($settings['date_format'] ?? '') == 'd-m-Y' ? 'selected' : '' }}>DD-MM-YYYY</option>
                                                        <option value="m-d-Y" {{ ($settings['date_format'] ?? '') == 'm-d-Y' ? 'selected' : '' }}>MM-DD-YYYY</option>
                                                        <option value="Y-m-d" {{ ($settings['date_format'] ?? '') == 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                                                        <option value="d M, Y" {{ ($settings['date_format'] ?? '') == 'd M, Y' ? 'selected' : '' }}>15 Jun, 2024</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="time_format">Time Format</label>
                                                    <select class="form-select" name="time_format" id="time_format">
                                                        <option value="H:i" {{ ($settings['time_format'] ?? '') == 'H:i' ? 'selected' : '' }}>24-hour (14:30)</option>
                                                        <option value="h:i A" {{ ($settings['time_format'] ?? '') == 'h:i A' ? 'selected' : '' }}>12-hour (02:30 PM)</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="pagination_limit">Page Pagination Limit</label>
                                                    <input type="number" name="pagination_limit" class="form-control"
                                                        placeholder="e.g. 10" value="{{ $settings['pagination_limit'] ?? '10' }}" min="1">
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="timezone">Timezone</label>
                                                    <select class="form-select" name="timezone" id="timezone">
                                                        <option value="UTC" {{ ($settings['timezone'] ?? '') == 'UTC' ? 'selected' : '' }}>UTC</option>
                                                        <option value="Asia/Kolkata" {{ ($settings['timezone'] ?? '') == 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata (IST)</option>
                                                        <option value="Europe/London" {{ ($settings['timezone'] ?? '') == 'Europe/London' ? 'selected' : '' }}>Europe/London (GMT)</option>
                                                        <option value="America/New_York" {{ ($settings['timezone'] ?? '') == 'America/New_York' ? 'selected' : '' }}>America/New_York (EST)</option>
                                                        <option value="Australia/Sydney" {{ ($settings['timezone'] ?? '') == 'Australia/Sydney' ? 'selected' : '' }}>Australia/Sydney (AEST)</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="currency">Currency Symbol</label>
                                                    <input type="text" name="currency" class="form-control"
                                                        placeholder="e.g. $, £, ₹" value="{{ $settings['currency'] ?? '$' }}">
                                                </div>
                                                <div class="col-12 mt-3">
                                                    <label class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox" name="maintenance_mode" value="1" 
                                                            {{ ($settings['maintenance_mode'] ?? '') == '1' ? 'checked' : '' }}>
                                                        <span class="form-check-label">Enable Maintenance Mode</span>
                                                    </label>
                                                    <p class="text-muted small">When enabled, the public site will show a "Down for Maintenance" page.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @elseif($tab == 'social-icons')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="mb-3">Social Media Links</h5>
                                            <div id="social-icons-repeater">
                                                @php
                                                    $socialIcons = $settings['social_icons'] ?? [];
                                                @endphp
                                                @forelse($socialIcons as $index => $item)
                                                    <div class="row mb-4 align-items-center social-icon-row border-bottom pb-3">
                                                        <div class="col-md-2 text-center">
                                                            <a href="{{ !empty($item['icon']) ? asset('storage/' . $item['icon']) : asset('backend/imgs/theme/upload.svg') }}"
                                                                class="image-popup">
                                                                <img src="{{ !empty($item['icon']) ? asset('storage/' . $item['icon']) : asset('backend/imgs/theme/upload.svg') }}"
                                                                    class="img-sm img-thumbnail mb-2 preview-image"
                                                                    style="width: 50px; height: 50px; object-fit: contain;"
                                                                    id="social-preview-{{ $index }}">
                                                            </a>
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Icon Image</label>
                                                            <div class="input-upload">
                                                                <label class="btn btn-light rounded font-md"
                                                                    for="social-input-{{ $index }}">
                                                                    <i class="icons material-icons md-backup font-md"></i> Upload
                                                                </label>
                                                                <input type="file" name="social_icons[{{ $index }}][icon]"
                                                                    id="social-input-{{ $index }}" class="d-none icon-input"
                                                                    accept="image/*">
                                                            </div>
                                                            <input type="hidden" name="social_icons[{{ $index }}][old_icon]"
                                                                value="{{ $item['icon'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">URL</label>
                                                            <input type="url" name="social_icons[{{ $index }}][url]"
                                                                value="{{ $item['url'] ?? '' }}" class="form-control"
                                                                placeholder="https://facebook.com/yourpage">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-row">Remove</button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="row mb-4 align-items-center social-icon-row border-bottom pb-3">
                                                        <div class="col-md-2 text-center">
                                                            <img src="{{ asset('backend/imgs/theme/upload.svg') }}"
                                                                class="img-sm img-thumbnail mb-2 preview-image"
                                                                style="width: 50px; height: 50px; object-fit: contain;"
                                                                id="social-preview-0">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Icon Image</label>
                                                            <div class="input-upload">
                                                                <label class="btn btn-light rounded font-md" for="social-input-0">
                                                                    <i class="icons material-icons md-backup font-md"></i> Upload
                                                                </label>
                                                                <input type="file" name="social_icons[0][icon]" id="social-input-0"
                                                                    class="d-none icon-input" accept="image/*">
                                                            </div>
                                                            <input type="hidden" name="social_icons[0][old_icon]" value="">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">URL</label>
                                                            <input type="url" name="social_icons[0][url]" class="form-control"
                                                                placeholder="https://facebook.com/yourpage">
                                                        </div>
                                                        <div class="col-md-2">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-row">Remove</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <button type="button" id="add-social-icon" class="btn btn-secondary btn-sm mt-3">Add
                                                New Social Link</button>
                                        </div>
                                    </div>
                                @endif

                                <br />
                                <button class="btn btn-primary" type="submit">Save</button>
                            </form>
                        </section>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
    <script>
        $(document).ready(function () {
            $('#logo-input').on('change', function (evt) {
                const [file] = evt.target.files
                if (file) {
                    const url = URL.createObjectURL(file);
                    $('#logo-preview').attr('src', url);
                    $('#logo-popup').attr('href', url);
                }
            });
            $('#favicon-input').on('change', function (evt) {
                const [file] = evt.target.files
                if (file) {
                    const url = URL.createObjectURL(file);
                    $('#favicon-preview').attr('src', url);
                    $('#favicon-popup').attr('href', url);
                }
            });

            // Social Icons Repeater
            let socialIconIndex = {{ count($settings['social_icons'] ?? [0]) }};

            $('#add-social-icon').on('click', function () {
                let html = `
                            <div class="row mb-4 align-items-center social-icon-row border-bottom pb-3">
                                <div class="col-md-2 text-center">
                                    <img src="{{ asset('backend/imgs/theme/upload.svg') }}"
                                        class="img-sm img-thumbnail mb-2 preview-image"
                                        style="width: 50px; height: 50px; object-fit: contain;"
                                        id="social-preview-${socialIconIndex}">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">Icon Image</label>
                                    <div class="input-upload">
                                        <label class="btn btn-light rounded font-md" for="social-input-${socialIconIndex}">
                                            <i class="icons material-icons md-backup font-md"></i> Upload
                                        </label>
                                        <input type="file" name="social_icons[${socialIconIndex}][icon]" 
                                            id="social-input-${socialIconIndex}" class="d-none icon-input" accept="image/*">
                                    </div>
                                    <input type="hidden" name="social_icons[${socialIconIndex}][old_icon]" value="">
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label">URL</label>
                                    <input type="url" name="social_icons[${socialIconIndex}][url]" class="form-control" placeholder="https://facebook.com/yourpage">
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-danger btn-sm remove-row">Remove</button>
                                </div>
                            </div>
                        `;
                $('#social-icons-repeater').append(html);
                socialIconIndex++;
            });

            // Service Highlights Repeater
            let serviceIndex = {{ count($settings['service_highlights'] ?? [0]) }};

            $('#add-service-highlight').on('click', function () {
                let html = `
                                                            <div class="row mb-4 align-items-center service-row border-bottom pb-3">
                                                                <div class="col-md-2 text-center">
                                                                    <img src="{{ asset('backend/imgs/theme/upload.svg') }}"
                                                                        class="img-sm img-thumbnail mb-2 preview-image"
                                                                        style="width: 50px; height: 50px; object-fit: contain;"
                                                                        id="service-preview-${serviceIndex}">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Image</label>
                                                                    <div class="input-upload">
                                                                        <label class="btn btn-light rounded font-md" for="service-input-${serviceIndex}">
                                                                            <i class="icons material-icons md-backup font-md"></i> Upload
                                                                        </label>
                                                                        <input type="file" name="service_highlights[${serviceIndex}][image]" 
                                                                            id="service-input-${serviceIndex}" class="d-none service-image-input" accept="image/*">
                                                                    </div>
                                                                    <input type="hidden" name="service_highlights[${serviceIndex}][old_image]" value="">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Title</label>
                                                                    <input type="text" name="service_highlights[${serviceIndex}][title]" class="form-control" placeholder="Best Prices & Offers">
                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label class="form-label">Sub-Title</label>
                                                                    <input type="text" name="service_highlights[${serviceIndex}][sub_title]" class="form-control" placeholder="Orders $50 or more">
                                                                </div>
                                                                <div class="col-md-1">
                                                                    <button type="button" class="btn btn-danger btn-sm remove-service-row">Remove</button>
                                                                </div>
                                                            </div>
                                                        `;
                $('#service-highlights-repeater').append(html);
                serviceIndex++;
            });

            $(document).on('change', '.icon-input, .service-image-input', function (evt) {
                const [file] = evt.target.files;
                if (file) {
                    $(this).closest('.row').find('.preview-image').attr('src', URL.createObjectURL(file));
                }
            });

            $(document).on('click', '.remove-row', function () {
                if ($('.social-icon-row').length > 1) {
                    $(this).closest('.social-icon-row').remove();
                } else {
                    let row = $(this).closest('.social-icon-row');
                    row.find('input[type="file"], input[type="url"]').val('');
                    row.find('input[type="hidden"]').val('');
                    row.find('.preview-image').attr('src', "{{ asset('backend/imgs/theme/upload.svg') }}");
                }
            });

            $(document).on('click', '.remove-service-row', function () {
                if ($('.service-row').length > 1) {
                    $(this).closest('.service-row').remove();
                } else {
                    let row = $(this).closest('.service-row');
                    row.find('input[type="file"], input[type="text"]').val('');
                    row.find('input[type="hidden"]').val('');
                    row.find('.preview-image').attr('src', "{{ asset('backend/imgs/theme/upload.svg') }}");
                }
            });
        });
    </script>
@endpush