@extends('admin.layouts.app')

@section('title', 'Staff Details')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Staff Details</h2>
                    <p class="listing-page-subtitle mb-3">Staff profile overview for {{ $staff->name }}</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'Staff Manager', 'url' => route('admin.staff.index')],
            ['label' => 'Staff Details']
        ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="row align-items-start g-4">
                    <!-- Profile Avatar Column -->
                    <div class="col-md-3 text-center border-end">
                        <div class="mb-3">
                            <a href="{{ $staff->avatar_url }}" class="image-popup">
                                <img src="{{ $staff->avatar_url }}" alt="{{ $staff->name }}"
                                    class="rounded-circle shadow-sm border p-1"
                                    style="width: 150px; height: 150px; object-fit: cover; background: #fff;">
                            </a>
                        </div>
                        <h4 class="mb-1">{{ $staff->name }}</h4>
                        <p class="text-muted">{{ $staff->designation ?? 'Staff' }}</p>

                        @if($staff->status)
                            <span class="badge bg-success rounded-pill px-3">Active Account</span>
                        @else
                            <span class="badge bg-secondary rounded-pill px-3">Inactive</span>
                        @endif
                    </div>

                    <!-- Information Column -->
                    <div class="col-md-9">
                        <h5 class="mb-4 border-bottom pb-2">Staff Information</h5>
                        <div class="details-info-group">
                            <div class="details-item">
                                <span class="details-label">First Name</span>
                                <span class="details-value"><strong>{{ $staff->first_name }}</strong></span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Last Name</span>
                                <span class="details-value"><strong>{{ $staff->last_name }}</strong></span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Email Address</span>
                                <span class="details-value">{{ $staff->email }}</span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Phone Number</span>
                                <span class="details-value">{{ $staff->phone ?? 'N/A' }}</span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Joining Date</span>
                                <span class="details-value">
                                    @if($staff->joining_date)
                                        {{ \Carbon\Carbon::parse($staff->joining_date)->format('M d, Y') }}
                                    @else
                                        N/A
                                    @endif
                                </span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Designation</span>
                                <span class="details-value">{{ $staff->designation ?? 'N/A' }}</span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Member Since</span>
                                <span class="details-value">{{ $staff->created_at->format('M d, Y') }} <small
                                        class="text-muted">at {{ $staff->created_at->format('h:i A') }}</small></span>
                            </div>
                            <div class="details-item">
                                <span class="details-label">Last Updated</span>
                                <span class="details-value">{{ $staff->updated_at->format('M d, Y') }} <small
                                        class="text-muted">at {{ $staff->updated_at->format('h:i A') }}</small></span>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-top d-flex gap-2">
                    <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-primary">
                        <i class="material-icons md-edit"></i> Edit Profile
                    </a>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-light">
                        <i class="material-icons md-arrow_back"></i> Back to List
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection