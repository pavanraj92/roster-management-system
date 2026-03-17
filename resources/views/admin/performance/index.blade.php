@extends('admin.layouts.app')

@section('title', 'Performance Report')

@section('content')
<section class="content-main">

    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Performance Report</h2>
                <p class="listing-page-subtitle mb-3">
                    Manage performance analytics (e.g. Employee Performance).</p>
            </div>

            <x-admin.breadcrumb :list="[['label' => 'Performance Report']]" class="float-end" />
        </div>
    </div>

    <div class="card mb-4 listing-card">
        <header class="card-header">
            <div class="row align-items-center listing-filter-bar">
                <!-- <div class="col-md-9 me-auto"> -->
                <div class="d-flex flex-wrap align-items-center gap-2">
                    <div class="col-md-2">
                        <input type="text" placeholder="Search performance..." class="form-control"
                            id="custom-search">
                    </div>

                    <!-- Status Filter -->
                    <div class="col-md-2">
                        <select id="filter-status" class="form-select">
                            <option value="">All Status</option>
                            <option value="present">Present</option>
                            <option value="late">Late</option>
                            <option value="absent">Absent</option>
                        </select>
                    </div>

                    <!-- Shift Filter -->
                    <div class="col-md-2">
                        <select id="filter-shift" class="form-select">
                            <option value="">All Shifts</option>
                            @foreach($shifts as $shift)
                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Date Range Filter -->
                    <div class="col-md-4 d-flex gap-2">
                        <input type="text" id="filter-date-range" class="form-control"
                            placeholder="Select date range" autocomplete="off">
                        <input type="hidden" id="filter-date-from">
                        <input type="hidden" id="filter-date-to">
                    </div>
                </div>
                <!-- </div> -->

                {{-- <div class="col-md-3 float-end text-end">
                    <a href="{{ route('admin.attendances.create') }}" class="btn btn-primary">
                <i class="material-icons md-plus"></i> Create Attendance
                </a>
            </div> --}}
    </div>
    </header>

    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0 listing-table" id="attendance-table">
                <thead>
                    <tr>
                        <th width="60">#</th>
                        <th>Employee</th>
                        <th>Date</th>
                        <th>Shift</th>
                        <th>Clock In</th>
                        <th>Clock Out</th>
                        <th>Total Hours</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
    </div>
</section>
@endsection


@include('admin.attendance.partials.script')