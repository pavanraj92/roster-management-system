@extends('admin.layouts.app')

@section('title', 'Create Permission')

@section('content')
<section class="content-main admin-form-page">

    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Create New Permission</h2>
                <p class="listing-page-subtitle mb-3">
                    Add a new system permission
                </p>
            </div>

            <!-- Right side: Breadcrumb -->
            <x-admin.breadcrumb :list="[
            ['label' => 'Permissions Manager', 'url' => route('admin.permissions.index')],
            ['label' => 'Create Permission']
        ]" class="float-end" />
        </div>
    </div>

    <form action="{{ route('admin.permissions.store') }}" method="POST">
        @csrf

        <div class="row g-4 page-form-grid">
            <div class="col-lg-12">
                <div class="card mb-4 admin-form-main-card">
                    <div class="card-header">
                        <h4>Permission Information</h4>
                    </div>

                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Permission Name</label>
                            <input type="text" class="form-control @error('name') is-invalid @enderror"
                                name="name" value="{{ old('name') }}" placeholder="e.g., view_users" required>
                            <small class="form-text text-muted d-block mt-2">Use lowercase with underscores for permission names</small>
                            @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Description <span class="text-muted">(Optional)</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror"
                                name="description" rows="3" placeholder="Enter permission description...">{{ old('description') }}</textarea>
                            @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                {{-- right column left intentionally blank for consistent layout --}}
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">Create Permission</button>
                    <a href="{{ route('admin.permissions.index') }}" class="btn btn-outline-secondary">Cancel</a>
                </div>
            </div>
        </div>

    </form>

</section>
@endsection