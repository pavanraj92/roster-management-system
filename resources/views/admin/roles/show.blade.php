@extends('admin.layouts.app')

@section('title', 'View Role')

@section('content')
    <section class="content-main">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Role Details</h2>
                    <p class="listing-page-subtitle mb-3">
                        {{ ucfirst($role->name) }}
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Roles Manager', 'url' => route('admin.roles.index')],
            ['label' => 'View Role']
        ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="details-info-group">
                    <div class="details-item">
                        <span class="details-label">Role Name</span>
                        <span class="details-value"><strong>{{ ucfirst($role->name) }}</strong></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Guard Name</span>
                        <span class="details-value">{{ $role->guard_name }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Created At</span>
                        <span class="details-value">{{ $role->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Updated At</span>
                        <span class="details-value">{{ $role->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>

                <div class="mt-4">
                    <h5 class="card-title">Assigned Permissions ({{ $permissions->count() }})</h5>
                    @if($permissions->count() > 0)
                        <div class="row">
                            @foreach($permissions as $permission)
                                <div class="col-md-4 mb-3">
                                    <span class="badge bg-primary p-2">
                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                    </span>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-muted">No permissions assigned to this role.</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.roles.edit', $role->id) }}" class="btn btn-primary">
                <i class="material-icons md-edit"></i> Edit
            </a>
            <a href="{{ route('admin.roles.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

    </section>
@endsection
