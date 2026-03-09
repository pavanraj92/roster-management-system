@push('scripts')
    <script>
        $(document).ready(function () {
            if ($('#shifts-table').length) {
                var table = $('#shifts-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.shifts.index') }}",
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        { data: 'name', name: 'name' },
                        { data: 'start_time', name: 'start_time', orderable: true, searchable: false },
                        { data: 'end_time', name: 'end_time', orderable: true, searchable: false },
                        { data: 'color', name: 'color', orderable: false, searchable: false },
                        {
                            data: 'action',
                            name: 'action',
                            orderable: false,
                            searchable: false
                        }
                    ],
                    language: {
                        search: "",
                        searchPlaceholder: "Search shift...",
                    }
                });

                $('#custom-search').on('keyup', function () {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
