@extends('admin.layouts.app')

@section('title', 'View Permission')

@section('content')
    <section class="content-main">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Permission Details</h2>
                    <p class="listing-page-subtitle mb-3">
                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Permissions Manager', 'url' => route('admin.permissions.index')],
            ['label' => 'View Permission']
        ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="details-info-group">
                    <div class="details-item">
                        <span class="details-label">Permission Name</span>
                        <span class="details-value"><strong>{{ $permission->name }}</strong></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Guard Name</span>
                        <span class="details-value">{{ $permission->guard_name }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Description</span>
                        <span class="details-value">{{ $permission->description ?? 'N/A' }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Created At</span>
                        <span class="details-value">{{ $permission->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.permissions.edit', $permission->id) }}" class="btn btn-primary">
                <i class="material-icons md-edit"></i> Edit
            </a>
            <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

    </section>
@endsection
