@extends('admin.layouts.app')

@section('title', 'Staff Details')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Staff Details</h2>
                    <p class="listing-page-subtitle mb-3">View details of staff member: {{ $staff->name }}</p>
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
                        <span class="details-label">Status</span>
                        <span class="details-value">
                            @if($staff->status)
                                <span class="badge bg-success rounded-pill">Active</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Inactive</span>
                            @endif
                        </span>
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
                        <span class="details-label">Member Since</span>
                        <span class="details-value">{{ $staff->created_at->format('M d, Y') }} <small class="text-muted">at
                                {{ $staff->created_at->format('h:i A') }}</small></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Last Updated</span>
                        <span class="details-value">{{ $staff->updated_at->format('M d, Y') }} <small class="text-muted">at
                                {{ $staff->updated_at->format('h:i A') }}</small></span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.staff.edit', $staff->id) }}" class="btn btn-primary">
                        <i class="material-icons md-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.staff.index') }}" class="btn btn-light">
                        <i class="material-icons md-arrow_back"></i> Back to list
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection