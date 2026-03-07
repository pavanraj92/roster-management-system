@extends('admin.layouts.app')

@section('title', 'Shifts')

@section('content')
    <section class="content-main">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Shifts Manager</h2>
                    <p class="listing-page-subtitle mb-3">
                        Manage shifts (e.g. Morning, Evening, Night).
                    </p>
                </div>

                <x-admin.breadcrumb :list="[['label' => 'Shifts Manager']]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 listing-card">

            <header class="card-header">
                <div class="row align-items-center listing-filter-bar">
                    <div class="col-md-9 me-auto">
                        <div class="d-flex flex-wrap align-items-center gap-2">
                            <div class="input-group" style="flex: 1 1 200px; max-width: 300px;">
                                <span class="input-group-text">
                                    <i class="material-icons md-search" style="font-size: 18px;"></i>
                                </span>
                                <input type="text" placeholder="Search shift name..." class="form-control"
                                    id="custom-search">
                            </div>
                        </div>
                    </div>

                    <div class="col-md-3 float-end text-end">
                        <a href="{{ route('admin.shifts.create') }}" class="btn btn-primary">
                            <i class="material-icons md-plus"></i> Create Shift
                        </a>
                    </div>
                </div>
            </header>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 listing-table" id="shifts-table">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Name</th>
                                <th>Start Time</th>
                                <th>End Time</th>
                                <th>Color</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('admin.shifts.partials.script')
