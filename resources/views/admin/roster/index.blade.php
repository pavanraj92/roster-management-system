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
    <div class="modal fade" id="shiftDetailModal" tabindex="-1" aria-labelledby="shiftDetailModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md">
            <div class="modal-content roster-modal">
                <div class="modal-header roster-modal__header">
                    <h5 class="modal-title" id="shiftDetailModalLabel">Shift & Task Details</h5>

                    {{-- Check In/Out Forms  --}}
                    <form method="POST" action="{{ route('admin.roster.clock.in') }}" id="clock-in-form">
                        @csrf
                        <input type="hidden" id="clock-in-roster-id" name="roster_id">
                        <button class="btn btn-success" type="submit">
                            Clock In
                        </button>
                    </form>

                    <form method="POST" action="{{ route('admin.roster.clock.out') }}" id="clock-out-form" class="d-none">
                        @csrf
                        <input type="hidden" id="clock-out-attendance-id" name="attendance_id">
                        <button class="btn btn-danger ">
                            Clock Out
                        </button>
                    </form>
                </div>
                <div class="modal-body roster-modal__body">
                    {{-- View mode --}}
                    <div id="shift-detail-view">
                        <div class="mb-1">
                            <strong>Shift:</strong>
                            <span id="detail-shift-name"></span>
                        </div>
                        <div class="mb-1">
                            <strong>Time:</strong>
                            <span id="detail-shift-time"></span>
                        </div>
                        <div class="mb-1">
                            <strong>Task:</strong>
                            <span id="detail-task-title"></span>
                        </div>
                        <div class="mb-0">
                            <strong>Description:</strong>
                            <p id="detail-task-description" class="mb-0 text-muted"></p>
                        </div>

                        <div id="task-log-status-section" class="mt-3 pt-3 border-top d-none">
                            <h6 class="mb-2">Task Progress</h6>
                            <div class="d-flex gap-3 mb-2 small">
                                <span>Pending: <strong id="task-log-count-pending">0</strong></span>
                                <span>Running: <strong id="task-log-count-running">0</strong></span>
                                <span>Complete: <strong id="task-log-count-complete">0</strong></span>
                            </div>
                            <div id="task-log-status-list" class="small text-muted">No task progress yet.</div>
                        </div>

                        {{-- Task Log Update — shown via JS only for running shifts (non-admin, today) --}}
                        <div id="task-log-update-section" class="d-none mt-3 pt-3 border-top">
                            <h6 class="mb-2">Update Task Status</h6>
                            <div class="mb-2">
                                <label class="form-label">Pending Task</label>
                                <select id="task-log-task-select" class="form-control form-control-sm">
                                    <option value="">Select a task</option>
                                </select>
                            </div>
                            <div class="mb-2">
                                <label class="form-label">New Status</label>
                                <select id="task-log-status-select" class="form-control form-control-sm">
                                    <option value="pending">Pending</option>
                                    <option value="running">Running</option>
                                    <option value="complete">Complete</option>
                                </select>
                            </div>
                            <button type="button" class="btn btn-primary btn-sm" id="task-log-update-btn">
                                Update
                            </button>
                        </div>
                    </div>

                    {{-- Edit Mode --}}
                    @can('edit_assigned_roster')
                        <div id="shift-edit-form-container" class="d-none">
                            <form id="shiftEditForm">
                                <input type="hidden" id="edit-roster-id">
                                <input type="hidden" id="edit-user">
                                <div class="mb-1">
                                    <label class="form-label">Date</label>
                                    <input type="text" id="edit-date" class="form-control">
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Shift</label>
                                    <select id="edit-shift" class="form-control">
                                        @foreach ($shifts as $shift)
                                            <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-1">
                                    <label class="form-label">Task</label>
                                    <select id="edit-task" class="form-control select2 task-selection" name="task_ids[]"
                                        multiple="multiple">
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
                        <button type="button" class="btn btn-primary me-2" id="shift-detail-edit-btn">
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
                        <div class="mb-1">
                            <label class="form-label">Shift</label>
                            <select name="shift_id" class="form-control">
                                @foreach ($shifts as $shift)
                                    <option value="{{ $shift->id }}">{{ $shift->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Task</label>
                            <select id="assign-task" name="task_ids[]" class="form-control select2 task-selection"
                                multiple="multiple">
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
        <script>
            window.rosterPageConfig = {
                currentStart: "{{ $dates[0]->format('Y-m-d') }}",
                currentEnd: "{{ $dates[6]->format('Y-m-d') }}",
                isAdminUser: @json(auth()->user()->hasRole(['admin', 'Admin'])),
                csrfToken: "{{ csrf_token() }}",
                rosterUrl: "{{ route('admin.roster') }}",
                storeUrl: "{{ route('admin.roster.store') }}",
                updateUrlTemplate: "{{ route('admin.roster.update', ['roster' => 'ROSTER_ID_PLACEHOLDER']) }}",
                clockInUrl: "{{ route('admin.roster.clock.in') }}",
                clockOutUrl: "{{ route('admin.roster.clock.out') }}",
                taskLogsUrlTemplate: "{{ route('admin.roster.task-logs', ['roster' => 'ROSTER_ID_PLACEHOLDER']) }}",
                taskLogUpdateUrlTemplate: "{{ route('admin.roster.task-log.update', ['taskLog' => 'TASK_LOG_ID_PLACEHOLDER']) }}"
            };
        </script>
        <script src="{{ asset('backend/js/pages/roster.js') }}"></script>
    @endpush
@endsection
