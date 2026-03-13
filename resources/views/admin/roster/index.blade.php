@extends('admin.layouts.app')
@section('title', 'Roster Management')
@section('content')
    <section class="content-main roster-page">

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

        <div class="card mb-4 roster-card">
            <div class="roster-toolbar">
                <div class="roster-toolbar__left">
                    <label for="weekPicker" class="roster-toolbar__label">Week starting</label>
                    <div class="roster-week-input">
                        <span class="roster-week-input__icon">
                            <i class="ri-calendar-line"></i>
                        </span>
                        <input type="text" id="weekPicker" class="form-control" placeholder="Select week">
                    </div>
                </div>
                <div class="roster-toolbar__right">
                    <button type="button" class="btn btn-light btn-icon roster-btn" id="prevWeek">
                        <i class="ri-arrow-left-s-line"></i>
                    </button>
                    <button type="button" class="btn btn-light btn-icon roster-btn" id="nextWeek">
                        <i class="ri-arrow-right-s-line"></i>
                    </button>
                </div>
            </div>

            <div class="roster-table-wrapper" id="roster-table-container">
                @include('admin.roster.partials.roster-table')
            </div>
        </div>
    </section>

    {{-- Modal: Shift & Task Details --}}
    <div class="modal fade" id="shiftDetailModal" tabindex="-1" aria-labelledby="shiftDetailModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content roster-modal">
                <div class="modal-header roster-modal__header">
                    <h5 class="modal-title" id="shiftDetailModalLabel">Shift & Task Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body roster-modal__body">
                    {{-- View mode --}}
                    <div id="shift-detail-view">
                        <div class="mb-3">
                            <strong>Shift:</strong>
                            <span id="detail-shift-name"></span>
                        </div>
                        <div class="mb-3">
                            <strong>Time:</strong>
                            <span id="detail-shift-time"></span>
                        </div>
                        <div class="mb-3">
                            <strong>Task:</strong>
                            <span id="detail-task-title"></span>
                        </div>
                        <div class="mb-0">
                            <strong>Description:</strong>
                            <p id="detail-task-description" class="mb-0 text-muted"></p>
                        </div>
                    </div>

                    {{-- Edit mode --}}
                    @can('edit_assigned_roster')
                        <div id="shift-edit-form-container" class="d-none">
                            <form id="shiftEditForm">
                                <input type="hidden" id="edit-roster-id">
                                <input type="hidden" id="edit-user" >                             
                                <div class="mb-3">
                                    <label class="form-label">Date</label>
                                    <input type="text" id="edit-date" class="form-control">
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Shift</label>
                                    <select id="edit-shift" class="form-control">
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Task</label>
                                    <select id="edit-task" class="form-control select2 task-selection" name="task_ids[]" multiple="multiple">
                                        @foreach ($tasks as $task)
                                            <option value="{{ $task->id }}">{{ $task->title }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </form>
                        </div>
                    @endcan
                </div>
                <div class="modal-footer roster-modal__footer">
                    @can('edit_assigned_roster')                    
                        <button type="button" class="btn btn-primary me-2 d-none" id="shift-detail-edit-btn">
                            Edit
                        </button>
                        <button type="button" class="btn btn-primary me-2 d-none" id="save-shift-edit-btn">
                            Save changes
                        </button>
                    @endcan
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="assignModal">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content roster-modal">
                <form method="POST" action="{{ route('admin.roster.store') }}" id="shiftForm">
                    @csrf
                    <div class="modal-header roster-modal__header">
                        <h5 class="modal-title">Assign Shift & Task</h5>
                    </div>

                    <div class="modal-body roster-modal__body">
                        <input type="hidden" name="user_id" id="user_id">
                        <input type="hidden" name="date" id="date">
                        <div class="mb-3">
                            <label class="form-label">Shift</label>
                            <select name="shift_id" class="form-control">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        

                        <div class="mb-3">
                            <label class="form-label">Task</label>
                            <select id="assign-task" name="task_ids[]" class="form-control select2 task-selection" multiple="multiple">
                                @foreach ($tasks as $task)
                                    <option value="{{ $task->id }}">{{ $task->title }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer roster-modal__footer">
                        <button type="button" class="btn btn-outline-secondary me-2" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button class="btn btn-primary">
                            Save assignment
                        </button>
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

            function initTaskSelect2() {
                $('.task-selection').each(function() {
                    if ($(this).hasClass('select2-hidden-accessible')) {
                        return;
                    }

                    $(this).select2({
                        placeholder: 'Select tasks',
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $(this).closest('.modal')
                    });
                });
            }

            initTaskSelect2();

            // Add Shift form
            function openModal(userId, date) {
                document.getElementById('user_id').value = userId;
                document.getElementById('date').value = date;
                $('#assign-task').val(null).trigger('change');
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
                        $('#shiftForm')[0].reset();
                        $('#assign-task').val(null).trigger('change');
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
                        // re-bind click handlers after table reload
                        bindShiftDetailClicks();
                    }
                });
            }

            // Shift detail modal: click handler
            function bindShiftDetailClicks() {
                $(document).off('click', '.roster-shift-detail-trigger');
                $(document).on('click', '.roster-shift-detail-trigger', function () {
                    const shiftName = $(this).data('shift-name');
                    const shiftStart = $(this).data('shift-start');
                    const shiftEnd = $(this).data('shift-end');
                    const taskTitle = $(this).data('task-title');
                    const taskDescription = $(this).data('task-description') || '';
                    const rosterId = $(this).data('roster-id');
                    const userId = $(this).data('user-id');
                    const date = $(this).data('date');
                    const shiftId = $(this).data('shift-id');
                    const taskId = $(this).data('task-id');
                    const taskIdsRaw = ($(this).data('task-ids') || '').toString();
                    const taskIds = taskIdsRaw
                        .split(',')
                        .map(id => id.trim())
                        .filter(Boolean);
                        let shiftDate = new Date(date);
                        let today = new Date();

                        today.setHours(0,0,0,0);
                        shiftDate.setHours(0,0,0,0);

                        if (shiftDate >= today) {
                            $('#shift-detail-edit-btn').removeClass('d-none');
                            
                        }
                        else{
                             $('#shift-detail-edit-btn').addClass('d-none');
                            }
                            $('#save-shift-edit-btn').addClass('d-none');
                    // populate view mode
                    $('#detail-shift-name').text(shiftName);
                    $('#detail-shift-time').text(shiftStart + ' - ' + shiftEnd);
                    $('#detail-task-title').text(taskTitle);
                    $('#detail-task-description').text(taskDescription || 'No description available.');

                    // reset modal to view mode
                    $('#shift-detail-view').removeClass('d-none');
                    $('#shift-edit-form-container').addClass('d-none');
                    $('#shiftDetailModalLabel').text('Shift & Task Details');
                  
                    

                    // populate edit form (admin only)
                    $('#edit-roster-id').val(rosterId);
                    $('#edit-user').val(userId);
                    $('#edit-date').val(date);
                    $('#edit-shift').val(shiftId);
                    $('#edit-task').val(taskIds.length ? taskIds : [taskId]).trigger('change');

                    $('#shiftDetailModal').modal('show');
                });
            }

            // initial bind
            bindShiftDetailClicks();

            // Edit button: toggle to edit mode
            $('#shift-detail-edit-btn').on('click', function () {
                $('#shift-detail-view').addClass('d-none');
                $('#shift-edit-form-container').removeClass('d-none');
                $('#shiftDetailModalLabel').text('Edit Shift & Task Assignment');
                $('#shift-detail-edit-btn').addClass('d-none');
                $('#save-shift-edit-btn').removeClass('d-none');

                // init date picker for edit date (if not already)
                if (typeof flatpickr !== 'undefined') {
                    if (!document.getElementById('edit-date').dataset.flatpickrInitialized) {
                        flatpickr('#edit-date', {
                            dateFormat: 'Y-m-d',
                        });
                        document.getElementById('edit-date').dataset.flatpickrInitialized = '1';
                    }
                }
            });

            // Save edited shift/task assignment
            $('#save-shift-edit-btn').on('click', function () {
                const rosterId = $('#edit-roster-id').val();
                const payload = {
                    _token: '{{ csrf_token() }}',
                    user_id: $('#edit-user').val(),
                    date: $('#edit-date').val(),
                    shift_id: $('#edit-shift').val(),
                    task_ids: $('#edit-task').val(),
                };

                // Build update URL from named route, replacing placeholder ID
                let updateUrlTemplate = "{{ route('admin.roster.update', ['roster' => 'ROSTER_ID_PLACEHOLDER']) }}";
                let updateUrl = updateUrlTemplate.replace('ROSTER_ID_PLACEHOLDER', rosterId);

                $.ajax({
                    url: updateUrl,
                    type: 'PUT',
                    data: payload,
                    success: function (res) {
                        $('#shiftDetailModal').modal('hide');
                        loadRoster(currentStart, currentEnd);
                    }
                });
            });
        </script>
    @endpush
@endsection
