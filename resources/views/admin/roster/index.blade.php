@extends('admin.layouts.app')
@section('title', 'Roster Management')

@push('styles')
    <style>
        #shiftDetailModal .modal-content {
            border-radius: 14px;
            border: 1px solid #e9eef5;
            box-shadow: 0 12px 30px rgba(24, 39, 75, 0.12);
        }

        .roster-detail-card {
            background: linear-gradient(180deg, #ffffff 0%, #f9fbfd 100%);
            border: 1px solid #e7edf5;
            border-radius: 12px;
            padding: 14px;
        }

        .roster-card-title {
            font-size: 14px;
            font-weight: 700;
            color: #334155;
            margin-bottom: 10px;
        }

        .roster-detail-row {
            display: grid;
            grid-template-columns: 92px 1fr;
            gap: 8px;
            margin-bottom: 8px;
        }

        .roster-detail-label {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.2px;
            color: #64748b;
            text-transform: uppercase;
        }

        .roster-detail-value {
            font-size: 14px;
            color: #1f2937;
            font-weight: 600;
        }

        .roster-detail-description {
            font-size: 13px;
            line-height: 1.45;
        }

        .roster-progress-counts {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .roster-pill {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 5px 10px;
            border-radius: 999px;
            font-size: 12px;
            border: 1px solid transparent;
            font-weight: 600;
        }

        .roster-pill--pending {
            background: #fff9eb;
            border-color: #fde7b0;
            color: #8a5a00;
        }

        .roster-pill--running {
            background: #eaf4ff;
            border-color: #cfe3ff;
            color: #0d4ea6;
        }

        .roster-pill--complete {
            background: #ecfdf3;
            border-color: #bfeecf;
            color: #166534;
        }

        .roster-progress-item {
            border: 1px solid #e6edf4;
            border-radius: 10px;
            background: #fff;
            padding: 8px 10px;
            margin-bottom: 8px;
        }

        .roster-progress-item__title {
            font-size: 13px;
            font-weight: 700;
            color: #334155;
        }

        .roster-progress-item__meta {
            font-size: 12px;
            color: #64748b;
            margin-top: 4px;
        }

        .roster-status-chip {
            font-size: 11px;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 999px;
            text-transform: capitalize;
        }

        .roster-status-chip--pending {
            background: #fff9eb;
            color: #8a5a00;
        }

        .roster-status-chip--running {
            background: #eaf4ff;
            color: #0d4ea6;
        }

        .roster-status-chip--complete {
            background: #ecfdf3;
            color: #166534;
        }
    </style>
@endpush
@section('content')
    <section class="content-main roster-page">

        <div class="row">
            <div class="clearfix">
                <div class="float-start">
                    <h2 class="content-title card-title mb-0">Roster Management</h2>
                    <p class="listing-page-subtitle mb-3">
                        Manage task assignments, shift schedules, and attendance for your team. View and edit roster details, track task progress, and ensure smooth operations all in one place.
                    </p>
                </div>
                <!-- Right Side: Breadcrumb -->
                <x-admin.breadcrumb :list="[['label' => 'Roster Management']]" class="float-end" />
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
                        <div class="roster-detail-card mb-3">
                            <div class="roster-detail-row">
                                <span class="roster-detail-label">Shift</span>
                                <span id="detail-shift-name" class="roster-detail-value"></span>
                            </div>
                            <div class="roster-detail-row">
                                <span class="roster-detail-label">Time</span>
                                <span id="detail-shift-time" class="roster-detail-value"></span>
                            </div>
                            <div class="roster-detail-row">
                                <span class="roster-detail-label">Task</span>
                                <span id="detail-task-title" class="roster-detail-value"></span>
                            </div>
                            <div class="roster-detail-row mb-0">
                                <span class="roster-detail-label">Description</span>
                                <p id="detail-task-description" class="mb-0 text-muted roster-detail-description"></p>
                            </div>
                        </div>

                        <div id="task-log-status-section" class="roster-detail-card d-none mb-3">
                            <h6 class="roster-card-title">Task Progress</h6>
                            <div class="roster-progress-counts mb-3">
                                <span class="roster-pill roster-pill--pending">Pending: <strong
                                        id="task-log-count-pending">0</strong></span>
                                <span class="roster-pill roster-pill--running">Running: <strong
                                        id="task-log-count-running">0</strong></span>
                                <span class="roster-pill roster-pill--complete">Complete: <strong
                                        id="task-log-count-complete">0</strong></span>
                            </div>
                            <div id="task-log-status-list" class="small text-muted roster-progress-list">No task progress yet.</div>
                        </div>

                        {{-- Task Log Update — shown via JS only for running shifts (non-admin, today) --}}
                        @can('task_progress_update')
                            <div id="task-log-update-section" class="roster-detail-card d-none">
                                <h6 class="roster-card-title">Update Task Status</h6>
                                <div class="mb-2">
                                    <label class="form-label">Pending Task</label>
                                    <select id="task-log-task-select" class="form-control form-control-sm roster-input">
                                        <option value="">Select a task</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label class="form-label">New Status</label>
                                    <select id="task-log-status-select" class="form-control form-control-sm roster-input">
                                        <option value="pending">Pending</option>
                                        <option value="running">Running</option>
                                        <option value="complete">Complete</option>
                                    </select>
                                </div>
                                <button type="button" class="btn btn-primary btn-sm px-3" id="task-log-update-btn">
                                    Update
                                </button>
                            </div>
                        @endcan
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
                    @can('delete_assigned_roster')
                        <button type="button" class="btn btn-danger me-2 d-none " style="border-radius: 999px" id="shift-detail-delete-btn">
                            Delete
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
                deleteUrlTemplate: "{{ route('admin.roster.delete', ['roster' => 'ROSTER_ID_PLACEHOLDER']) }}",
                clockInUrl: "{{ route('admin.roster.clock.in') }}",
                clockOutUrl: "{{ route('admin.roster.clock.out') }}",
                taskLogsUrlTemplate: "{{ route('admin.roster.task-logs', ['roster' => 'ROSTER_ID_PLACEHOLDER']) }}",
                taskLogUpdateUrlTemplate: "{{ route('admin.roster.task-log.update', ['taskLog' => 'TASK_LOG_ID_PLACEHOLDER']) }}"
            };
        </script>
        <script src="{{ asset('backend/js/pages/roster.js') }}"></script>
    @endpush
@endsection
