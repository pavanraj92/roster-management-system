@extends('admin.layouts.app')

@section('title', 'View Attendance')

@section('content')
<section class="content-main">

    <div class="row">
        <div class="clearfix">
            <div class="float-start">
                <h2 class="content-title card-title mb-0">Attendance Details</h2>
                <p class="listing-page-subtitle mb-3">
                    {{ $attendance->user->name ?? '-' }}
                </p>
            </div>

            <x-admin.breadcrumb :list="[
                    ['label' => 'Attendance Manager', 'url' => route('admin.attendances.index')],
                    ['label' => 'View Attendance']
                ]" class="float-end" />
        </div>
    </div>

    <div class="card mb-4 details-card">
        <div class="card-body">
            <div class="details-info-group">
                <div class="details-item">
                    <span class="details-label">Employee</span>
                    <span class="details-value"><strong>{{ $attendance->user->name ?? '-' }}</strong></span>
                </div>
                <div class="details-item">
                    <span class="details-label">Date</span>
                    <span class="details-value">{{ $attendance->date->format('M d, Y') }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Shift</span>
                    <span class="details-value">{{ $attendance->shift->name ?? '-' }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Shift Status</span>
                    <span class="details-value">
                        @php
                            $shiftStatusColors = ['running' => 'warning', 'completed' => 'success'];
                            $shiftStatusColor = $shiftStatusColors[$attendance->shift_status] ?? 'secondary';
                        @endphp
                        @if($attendance->shift_status)
                            <span class="badge bg-{{ $shiftStatusColor }}">{{ ucfirst($attendance->shift_status) }}</span>
                        @else
                            -
                        @endif
                    </span>
                </div>
                <div class="details-item">
                    <span class="details-label">Clock In</span>
                    <span class="details-value">{{ $attendance->clock_in ? $attendance->clock_in->format('h:i A') : '-' }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Clock Out</span>
                    <span class="details-value">{{ $attendance->clock_out ? $attendance->clock_out->format('h:i A') : '-' }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Total Hours</span>
                    <span class="details-value">{{ $attendance->total_hours ?? '-' }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Status</span>
                    <span class="details-value">
                        @php
                        $colors = ['present' => 'success', 'late' => 'warning', 'absent' => 'danger'];
                        $color = $colors[$attendance->status] ?? 'secondary';
                        @endphp
                        <span class="badge bg-{{ $color }}">{{ ucfirst($attendance->status) }}</span>
                    </span>
                </div>
                <div class="details-item">
                    <span class="details-label">Created At</span>
                    <span class="details-value">{{ $attendance->created_at->format('M d, Y h:i A') }}</span>
                </div>
                <div class="details-item">
                    <span class="details-label">Updated At</span>
                    <span class="details-value">{{ $attendance->updated_at->format('M d, Y h:i A') }}</span>
                </div>
            </div>

            <div class="mt-4">
                <h5 class="card-title mb-3">Task History ({{ $taskLogs->count() }})</h5>

                @if($taskLogs->count() > 0)
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead>
                                <tr>
                                    <th width="60">#</th>
                                    <th>Task</th>
                                    <th width="120">Status</th>
                                    <th width="170">Start</th>
                                    <th width="170">End</th>
                                    <th width="180">Updated At</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($taskLogs as $i => $log)
                                    <tr>
                                        <td>{{ $i + 1 }}</td>
                                        <td><strong>{{ $log->task?->title ?? '-' }}</strong></td>
                                        <td>
                                            @php
                                                $statusColors = ['pending' => 'secondary', 'running' => 'warning', 'complete' => 'success'];
                                                $statusColor = $statusColors[$log->status] ?? 'secondary';
                                            @endphp
                                            <span class="badge bg-{{ $statusColor }}">{{ ucfirst($log->status) }}</span>
                                        </td>
                                        <td>{{ $log->start_at?->format('M d, Y h:i A') ?? '-' }}</td>
                                        <td>{{ $log->end_at?->format('M d, Y h:i A') ?? '-' }}</td>
                                        <td>{{ $log->updated_at?->format('M d, Y h:i A') ?? '-' }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-muted mb-0">No tasks found for this attendance date.</p>
                @endif
            </div>
            <div class="mt-4">
                <a href="{{ route('admin.attendances.index') }}" class="btn btn-light">
                    <i class="material-icons md-arrow_back"></i> Back
                </a>
            </div>
        </div>
    </div>
</section>
@endsection