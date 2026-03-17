@push('scripts')
<script>
    $(document).ready(function() {
        if ($('#attendance-table').length) {
            var table = $('#attendance-table').DataTable({
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('admin.attendances.index') }}",
                    data: function(d) {
                        d.status = $('#filter-status').val();
                        d.shift_id = $('#filter-shift').val();
                        d.date_from = $('#filter-date-from').val();
                        d.date_to = $('#filter-date-to').val();
                    }
                },
                // ajax: "{{ route('admin.attendances.index') }}",
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'employee',
                        name: 'employee'
                    },
                    {
                        data: 'date',
                        name: 'date'
                    },
                    {
                        data: 'shift',
                        name: 'shift'
                    },
                    {
                        data: 'shift_status',
                        name: 'shift_status',
                        orderable: false,
                        searchable: false
                    },
                    {
                        data: 'clock_in',
                        name: 'clock_in'
                    },
                    {
                        data: 'clock_out',
                        name: 'clock_out'
                    },
                    {
                        data: 'total_hours',
                        name: 'total_hours'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                language: {
                    search: "",
                    searchPlaceholder: "Search attendance...",
                }
            });

            $('#custom-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            // Date range picker (Flatpickr)
            if (typeof flatpickr !== 'undefined' && $('#filter-date-range').length) {
                flatpickr('#filter-date-range', {
                    mode: 'range',
                    dateFormat: 'Y-m-d',
                    allowInput: true,
                    onChange: function(selectedDates) {
                        var from = selectedDates[0] ? flatpickr.formatDate(selectedDates[0], 'Y-m-d') : '';
                        var to = selectedDates[1] ? flatpickr.formatDate(selectedDates[1], 'Y-m-d') : '';

                        $('#filter-date-from').val(from).trigger('change');
                        $('#filter-date-to').val(to).trigger('change');
                    },
                    onValueUpdate: function(selectedDates, dateStr) {
                        if (!dateStr) {
                            $('#filter-date-from').val('').trigger('change');
                            $('#filter-date-to').val('').trigger('change');
                        }
                    }
                });
            }

            // Filters redraw
            $('#filter-status, #filter-shift, #filter-date-from, #filter-date-to').on('change', function() {
                table.ajax.reload();
            });
        }
    });
</script>
@endpush