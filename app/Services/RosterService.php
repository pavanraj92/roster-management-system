<?php
namespace App\Services;

use App\Models\Roster;
use App\Models\Shift;
use App\Models\Task;
use App\Models\User;
use Carbon\Carbon;

class RosterService
{
    public function createRoster($data)
    {
        return Roster::create([
            'user_id'    => $data['user_id'],
            'shift_id'   => $data['shift_id'],
            'task_id'    => $data['task_id'],
            'date'       => $data['date'],
            'created_by' => auth()->id(),
        ]);
    }

    public function updateRoster(Roster $roster, array $data): Roster
    {
        $roster->update([
            'user_id'  => $data['user_id'],
            'shift_id' => $data['shift_id'],
            'task_id'  => $data['task_id'],
            'date'     => $data['date'],
        ]);

        return $roster;
    }

    public function getRosterData($request)
    {
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


        if(auth()->user()->hasRole(['Admin'])){
            $users = User::where('status', 1)
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'admin');
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
