@push('scripts')
    <script>
        $(document).ready(function () {
            if ($('#roles-table').length) {
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

                $('#custom-search').on('keyup', function () {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
