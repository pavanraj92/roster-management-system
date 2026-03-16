<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Roster;
use App\Models\TaskLog;
use App\Services\RosterService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class RosterController extends Controller
{
    protected $rosterService;

    public function __construct(RosterService $rosterService) {
        $this->rosterService = $rosterService;
    }

    public function index(Request $request) {
        $user = auth()->user();
        $roles = $user->getRoleNames();
        
        $data = $this->rosterService->getRosterData($request);
        if ($request->ajax()) {
            return view('admin.roster.partials.roster-table', $data)->render();
        }
        return view('admin.roster.index', $data);
    }

    public function store(Request $request) {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'shift_id' => ['required', 'exists:shifts,id'],
            'task_ids' => ['required', 'array', 'min:1'],
            'task_ids.*' => ['required', Rule::exists('tasks', 'id')],
            'date' => ['required', 'date'],
        ]);

        $this->rosterService->createRoster($validated);

        return response()->json([
            'status'  => true,
            'message' => 'Roster Assigned Successfully',
        ]);
        // return back()->with('success', 'Roster Assigned');
    }

    public function update(Request $request, Roster $roster) {
        $validated = $request->validate([
            'user_id'  => ['required', 'exists:users,id'],
            'shift_id' => ['required', 'exists:shifts,id'],
            'task_ids' => ['required', 'array', 'min:1'],
            'task_ids.*' => ['required', Rule::exists('tasks', 'id')],
            'date'     => ['required', 'date'],
        ]);

        $this->rosterService->updateRoster($roster, $validated);

        return response()->json([
            'status'  => true,
            'message' => 'Roster updated successfully',
        ]);
    }

    public function shiftClockIn(Request $request) {
        $validated = $request->validate([
            'roster_id' => ['required', 'exists:rosters,id'],
        ]);

        $res = $this->rosterService->shiftClockIn($validated['roster_id']);

        if(!$res)  {
            return response()->json([
                'status' => false,
                'message' => 'Something Went Wrong!',
            ]);                    
        }

        return response()->json([
            'status' => true,
            'message' => 'Clocked in Successfully',
            ]);
    }


     public function shiftClockOut(Request $request) {
        
        $validated = $request->validate([
            'attendance_id' => ['required', 'exists:attendances,id'],
        ]);

        $this->rosterService->shiftClockOut($validated['attendance_id']);
        
        return response()->json([
            'status' => true,
            'message' => 'Clocked out Successfully',
        ]);
    }

    public function getTaskLogs(Roster $roster)
    {
        $taskLogs = $this->rosterService->getTaskLogsForRoster($roster->id);

        return response()->json([
            'status' => true,
            'data'   => $taskLogs->map(fn($log) => [
                'id'         => $log->id,
                'task_title' => $log->task?->title ?? 'Unknown',
                'status'     => $log->status,
                'start_at'   => $log->start_at?->format('Y-m-d H:i:s'),
                'end_at'     => $log->end_at?->format('Y-m-d H:i:s'),
                'duration_minutes' => ($log->start_at && $log->end_at)
                    ? $log->end_at->diffInMinutes($log->start_at)
                    : null,
            ]),
        ]);
    }

    public function updateTaskLog(Request $request, TaskLog $taskLog)
    {
        $validated = $request->validate([
            'status' => ['required', Rule::in(['pending', 'running', 'complete'])],
        ]);

        $this->rosterService->updateTaskLog($taskLog, $validated['status']);

        return response()->json([
            'status'  => true,
            'message' => 'Task status updated successfully.',
        ]);
    }
}
