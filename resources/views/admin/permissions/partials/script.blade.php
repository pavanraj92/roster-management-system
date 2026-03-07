@push('scripts')
    <script>
        $(document).ready(function () {
            if ($('#permissions-table').length) {
                var table = $('#permissions-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.permissions.index') }}",
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
                        data: 'guard_name',
                        name: 'guard_name'
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
                        searchPlaceholder: "Search permission...",
                    }
                });

                $('#custom-search').on('keyup', function () {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
