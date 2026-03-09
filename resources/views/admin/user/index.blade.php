@extends('admin.layouts.app')

@section('title', 'User Manager')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">User Manager</h2>
                    <p class="listing-page-subtitle mb-3">Manage administrative users and their account status.</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'User Manager']]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 listing-card">
            <header class="card-header">
                <div class="row align-items-center listing-filter-bar">
                    <div class="col-md-9 me-auto">
                        <div class="d-flex flex-wrap align-items-center gap-2">

                            <!-- Search Box (smaller width) -->
                            <div class="input-group" style="flex: 1 1 200px; max-width: 300px;">
                                <span class="input-group-text">
                                    <i class="material-icons md-search" style="font-size: 18px;"></i>
                                </span>
                                <input type="text" placeholder="Search user..." class="form-control" id="custom-search">
                            </div>

                            <!-- Status Filter (wider) -->
                            <div class="select-group" style="flex: 1 1 150px; max-width: 200px;">
                                <select class="form-select" id="status-filter">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Disabled</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3 float-end text-end">
                        <a href="{{ route('admin.user.create') }}" class="btn btn-primary">
                            <i class="material-icons md-plus"></i> Create User
                        </a>
                    </div>
                </div>
            </header>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 listing-table" id="user-table">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>User</th>
                                <th width="140">Phone</th>
                                <th width="110">Status</th>
                                <th width="120" class="text-center">Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection

@include('admin.user.partials.script')