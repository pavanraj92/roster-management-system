@extends('admin.layouts.app')

@section('title', 'Banner Details')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Banner Details</h2>
                    <p class="listing-page-subtitle mb-3">View details of banner: {{ $banner->title }}</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Banners', 'url' => route('admin.settings.banners.index')],
            ['label' => 'Banner Details']
        ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="details-media-panel">
                            <img src="{{ $banner->image ? asset('storage/' . $banner->image) : asset('backend/imgs/theme/upload.svg') }}"
                                class="details-image" alt="{{ $banner->title }}">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="details-info-group">
                            <div class="details-item">
                                <span class="details-label">Title</span>
                                <span class="details-value"><strong>{{ $banner->title }}</strong></span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Subtitle</span>
                                <span class="details-value"><code>{{ $banner->sub_title }}</code></span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Type</span>
                                <span class="details-value">
                                    @if ($banner->is_sub_banner)
                                        <span class="badge rounded-pill bg-info text-white me-1">Sub
                                            Banner</span>
                                    @endif
                                    @if ($banner->is_single_banner)
                                        <span class="badge rounded-pill bg-warning text-dark me-1">Single Banner</span>
                                    @endif
                                    @if (!$banner->is_sub_banner && !$banner->is_single_banner)
                                        <span class="badge rounded-pill bg-primary text-white me-1">Main Banner</span>
                                    @endif
                                </span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Status</span>
                                <span class="details-value">
                                    @if ($banner->status)
                                        <span class="badge bg-success rounded-pill">Active</span>
                                    @else
                                        <span class="badge bg-secondary rounded-pill">Inactive</span>
                                    @endif
                                </span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Created Date</span>
                                <span class="details-value">{{ $banner->created_at->format('M d, Y') }} <small
                                        class="text-muted">at {{ $banner->created_at->format('h:i A') }}</small></span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Last Updated</span>
                                <span class="details-value">{{ $banner->updated_at->format('M d, Y') }} <small
                                        class="text-muted">at {{ $banner->updated_at->format('h:i A') }}</small></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.settings.banners.edit', $banner->id) }}" class="btn btn-primary">
                        <i class="material-icons md-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.settings.banners.index') }}" class="btn btn-light">
                        <i class="material-icons md-arrow_back"></i> Back to list
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection