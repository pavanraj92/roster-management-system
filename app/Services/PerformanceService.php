<?php
namespace App\Services;

use App\Models\Attendance;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PerformanceService
{
    public function getPerformanceDataTable(Request $request)
    {
        $startDate = $request->filled('start_date')
        ? Carbon::parse($request->start_date)->toDateString()
        : now()->subMonth()->toDateString();

    $endDate = $request->filled('end_date')
        ? Carbon::parse($request->end_date)->toDateString()
        : now()->toDateString();

    $users = User::query()
        ->whereDoesntHave('roles', function ($q) {
            $q->where('name', 'Admin');
        })
        ->leftJoin('rosters', function ($join) use ($startDate, $endDate) {
            $join->on('users.id', '=', 'rosters.user_id')
                ->whereBetween('rosters.date', [$startDate, $endDate]);
        })
        ->leftJoin('attendances', 'attendances.roster_id', '=', 'rosters.id')
        ->leftJoin('task_logs', 'task_logs.attendance_id', '=', 'attendances.id')

        ->selectRaw('
            users.id,
            users.first_name,
            users.last_name,

            COUNT(DISTINCT attendances.id) as total_shifts,

            COUNT(task_logs.id) as total_tasks,

            SUM(CASE WHEN task_logs.status="complete" THEN 1 ELSE 0 END) as completed_tasks,
            SUM(CASE WHEN task_logs.status="running" THEN 1 ELSE 0 END) as running_tasks,
            SUM(CASE WHEN task_logs.status="pending" THEN 1 ELSE 0 END) as pending_tasks,

            SUM(
                TIMESTAMPDIFF(SECOND, task_logs.start_at, task_logs.end_at)
            ) as working_seconds
        ')
        ->groupBy('users.id')
        ->get();

        foreach ($users as $user) {

            $workingSeconds = $user->working_seconds ?? 0;

            $user->working_hours = gmdate("H:i:s", $workingSeconds);

            $user->completion_rate = $user->total_tasks > 0
                ? round(($user->completed_tasks / $user->total_tasks) * 100, 2)
                : 0;
        }


        return DataTables::of($users)
        ->addIndexColumn()
        ->addColumn('employee', function ($row) {
            return $row->first_name . ' ' . ($row->last_name ?? '');
        })
        ->make(true);

        $data = [];

        foreach ($users as $key => $user) {
            $totalTasks = 0;
            $completed  = 0;
            $running    = 0;
            $pending    = 0;
            $working_seconds = 0;
            $working_hours  = 0;
            $rosters    = $user->rosters;

            foreach ($rosters as $roster) {                
                if($roster->attendance) {                  
                    foreach ($roster->attendance->tasklogs as $task) {
                        $totalTasks++;
                        if ($task->status == 'complete') {
                            $completed++;
                        }
                        if ($task->status == 'running') {
                            $running++;
                        }
                        if ($task->status == 'pending') {
                            $pending++;
                        }

                        if ($task->start_at && $task->end_at) {
                            $taskStart = \Carbon\Carbon::parse($task->start_at);
                            $taskEnd = \Carbon\Carbon::parse($task->end_at);

                            $working_seconds += $taskStart->diffInSeconds($taskEnd);
                        }
                    }
                }
            }

            $completionRate = $totalTasks > 0
            ? round(($completed / $totalTasks) * 100, 2)
            : 0;

            // Convert Seconds To Hours
            $working_hours = gmdate("H:i:s", $working_seconds);
            $users[$key]->working_hours =  $working_hours;
            $users[$key]->total_shifts =  $rosters->count();
            $users[$key]->total_tasks = $totalTasks;
            $users[$key]->completed_tasks = $completed;
            $users[$key]->running_tasks = $running;
            $users[$key]->pending_tasks = $pending;            
            $users[$key]->completion_rate = $completionRate;
            $users[$key]->total_shifts = $rosters->count();
        }

        return DataTables::of($users)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $search = strtolower(trim($request->input('search.value', '')));
                if ($search === '') {
                    return;
                }
                $query->setCollection(
                    $query->getCollection()->filter(function ($row) use ($search) {
                        return str_contains(strtolower((string) $row->employee), $search);
                    })->values()
                );
            })->addColumn('employee', function ($row) {
            return $row->first_name . ' ' . ($row->last_name ?? '-');
        })->make(true);
    }

    public function showAttendance($id)
    {
        $attendance = Attendance::with(['user', 'shift'])->findOrFail($id);
        return view('admin.attendance.show', compact('attendance'));
    }
}
