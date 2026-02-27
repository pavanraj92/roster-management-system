@extends('admin.layouts.app')

@section('title', 'Roles')

@section('content')
    <section class="content-main">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Roles Manager</h2>
                    <p class="listing-page-subtitle mb-3">
                        Manage admin roles and their permissions.
                    </p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Roles Manager']]" class="float-end" />
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
                                <input type="text" placeholder="Search role name..." class="form-control"
                                    id="custom-search">
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3 float-end text-end">
                        <a href="{{ route('admin.roles.create') }}" class="btn btn-primary">
                            <i class="material-icons md-plus"></i> Create Role
                        </a>
                    </div>
                </div>
            </header>

            <div class="card-body">
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

@push('scripts')
    <script>
        $(document).ready(function () {

            var table = $('#roles-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('admin.roles.index') }}",
                columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'name',
                    name: 'name'
                },
                {
                    data: 'permissions_count',
                    name: 'permissions_count',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search role...",
                }
            });

            // Custom Search Functionality
            $('#custom-search').on('keyup', function () {
                table.search(this.value).draw();
            });

        });
    </script>
@endpush
