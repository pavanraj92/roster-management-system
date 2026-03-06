@extends('admin.layouts.app')

@section('title', 'Roster Management')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Roaster Management</h2>
                    <p class="listing-page-subtitle mb-3">
                        Manage task 
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Roles Management']]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 listing-card">         
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 listing-table" id="roles-table">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Role Name</th>
                                <th>Permissions</th>
                                <th width="120" class="text-center">Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </section>
@endsection