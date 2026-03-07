@extends('admin.layouts.app')

@section('title', 'View Shift')

@section('content')
    <section class="content-main">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Shift Details</h2>
                    <p class="listing-page-subtitle mb-3">
                        {{ $shift->name }}
                    </p>
                </div>

                <x-admin.breadcrumb :list="[
                    ['label' => 'Shifts Manager', 'url' => route('admin.shifts.index')],
                    ['label' => 'View Shift']
                ]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 details-card">
            <div class="card-body">
                <div class="details-info-group">
                    <div class="details-item">
                        <span class="details-label">Name</span>
                        <span class="details-value"><strong>{{ $shift->name }}</strong></span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Start Time</span>
                        <span class="details-value">{{ \Carbon\Carbon::parse($shift->start_time)->format('h:i A') }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">End Time</span>
                        <span class="details-value">{{ \Carbon\Carbon::parse($shift->end_time)->format('h:i A') }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Color</span>
                        <span class="details-value">
                            @if($shift->color)
                                <span class="badge" style="background-color: {{ $shift->color }}; color: #fff;">{{ $shift->color }}</span>
                            @else
                                —
                            @endif
                        </span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Created At</span>
                        <span class="details-value">{{ $shift->created_at->format('M d, Y h:i A') }}</span>
                    </div>
                    <div class="details-item">
                        <span class="details-label">Updated At</span>
                        <span class="details-value">{{ $shift->updated_at->format('M d, Y h:i A') }}</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('admin.shifts.edit', $shift->id) }}" class="btn btn-primary">
                <i class="material-icons md-edit"></i> Edit
            </a>
            <a href="{{ route('admin.shifts.index') }}" class="btn btn-outline-secondary">Back</a>
        </div>

    </section>
@endsection
