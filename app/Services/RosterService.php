<?php
namespace App\Services;

use App\Models\Roster;
use App\Models\Shift;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;
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

            $rosters = Roster::with(['shift', 'task'])
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->groupBy(['user_id', 'date']);

        }else{
            $users = User::where('id', auth()->user()->id)->get();

            $rosters = Roster::with(['shift', 'task'])
            ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
            ->get()
            ->where('user_id', auth()->user()->id)
            ->groupBy(['user_id', 'date']);
        }

        // $rosters = Roster::with(['shift', 'task'])
        //     ->whereBetween('date', [$start->toDateString(), $end->toDateString()])
        //     ->get()
        //     ->groupBy(['user_id', 'date']);

        return [
            'users'     => $users,
            'dates'     => $dates,
            'rosters'   => $rosters,
            'shifts'    => Shift::all(),
            'tasks'     => Task::all(),
            'startDate' => $start,
        ];
    }

}
