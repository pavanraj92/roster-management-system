@extends('admin.layouts.app')

@section('title', 'Page Details')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Page Details</h2>
                    <p class="listing-page-subtitle mb-3">
                        View details of page: {{ $page->title }}
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Pages Manager', 'url' => route('admin.pages.index')],
            ['label' => 'Page Details']
        ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="details-info-group">

                    {{-- Title --}}
                    <div class="details-item">
                        <span class="details-label">Page Title</span>
                        <span class="details-value">
                            <strong>{{ $page->title }}</strong>
                        </span>
                    </div>

                    {{-- Subtitle --}}
                    @if ($page->subtitle)
                        <div class="details-item">
                            <span class="details-label">Subtitle</span>
                            <span class="details-value">{{ $page->subtitle }}</span>
                        </div>
                    @endif

                    {{-- Slug --}}
                    <div class="details-item">
                        <span class="details-label">Slug</span>
                        <span class="details-value">
                            <code>{{ $page->slug }}</code>
                        </span>
                    </div>

                    {{-- Status --}}
                    <div class="details-item">
                        <span class="details-label">Status</span>
                        <span class="details-value">
                            @if ($page->status)
                                <span class="badge bg-success rounded-pill">Active</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Inactive</span>
                            @endif
                        </span>
                    </div>

                    {{-- Created Date --}}
                    <div class="details-item">
                        <span class="details-label">Created Date</span>
                        <span class="details-value">
                            {{ $page->created_at->format('M d, Y') }}
                            <small class="text-muted">
                                at {{ $page->created_at->format('h:i A') }}
                            </small>
                        </span>
                    </div>

                    {{-- Updated Date --}}
                    <div class="details-item">
                        <span class="details-label">Last Updated</span>
                        <span class="details-value">
                            {{ $page->updated_at->format('M d, Y') }}
                            <small class="text-muted">
                                at {{ $page->updated_at->format('h:i A') }}
                            </small>
                        </span>
                    </div>

                </div>

                {{-- Content Section --}}
                @if ($page->short_description || $page->description)
                    <div class="card mb-4">
                        <header class="card-header">
                            <h4 class="card-title">Page Content</h4>
                        </header>
                        <div class="card-body">

                            @if ($page->short_description)
                                <div class="mb-4">
                                    <h6>Short Description</h6>
                                    <p class="text-muted">{{ $page->short_description }}</p>
                                </div>
                            @endif

                            @if ($page->description)
                                <div>
                                    <h6>Full Description</h6>
                                    <div class="border p-3 rounded bg-light">
                                        {!! $page->description !!}
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif

                {{-- SEO Section --}}
                @if ($page->meta_title || $page->meta_keyword || $page->meta_description)
                    <div class="card mb-4">
                        <header class="card-header">
                            <h4 class="card-title">SEO Information</h4>
                        </header>
                        <div class="card-body">

                            @if ($page->meta_title)
                                <div class="mb-3">
                                    <strong>Meta Title:</strong>
                                    <p class="mb-1">{{ $page->meta_title }}</p>
                                </div>
                            @endif

                            @if ($page->meta_keyword)
                                <div class="mb-3">
                                    <strong>Meta Keyword:</strong>
                                    <p class="mb-1">{{ $page->meta_keyword }}</p>
                                </div>
                            @endif

                            @if ($page->meta_description)
                                <div>
                                    <strong>Meta Description:</strong>
                                    <p class="mb-1">{{ $page->meta_description }}</p>
                                </div>
                            @endif

                        </div>
                    </div>
                @endif

                <div>
                    <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-primary">
                        <i class="material-icons md-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.pages.index') }}" class="btn btn-light">
                        <i class="material-icons md-arrow_back"></i> Back to list
                    </a>
                </div>
            </div>
        </div>

    </section>
@endsection