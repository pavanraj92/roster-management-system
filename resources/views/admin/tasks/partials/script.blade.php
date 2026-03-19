@push('scripts')
    <script>
        $(document).ready(function () {
            // Index page: DataTable
            if ($('#tasks-table').length) {
                var table = $('#tasks-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: "{{ route('admin.tasks.index') }}",
                    columns: [
                        {
                            data: 'DT_RowIndex',
                            name: 'DT_RowIndex',
                            orderable: false,
                            searchable: false
                        },
                        { data: 'title', name: 'title' },
                        { data: 'description', name: 'description', orderable: false, searchable: false },
                        { data: 'created_by', name: 'created_by', orderable: false, searchable: false },
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
                        searchPlaceholder: "Search tasks...",
                    }
                });

                $('#custom-search').on('keyup', function () {
                    table.search(this.value).draw();
                });
            }

            // Create/Edit form: CKEditor
            if ($('#task_description').length && typeof initAdminCkEditors === 'function') {
                initAdminCkEditors('#task_description');
            }
        });
    </script>
@endpush