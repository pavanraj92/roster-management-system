@extends('admin.layouts.app')

@section('title', 'Email Templates Manager')

@section('content')
    <section class="content-main">

        @if (session('success'))
            @include('admin.layouts.flash_message')
        @endif

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Email Templates Manager</h2>
                    <p class="listing-page-subtitle mb-3">
                        Manage email templates, subjects and status.
                    </p>
                </div>

                <!-- Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Email Templates Manager']]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 listing-card">

            <header class="card-header">
                <div class="row align-items-center listing-filter-bar">

                    <div class="col-md-9 me-auto">
                        <div class="d-flex flex-wrap align-items-center gap-2">

                            <!-- Search -->
                            <div class="input-group" style="flex: 1 1 200px; max-width: 300px;">
                                <span class="input-group-text">
                                    <i class="material-icons md-search" style="font-size: 18px;"></i>
                                </span>
                                <input type="text" placeholder="Search template name..." class="form-control"
                                    id="custom-search">
                            </div>

                            <!-- Status Filter -->
                            <div class="select-group" style="flex: 1 1 150px; max-width: 200px;">
                                <select class="form-select" id="status-filter">
                                    <option value="">All Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>

                        </div>
                    </div>

                    <div class="col-md-3 float-end text-end">
                        <a href="{{ route('admin.email-templates.create') }}" class="btn btn-primary">
                            <i class="material-icons md-plus"></i> Create Template
                        </a>
                    </div>
                </div>
            </header>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 listing-table" id="email-templates-table">
                        <thead>
                            <tr>
                                <th width="60">#</th>
                                <th>Name</th>
                                <th>Subject</th>
                                <th width="90">Status</th>
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

            var table = $('#email-templates-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.email-templates.index') }}",
                    data: function (d) {
                        d.status = $('#status-filter').val();
                    }
                },
                columns: [
                    {
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
                        data: 'subject',
                        name: 'subject'
                    },
                    {
                        data: 'status',
                        name: 'status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                pageLength: 10,
                autoWidth: false,
                dom: 'lrtip',
                language: {
                    lengthMenu: 'Show _MENU_ templates',
                    info: 'Showing _START_ to _END_ of _TOTAL_ templates',
                    infoEmpty: 'No templates found',
                    paginate: {
                        previous: 'Prev',
                        next: 'Next'
                    }
                }
            });

            // Search
            $('#custom-search').on('keyup', function () {
                table.search(this.value).draw();
            });

            // Status filter
            $('#status-filter').on('change', function () {
                table.draw();
            });

        });
    </script>
@endpush