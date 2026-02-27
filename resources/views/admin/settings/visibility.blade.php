@extends('admin.layouts.app')

@section('title', 'Visibility Settings')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Visibility Settings</h2>
                    <p class="listing-page-subtitle mb-3">
                        Choose which fields and sections should be visible on the frontend.
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Visibility Settings']]" class="float-end" />
            </div>
        </div>

        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.settings.visibility.update') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-lg-12">
                            <h5 class="mb-3">Frontend Visibility Settings</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">General Settings</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="site_name"
                                                    id="vis_site_name" {{ ($settings['site_name'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_site_name">Site Name</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="site_email"
                                                    id="vis_site_email" {{ ($settings['site_email'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_site_email">Site Email</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="site_phone"
                                                    id="vis_site_phone" {{ ($settings['site_phone'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_site_phone">Site Phone</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="site_address"
                                                    id="vis_site_address" {{ ($settings['site_address'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_site_address">Site Address</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="footer_text"
                                                    id="vis_footer_text" {{ ($settings['footer_text'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_footer_text">Footer Text</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="logo" id="vis_logo" {{ ($settings['logo'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_logo">Logo</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="favicon"
                                                    id="vis_favicon" {{ ($settings['favicon'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_favicon">Favicon</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h6 class="mb-0">Sections & Components</h6>
                                        </div>
                                        <div class="card-body">
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="main_banner"
                                                    id="vis_main_banner" {{ ($settings['main_banner'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_main_banner">Main Banner</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="featured_categories"
                                                    id="vis_featured_categories" {{ ($settings['featured_categories'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_featured_categories">Featured
                                                    Categories</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="sub_banner"
                                                    id="vis_sub_banner" {{ ($settings['sub_banner'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_sub_banner">Sub Banner</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="hero_title"
                                                    id="vis_hero_title" {{ ($settings['hero_title'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_hero_title">Hero Title</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="hero_subtitle"
                                                    id="vis_hero_subtitle" {{ ($settings['hero_subtitle'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_hero_subtitle">Hero
                                                    Subtitle</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="single_banner"
                                                    id="vis_single_banner" {{ ($settings['single_banner'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_single_banner">Single
                                                    Banner</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="social_icons"
                                                    id="vis_social_icons" {{ ($settings['social_icons'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_social_icons">Social Icons</label>
                                            </div>
                                            <div class="form-check mb-3">
                                                <input class="form-check-input" type="checkbox" name="service_highlights"
                                                    id="vis_service_highlights" {{ ($settings['service_highlights'] ?? false) ? 'checked' : '' }}>
                                                <label class="form-check-label" for="vis_service_highlights">Service
                                                    Highlights</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <button class="btn btn-primary" type="submit">Save changes</button>
                </form>
            </div>
        </div>
    </section>
@endsection