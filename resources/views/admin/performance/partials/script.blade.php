@push('scripts')
    <script src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
    <script src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <script>
        $(document).ready(function() {
            let start = moment().subtract(1, 'months');
            let end = moment();

            $('#filter-date-from').val(start.format('YYYY-MM-DD'));
            $('#filter-date-to').val(end.format('YYYY-MM-DD'));
            
            if ($('#performance-table').length) {
                var table = $('#performance-table').DataTable({
                    processing: true,
                    serverSide: true,
                    ajax: {
                        url: "{{ route('admin.performance') }}",
                        data: function(d) {
                            d.start_date = $('#filter-date-from').val();
                            d.end_date = $('#filter-date-to').val();
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
                            data: 'total_tasks',
                            name: 'total_tasks'
                        },
                        {
                            data: 'completed_tasks',
                            name: 'completed_tasks'
                        },                        
                        {
                            data: 'pending_tasks',
                            name: 'pending_tasks'
                        }, 
                         {
                            data: 'running_tasks',
                            name: 'running_tasks'
                        },     
                        {
                            data: 'working_hours',
                            name: 'working_hours'
                        },            
                        {
                            data: 'completion_rate',
                            name: 'completion_rate'
                        }                       
                    ]
                });                

                // Date range picker (Flatpickr)
                if (typeof flatpickr !== 'undefined' && $('#filter-date-range').length) {
                    flatpickr('#filter-date-range', {
                        mode: 'range',
                        dateFormat: 'Y-m-d',
                        allowInput: true,
                        onChange: function(selectedDates) {
                            if(selectedDates.length === 2) {
                                $('#filter-date-from').val(
                                    flatpickr.formatDate(selectedDates[0],'Y-m-d')
                                );

                                $('#filter-date-to').val(
                                    flatpickr.formatDate(selectedDates[1],'Y-m-d')
                                );
                                table.ajax.reload();
                            }
                        }
                    });
                }

                // Filters redraw
                $('#filter-date-from, #filter-date-to').on('change', function() {
                    table.ajax.reload();
                });

                $('#custom-search').on('keyup', function() {
                    table.search(this.value).draw();
                });
            }
        });
    </script>
@endpush
