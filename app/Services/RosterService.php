<?php
namespace App\Services;

use App\Models\Roster;
use App\Models\Shift;
use App\Models\Task;
use App\Models\Attendance;
use App\Models\TaskLog;
use App\Models\User;
use Carbon\Carbon;
use Log;
use Illuminate\Support\Facades\DB;

class RosterService
{
    public function createRoster($data) {
        return DB::transaction(function () use ($data) {
            $createdRosters = collect();

            foreach (array_unique($data['task_ids']) as $taskId) {
                $createdRosters->push($this->upsertRosterAssignment(
                    $data['user_id'],
                    $data['shift_id'],
                    $taskId,
                    $data['date'],
                    auth()->id()
                ));
            }

            return $createdRosters;
        });
    }

    public function updateRoster(Roster $roster, array $data): Roster
    {
        return DB::transaction(function () use ($roster, $data) {
            Roster::where('user_id', $roster->user_id)
                ->where('shift_id', $roster->shift_id)
                ->where('date', $roster->date)
                ->delete();

            $taskIds = array_values(array_unique($data['task_ids']));

            foreach ($taskIds as $taskId) {
                $this->upsertRosterAssignment(
                    $data['user_id'],
                    $data['shift_id'],
                    $taskId,
                    $data['date'],
                    auth()->id() ?? $roster->created_by
                );
            }

            return Roster::where('user_id', $data['user_id'])
                ->where('shift_id', $data['shift_id'])
                ->where('date', $data['date'])
                ->whereIn('task_id', $taskIds)
                ->latest('id')
                ->firstOrFail();
        });
    }

    private function upsertRosterAssignment(int $userId, int $shiftId, int $taskId, string $date, ?int $createdBy): Roster
    {
        $existing = Roster::withTrashed()
            ->where('user_id', $userId)
            ->where('shift_id', $shiftId)
            ->where('task_id', $taskId)
            ->where('date', $date)
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            }

            if (!$existing->created_by && $createdBy) {
                $existing->created_by = $createdBy;
                $existing->save();
            }
            return $existing;
        }

        return Roster::create([
            'user_id' => $userId,
            'shift_id' => $shiftId,
            'task_id' => $taskId,
            'date' => $date,
            'created_by' => $createdBy,
        ]);
    }

    public function getRosterData($request) {

        $start = $request->start
            ? Carbon::parse($request->start)
            : Carbon::today();

        $end = $start->copy()->addDays(6);

        $dates = [];

        $current = $start->copy();

        while ($current <= $end) {
            $dates[] = $current->copy(); // KEEP CARBON
            $current->addDay();
        }

        if(auth()->user()->hasRole(['admin'])) {
            $users = User::where('status', 1)
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'Admin');
                })
                ->get();

            $rosterRows = Roster::with(['shift', 'task'])
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get();

        }else{
            $users = User::where('id', auth()->user()->id)->get();

            $rosterRows = Roster::with(['shift', 'task'])
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->where('user_id', auth()->user()->id)
            ->get();
        }

        $rosters = $rosterRows->groupBy(['user_id', 'date']);

        $attendancesByRoster = Attendance::whereIn('roster_id', $rosterRows->pluck('id'))
            ->orderByDesc('id')
            ->get()
            ->unique('roster_id')
            ->keyBy('roster_id');

        // $rosters = Roster::with(['shift', 'task'])
        //     ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
        //     ->get()
        //     ->groupBy(['user_id', 'date']);

        return [
            'users'     => $users,
            'dates'     => $dates,
            'rosters'   => $rosters,
            'attendancesByRoster' => $attendancesByRoster,
            'shifts'    => Shift::all(),
            'tasks'     => Task::all(),
            'startDate' => $start,
        ];
    }

    public function shiftClockIn($id) {
    try{
        $checkLoginIn = Attendance::where('roster_id', $id)->first();

        if ($checkLoginIn != null) {
            return false;
        }

        $roster = Roster::findOrFail($id);

        Attendance::create([
            'user_id' => auth()->id(),
            'roster_id' => $id,
            'clock_in' => Carbon::now(),
            'date' => Carbon::today(),
            'shift_id' => $roster->shift_id,
            'shift_status' => 'running',
        ]);

        // Create a pending task_log for every task in this shift group
        $rosterGroup = Roster::where('user_id', $roster->user_id)
            ->where('shift_id', $roster->shift_id)
            ->where('date', $roster->date)
            ->get();

        foreach ($rosterGroup as $rosterRow) {
            TaskLog::firstOrCreate(
                [
                    'roster_id' => $rosterRow->id,
                    'user_id'   => $rosterRow->user_id,
                    'task_id'   => $rosterRow->task_id,
                ],
                [
                    'shift_id' => $rosterRow->shift_id,
                    'status'   => 'pending',
                ]
            );
        }

        return true;
        }catch(\Exception $e){
            Log::info('error while checkin rosterid:'.$id.'erro is '.$e->getMessage());
            return false;
        }
    }
    
    public function shiftClockOut($id) {
        try {
            $checkLoginIn = Attendance::findOrFail($id);
            if ($checkLoginIn->clock_out) {
                throw new \Exception('Already clocked out for this shift.');
            }
            $checkLoginIn->clock_out = Carbon::now();
            $checkLoginIn->shift_status = 'completed';
            
            $checkLoginIn->save();

        }catch(\Exception $e){
            Log::info('error while clock-out rosterid:'.$id.' error is '.$e->getMessage());
            return false;
        }
    }

    public function getTaskLogsForRoster(int $rosterId): \Illuminate\Support\Collection
    {
        $roster = Roster::findOrFail($rosterId);

        $rosterIds = Roster::where('user_id', $roster->user_id)
            ->where('shift_id', $roster->shift_id)
            ->where('date', $roster->date)
            ->pluck('id');

        return TaskLog::with('task')
            ->whereIn('roster_id', $rosterIds)
            ->orderBy('id')
            ->get();
    }

    public function updateTaskLog(TaskLog $taskLog, string $status): void
    {
        $taskLog->status = $status;

        if ($status === 'running' && !$taskLog->start_at) {
            $taskLog->start_at = Carbon::now();
        }

        if ($status === 'complete' && !$taskLog->end_at) {
            $taskLog->end_at = Carbon::now();
        }

        $taskLog->save();
    }
}
