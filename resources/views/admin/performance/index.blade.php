@extends('admin.layouts.app')

@section('title', 'Performance Report')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Performance Report</h2>
                    <p class="listing-page-subtitle mb-3">
                        Manage performance analytics (Exclude Absent Days).</p>
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
                         <div class="col-md-4 d-flex gap-2">
                        <input type="text" id="filter-date-range" class="form-control"
                            placeholder="Select date range" autocomplete="off">
                        <input type="hidden" id="filter-date-from">
                        <input type="hidden" id="filter-date-to">
                    </div>                    
                    </div>
                    
                </div>
            </header>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 listing-table" id="performance-table">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>User</th>
                                <th>Total Tasks</th>
                                <th>Completed Tasks</th>
                                <th>Pending Tasks</th>
                                <th>Running Tasks</th>
                                <th>Working Hours</th>
                                <th>Task Completion %</th>                                
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection


@include('admin.performance.partials.script')
