@push('scripts')
    <script>
        $(document).ready(function () {
            // Index page: DataTable
            if ($('#user-table').length) {
                var table = $('#user-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.user.index') }}",
                        data: function (d) {
                            var status = $('#status-filter').val();
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
                    }
                    ],
                    pageLength: 10,
                    lengthMenu: [
                        [10, 25, 50, 100],
                        [10, 25, 50, 100]
                    ],
                    autoWidth: false,
                    dom: 'lrtip',
                    language: {
                        lengthMenu: 'Show _MENU_ users',
                        info: 'Showing _START_ to _END_ of _TOTAL_ users',
                        infoEmpty: 'No users found',
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
            }

            // Create/Edit form: Select2 + Flatpickr
            if ($('#roles').length) {
                $('#roles').select2({
                    placeholder: "Select Roles",
                    allowClear: true,
                    width: '100%'
                });
            }

            if ($('.datepicker').length && typeof flatpickr !== 'undefined') {
                flatpickr(".datepicker", {
                    dateFormat: "Y-m-d",
                    maxDate: "today"
                });
            }
        });
    </script>
@endpush
