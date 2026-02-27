@extends('admin.layouts.app')

@section('title', 'User Details')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">User Details</h2>
                    <p class="listing-page-subtitle mb-3">View details of user: {{ $user->name }}</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[
            ['label' => 'User Manager', 'url' => route('admin.user.index')],
            ['label' => 'User Details']
        ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="details-info-group">
                    <div class="details-item">
                        <span class="details-label">First Name</span>
                        <span class="details-value"><strong>{{ $user->first_name }}</strong></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Last Name</span>
                        <span class="details-value"><strong>{{ $user->last_name }}</strong></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Email Address</span>
                        <span class="details-value">{{ $user->email }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Phone Number</span>
                        <span class="details-value">{{ $user->phone ?? 'N/A' }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Status</span>
                        <span class="details-value">
                            @if($user->status)
                                <span class="badge bg-success rounded-pill">Active</span>
                            @else
                                <span class="badge bg-secondary rounded-pill">Inactive</span>
                            @endif
                        </span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Joining Date</span>
                        <span class="details-value">
                            @if($user->joining_date)
                                {{ \Carbon\Carbon::parse($user->joining_date)->format('M d, Y') }}
                            @else
                                N/A
                            @endif
                        </span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Member Since</span>
                        <span class="details-value">{{ $user->created_at->format('M d, Y') }} <small class="text-muted">at
                                {{ $user->created_at->format('h:i A') }}</small></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Roles</span>
                        <span class="details-value">
                            @forelse($user->roles as $role)
                                <span class="badge bg-info rounded-pill">{{ ucfirst($role->name) }}</span>
                            @empty
                                N/A
                            @endforelse
                        </span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Last Updated</span>
                        <span class="details-value">{{ $user->updated_at->format('M d, Y') }} <small class="text-muted">at
                                {{ $user->updated_at->format('h:i A') }}</small></span>
                    </div>
                </div>

                <div class="mt-4">
                    <a href="{{ route('admin.user.edit', $user->id) }}" class="btn btn-primary">
                        <i class="material-icons md-edit"></i> Edit
                    </a>
                    <a href="{{ route('admin.user.index') }}" class="btn btn-light">
                        <i class="material-icons md-arrow_back"></i> Back
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection