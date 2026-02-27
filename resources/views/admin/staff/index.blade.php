@extends('admin.layouts.app')

@section('title', 'Staff Manager')

@section('content')
<section class="content-main">
    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Staff Manager</h2>
                <p class="listing-page-subtitle mb-3">Manage administrative staff and their account status.</p>
            </div>

            <!-- Right side: Breadcrumb -->
            <x-admin.breadcrumb :list="[['label' => 'Staff Manager']]" class="float-end" />
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
                            <input type="text" placeholder="Search staff..." class="form-control" id="custom-search">
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
                    <a href="{{ route('admin.staff.create') }}" class="btn btn-primary">
                        <i class="material-icons md-plus"></i> Create Staff
                    </a>
                </div>
            </div>
        </header>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0 listing-table" id="staff-table">
                    <thead>
                        <tr>
                            <th width="70">ID</th>
                            <th width="70">Name</th>
                            <th width="70">Email</th>
                            <th width="70">Phone</th>
                            <th width="70">Status</th>
                            <th width="70" class="text-center">Action</th>
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
    $(document).ready(function() {
        var table = $('#staff-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('admin.staff.index') }}",
                data: function(d) {
                    let status = $('#status-filter').val();
                    if (status !== '') {
                        d.status = status;
                    }
                }
            },
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
                    data: 'email',
                    name: 'email'
                },
                {
                    data: 'phone',
                    name: 'phone'
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
            lengthMenu: [
                [10, 25, 50, 100],
                [10, 25, 50, 100]
            ],
            autoWidth: false,
            dom: 'lrtip',
            language: {
                lengthMenu: 'Show _MENU_ staff',
                info: 'Showing _START_ to _END_ of _TOTAL_ staff',
                infoEmpty: 'No staff found',
                paginate: {
                    previous: 'Prev',
                    next: 'Next'
                }
            }
        });

        $('#custom-search').on('keyup', function() {
            table.search(this.value).draw();
        });

        $('#status-filter').on('change', function() {
            table.draw();
        });

    });
</script>
@endpush