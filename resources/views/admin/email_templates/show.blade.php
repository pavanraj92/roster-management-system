@extends('admin.layouts.app')

@section('title', 'Email Template Details')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Email Template Details</h2>
                    <p class="listing-page-subtitle mb-3">
                        View details of template: {{ $email_template->name }}
                    </p>
                </div>

                <!-- Breadcrumb -->
                <x-admin.breadcrumb :list="[
                    ['label' => 'Email Templates Manager', 'url' => route('admin.email-templates.index')],
                    ['label' => 'Email Template Details']
                ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="details-info-group">

                    {{-- Name --}}
                    <div class="details-item">
                        <span class="details-label">Template Name</span>
                        <span class="details-value">
                            <strong>{{ $email_template->name }}</strong>
                        </span>
                    </div>

                    {{-- Subject --}}
                    <div class="details-item">
                        <span class="details-label">Email Subject</span>
                        <span class="details-value">
                            {{ $email_template->subject }}
                        </span>
                    </div>

                    {{-- Slug --}}
                    <div class="details-item">
                        <span class="details-label">Slug</span>
                        <span class="details-value">
                            <code>{{ $email_template->slug }}</code>
                        </span>
                    </div>

                    {{-- Status --}}
                    <div class="details-item">
                        <span class="details-label">Status</span>
                        <span class="details-value">
                            @if ($email_template->status)
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
                            {{ $email_template->created_at->format('M d, Y') }}
                            <small class="text-muted">
                                at {{ $email_template->created_at->format('h:i A') }}
                            </small>
                        </span>
                    </div>

                    {{-- Updated Date --}}
                    <div class="details-item">
                        <span class="details-label">Last Updated</span>
                        <span class="details-value">
                            {{ $email_template->updated_at->format('M d, Y') }}
                            <small class="text-muted">
                                at {{ $email_template->updated_at->format('h:i A') }}
                            </small>
                        </span>
                    </div>

                </div>

                {{-- Email Body --}}
                @if ($email_template->description)
                    <div class="card mb-4">
                        <header class="card-header">
                            <h4 class="card-title">Email Content</h4>
                        </header>
                        <div class="card-body">
                            <div class="border p-3 rounded bg-light">
                                {!! $email_template->description !!}
                            </div>
                        </div>
                    </div>
                @endif

                <div>
                    <a href="{{ route('admin.email-templates.edit', $email_template->id) }}" class="btn btn-primary">
                        <i class="material-icons md-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.email-templates.index') }}" class="btn btn-light">
                        <i class="material-icons md-arrow_back"></i> Back to list
                    </a>
                </div>
            </div>
        </div>

    </section>
@endsection