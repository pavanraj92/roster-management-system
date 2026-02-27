@extends('admin.layouts.app')

@section('title', 'Banners')

@section('content')
    <section class="content-main">
        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Banners</h2>
                    <p class="listing-page-subtitle mb-3">Manage home page banners and their status.</p>
                </div>

                <!-- Right side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Banners']]" class="float-end" />
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
                                <input type="text" placeholder="Search banner title..." class="form-control"
                                    id="custom-search">
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
                        <a href="{{ route('admin.settings.banners.create') }}" class="btn btn-primary">
                            <i class="material-icons md-plus"></i> Create Banner
                        </a>
                    </div>
                </div>
            </header>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0 listing-table" id="banner-table">
                        <thead>
                            <tr>
                                <th width="70">ID</th>
                                <th width="110">Image</th>
                                <th width="180">Title</th>
                                <th width="200">Type</th>
                                <th width="70">Status</th>
                                <th width="120" class="text-end">Action</th>
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
            var table = $('#banner-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.settings.banners.index') }}",
                    data: function (d) {
                        d.status = $('#status-filter').val();
                    }
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'image', name: 'image', orderable: false, searchable: false },
                    { data: 'title', name: 'title' },
                    { data: 'is_sub_banner', name: 'is_sub_banner', orderable: false, searchable: false },
                    { data: 'status', name: 'status', orderable: false, searchable: false },
                    { data: 'action', name: 'action', orderable: false, searchable: false },
                ],
                pageLength: 10,
                lengthMenu: [[10, 25, 50, 100], [10, 25, 50, 100]],
                autoWidth: false,
                dom: 'lrtip',
                language: {
                    lengthMenu: 'Show _MENU_ banners',
                    info: 'Showing _START_ to _END_ of _TOTAL_ banners',
                    infoEmpty: 'No banners found',
                    paginate: {
                        previous: 'Prev',
                        next: 'Next'
                    }
                }
            });

            $('#custom-search').on('keyup', function () {
                table.search(this.value).draw();
            });

            $('#status-filter').on('change', function () {
                table.draw();
            });

        });
    </script>
@endpush