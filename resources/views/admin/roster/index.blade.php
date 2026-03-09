@extends('admin.layouts.app')
@section('title', 'Roster Management')
@section('content')
    <section class="content-main">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Roster Management</h2>
                    <p class="listing-page-subtitle mb-3">
                        Manage task
                    </p>
                </div>
                <!-- Right Side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Roles Management']]" class="float-end" />
            </div>
        </div>

        <div class="card mb-4 p-4">
            <input type="text" id="weekPicker" class="form-control" placeholder="Select Week">
            <div>
                <div class="d-flex justify-content-between">
                    <button class="roster-btn" id="prevWeek">
                        <i class="ri-arrow-left-box-fill roster-icon" ></i>
                    </button>
                    <button class="roster-btn" id="nextWeek">
                        <i class="ri-arrow-right-box-fill roster-icon"></i>
                    </button>
                </div>
            </div>
            <div id="roster-table-container">
                @include('admin.roster.partials.roster-table')
            </div>
        </div>
    </section>

    <div class="modal fade" id="assignModal">
        <div class="modal-dialog">
            <div class="modal-content">
                <form method="POST" action="{{ route('admin.roster.store') }}" id="shiftForm">
                    @csrf
                    <div class="modal-header">
                        <h5>Assign Shift & Task</h5>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="date" id="date">
                        <div class="mb-3">
                            <label>Shift</label>
                            <select name="shift_id" class="form-control">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label>Task</label>
                            <select name="task_id" class="form-control">
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-success">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
        <script>
            let currentStart = "{{ $dates[0]->format('Y-m-d') }}";
            let currentEnd = "{{ $dates[6]->format('Y-m-d') }}";
            // Add Shift form
            function openModal(userId, date) {
                document.getElementById('user_id').value = userId;
                document.getElementById('date').value = date;
                $('#assignModal').modal('show');
            }
            $("#shiftForm").submit(function(e) {
                e.preventDefault();
                $.ajax({
                    url: "{{ route('admin.roster.store') }}",
                    type: "POST",
                    data: $(this).serialize(),
                    success: function(res) {
                        $("#assignModal").modal("hide");
                        loadRoster(currentStart, currentEnd);
                    }
                });
            });
        </script>

        <script>
            flatpickr("#weekPicker", {
                dateFormat: "Y-m-d",
                defaultDate: currentStart,
                allowInput: false,
                onChange: function(selectedDates, dateStr) {
                    loadRoster(dateStr);
                }
            });
            
            $('#nextWeek').click(function() {
                let start = moment(currentStart)
                    .add(7, 'days')
                    .format('YYYY-MM-DD');
                loadRoster(start);
            });

            $('#prevWeek').click(function() {
                let start = moment(currentStart)
                    .subtract(7, 'days')
                    .format('YYYY-MM-DD');
                loadRoster(start);
            });

            function loadRoster(startDate, endDate) {
                $("#weekPicker").val(startDate);
                currentStart = startDate;
                $('#roster-table-container').html(
                    `<div id="table-loader" style="height: 150px;align-items: center;display: flex;justify-content: center;border: 2px solid gray;" >             <div class="spinner-border text-primary"></div> </div>`
                );

                $.ajax({
                    url: "{{ route('admin.roster') }}",
                    data: {
                        start: startDate
                    },
                    success: function(res) {
                        $('#roster-table-container').html(res);
                    }
                });
            }
        </script>
    @endpush
@endsection
