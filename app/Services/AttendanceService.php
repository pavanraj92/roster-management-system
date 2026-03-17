<?php

namespace App\Services;

use App\Models\Attendance;
use App\Models\Roster;
use App\Models\TaskLog;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class AttendanceService
{
    public function getAttendanceDataTable(Request $request)
    {
        $data = Attendance::with(['user', 'shift'])->whereHas('user', function ($query) {
            $query->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'admin');
            });
        })->orderBy('date', 'desc');

        return DataTables::of($data)
            ->addIndexColumn()

            ->filter(function ($query) use ($request) {

                // Employee filter
                if ($search = $request->get('search')['value'] ?? null) {
                    $query->whereHas('user', function ($q) use ($search) {
                        $q->where('first_name', 'like', "%{$search}%")
                            ->orWhere('last_name', 'like', "%{$search}%");
                    });
                }
                // Status filter
                if ($status = $request->get('status')) {
                    $query->where('status', $status);
                }

                // Shift filter
                if ($shift_id = $request->get('shift_id')) {
                    $query->where('shift_id', $shift_id);
                }

                // Date range filter
                if ($from = $request->get('date_from')) {
                    $query->whereDate('date', '>=', $from);
                }
                if ($to = $request->get('date_to')) {
                    $query->whereDate('date', '<=', $to);
                }
            })

            ->addColumn('employee', function ($row) {
                return $row->user->name ?? '-';
            })

            ->addColumn('shift', function ($row) {
                return $row->shift->name ?? '-';
            })

            ->addColumn('date', function ($row) {
                return $row->date;
            })

            ->addColumn('clock_in', function ($row) {
                return $row->clock_in
                    ? \Carbon\Carbon::parse($row->clock_in)->format('h:i A')
                    : '-';
            })

            ->addColumn('clock_out', function ($row) {
                return $row->clock_out
                    ? \Carbon\Carbon::parse($row->clock_out)->format('h:i A')
                    : '-';
            })

            ->addColumn('total_hours', function ($row) {
                return $row->total_hours ?? '-';
            })

            ->addColumn('shift_status', function ($row) {
                $colors = [
                    'running' => 'warning',
                    'completed' => 'success',
                ];
                $status = $row->shift_status ?: '-';

                if ($status === '-') {
                    return '<span class="text-muted">-</span>';
                }

                return '<span class="badge bg-' . ($colors[$status] ?? 'secondary') . '">' . ucfirst($status) . '</span>';
            })

            ->addColumn('status', function ($row) {

                $colors = [
                    'present' => 'success',
                    'late' => 'warning',
                    'absent' => 'danger'
                ];

                return '<span class="badge bg-' . ($colors[$row->status] ?? 'secondary') . '">' . ucfirst($row->status) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="text-end">
                            <a href="' . route('admin.attendances.show', $row->id) . '" class="me-2" title="View">
                                <i class="material-icons md-remove_red_eye" style="color: #28a745;"> </i>
                            </a>                            
                        </div>';
                return $btn;
            })

            ->rawColumns(['shift_status', 'status', 'action'])
            ->make(true);
    }

    public function showAttendance($id)
    {
        $attendance = Attendance::with(['user', 'shift'])->findOrFail($id);

        $rosterIds = Roster::query()
            ->where('user_id', $attendance->user_id)
            ->where('shift_id', $attendance->shift_id)
            ->whereDate('date', $attendance->date)
            ->pluck('id');

        $taskLogs = TaskLog::query()
            ->with(['task', 'user', 'shift', 'roster'])
            ->whereIn('roster_id', $rosterIds)
            ->orderBy('id')
            ->get();

        return view('admin.attendance.show', compact('attendance', 'taskLogs'));
    }
}
