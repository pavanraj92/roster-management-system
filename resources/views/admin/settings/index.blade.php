@extends('admin.layouts.app')

@section('title', 'Profile setting')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Website Settings</h2>
                    <p class="listing-page-subtitle mb-3">Configure general site information, home page content, and social links.</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Website Settings']]" class="float-end" />
            </div>
        </div>

        <div class="content-header">
            <div>
            </div>
        </div>
        <div class="card">
            <div class="card-body">
                <div class="row gx-5">
                    <aside class="col-lg-3 border-end">
                        <nav class="nav nav-pills flex-lg-column mb-4">
                            <a class="nav-link {{ $tab == 'website' ? 'active' : '' }}"
                                href="{{ route('admin.settings.index', ['tab' => 'website']) }}">General</a>
                            <a class="nav-link {{ $tab == 'home' ? 'active' : '' }}"
                                href="{{ route('admin.settings.index', ['tab' => 'home']) }}">Home Page</a>
                            <a class="nav-link {{ $tab == 'social-icons' ? 'active' : '' }}"
                                href="{{ route('admin.settings.index', ['tab' => 'social-icons']) }}">Social Icons</a>
                            <a class="nav-link {{ $tab == 'service-highlights' ? 'active' : '' }}"
                                href="{{ route('admin.settings.index', ['tab' => 'service-highlights']) }}">Service Highlights</a>
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
                                                    <input class="form-control" type="text" name="site_name" id="site_name"
                                                        placeholder="Type here" value="{{ $settings['site_name'] ?? '' }}" />
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="site_email">Email</label>
                                                    <input class="form-control" type="email" name="site_email" id="site_email"
                                                        placeholder="example@mail.com"
                                                        value="{{ $settings['site_email'] ?? '' }}" />
                                                </div>
                                                <div class="col-lg-6 mb-3">
                                                    <label class="form-label" for="site_phone">Phone</label>
                                                    <input class="form-control" type="tel" name="site_phone" id="site_phone"
                                                        placeholder="+1234567890" value="{{ $settings['site_phone'] ?? '' }}" />
                                                </div>
                                                <div class="col-lg-12 mb-3">
                                                    <label class="form-label" for="site_address">Address</label>
                                                    <input class="form-control" type="text" name="site_address"
                                                        id="site_address" placeholder="Type here"
                                                        value="{{ $settings['site_address'] ?? '' }}" />
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
                                                <img class="img-lg mb-3 img-avatar"
                                                    src="{{ isset($settings['logo']) ? asset('storage/' . $settings['logo']) : asset('backend/imgs/theme/upload.svg') }}"
                                                    id="logo-preview" alt="Logo Photo"
                                                    style="width: 100px; height: 100px; object-fit: contain;" />
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
                                                <img class="img-sm mb-3 img-avatar"
                                                    src="{{ isset($settings['favicon']) ? asset('storage/' . $settings['favicon']) : asset('backend/imgs/theme/upload.svg') }}"
                                                    id="favicon-preview" alt="Favicon Photo"
                                                    style="width: 32px; height: 32px; object-fit: contain;" />
                                                <figcaption>
                                                    <label class="btn btn-light rounded font-md" for="favicon-input">
                                                        <i class="icons material-icons md-backup font-md"></i> Upload
                                                    </label>
                                                    <input type="file" name="favicon" id="favicon-input" class="d-none">
                                                </figcaption>
                                            </figure>
                                        </aside>
                                    </div>
                                @elseif($tab == 'home')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="mb-3">Hero Section</h5>
                                            <div class="mb-4">
                                                <label for="hero_title" class="form-label">Hero Title</label>
                                                <input type="text" name="hero_title" value="{{ $settings['hero_title'] ?? '' }}"
                                                    class="form-control" id="hero_title">
                                            </div>
                                            <div class="mb-4">
                                                <label for="hero_subtitle" class="form-label">Hero Subtitle</label>
                                                <textarea name="hero_subtitle" class="form-control" id="hero_subtitle"
                                                    rows="2">{{ $settings['hero_subtitle'] ?? '' }}</textarea>
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
                                                            <img src="{{ !empty($item['icon']) ? asset('storage/' . $item['icon']) : asset('backend/imgs/theme/upload.svg') }}"
                                                                class="img-sm img-thumbnail mb-2 preview-image"
                                                                style="width: 50px; height: 50px; object-fit: contain;"
                                                                id="social-preview-{{ $index }}">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label class="form-label">Icon Image</label>
                                                            <div class="input-upload">
                                                                <label class="btn btn-light rounded font-md" for="social-input-{{ $index }}">
                                                                    <i class="icons material-icons md-backup font-md"></i> Upload
                                                                </label>
                                                                <input type="file" name="social_icons[{{ $index }}][icon]" 
                                                                    id="social-input-{{ $index }}" class="d-none icon-input" accept="image/*">
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
                                                                <input type="file" name="social_icons[0][icon]" 
                                                                    id="social-input-0" class="d-none icon-input" accept="image/*">
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
                                @elseif($tab == 'service-highlights')
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <h5 class="mb-3">Service Highlights</h5>
                                            <div id="service-highlights-repeater">
                                                @php
    $highlights = $settings['service_highlights'] ?? [];
                                                @endphp
                                                @forelse($highlights as $index => $item)
                                                    <div class="row mb-4 align-items-center service-row border-bottom pb-3">
                                                        <div class="col-md-2 text-center">
                                                            <img src="{{ !empty($item['image']) ? asset('storage/' . $item['image']) : asset('backend/imgs/theme/upload.svg') }}"
                                                                class="img-sm img-thumbnail mb-2 preview-image"
                                                                style="width: 50px; height: 50px; object-fit: contain;"
                                                                id="service-preview-{{ $index }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Image</label>
                                                            <div class="input-upload">
                                                                <label class="btn btn-light rounded font-md" for="service-input-{{ $index }}">
                                                                    <i class="icons material-icons md-backup font-md"></i> Upload
                                                                </label>
                                                                <input type="file" name="service_highlights[{{ $index }}][image]" 
                                                                    id="service-input-{{ $index }}" class="d-none service-image-input" accept="image/*">
                                                            </div>
                                                            <input type="hidden" name="service_highlights[{{ $index }}][old_image]"
                                                                value="{{ $item['image'] ?? '' }}">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Title</label>
                                                            <input type="text" name="service_highlights[{{ $index }}][title]"
                                                                value="{{ $item['title'] ?? '' }}" class="form-control"
                                                                placeholder="Best Prices & Offers">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Sub-Title</label>
                                                            <input type="text" name="service_highlights[{{ $index }}][sub_title]"
                                                                value="{{ $item['sub_title'] ?? '' }}" class="form-control"
                                                                placeholder="Orders $50 or more">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-service-row">Remove</button>
                                                        </div>
                                                    </div>
                                                @empty
                                                    <div class="row mb-4 align-items-center service-row border-bottom pb-3">
                                                        <div class="col-md-2 text-center">
                                                            <img src="{{ asset('backend/imgs/theme/upload.svg') }}"
                                                                class="img-sm img-thumbnail mb-2 preview-image"
                                                                style="width: 50px; height: 50px; object-fit: contain;"
                                                                id="service-preview-0">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Image</label>
                                                            <div class="input-upload">
                                                                <label class="btn btn-light rounded font-md" for="service-input-0">
                                                                    <i class="icons material-icons md-backup font-md"></i> Upload
                                                                </label>
                                                                <input type="file" name="service_highlights[0][image]" 
                                                                    id="service-input-0" class="d-none service-image-input" accept="image/*">
                                                            </div>
                                                            <input type="hidden" name="service_highlights[0][old_image]" value="">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Title</label>
                                                            <input type="text" name="service_highlights[0][title]" class="form-control"
                                                                placeholder="Best Prices & Offers">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Sub-Title</label>
                                                            <input type="text" name="service_highlights[0][sub_title]" class="form-control"
                                                                placeholder="Orders $50 or more">
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button"
                                                                class="btn btn-danger btn-sm remove-service-row">Remove</button>
                                                        </div>
                                                    </div>
                                                @endforelse
                                            </div>
                                            <button type="button" id="add-service-highlight" class="btn btn-secondary btn-sm mt-3">Add
                                                New Service Highlight</button>
                                        </div>
                                    </div>
                                @endif

                                <br />
                                <button class="btn btn-primary" type="submit">Save changes</button>
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
                    $('#logo-preview').attr('src', URL.createObjectURL(file))
                }
            });
            $('#favicon-input').on('change', function (evt) {
                const [file] = evt.target.files
                if (file) {
                    $('#favicon-preview').attr('src', URL.createObjectURL(file))
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