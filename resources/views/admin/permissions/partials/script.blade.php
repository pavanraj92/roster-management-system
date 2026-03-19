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
                        data: 'display_name',
                        name: 'display_name'
                    },
                    {
                        data: 'group_name',
                        name: 'group_name'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                    ],
                    dom: 'lrtip',
                    language: {
                        search: "",
                        searchPlaceholder: "Search permission...",
                    }
                });

                $('#custom-search').on('input keyup', function () {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush