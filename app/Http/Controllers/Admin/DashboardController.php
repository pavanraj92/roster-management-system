<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Shift;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        // total users
        $totalUsersCount = User::count();

        // manager counts
        $managersCount = User::role('manager')->count();
        $activeManagersCount = User::role('manager')->where('status', 1)->count();
        $inactiveManagersCount = User::role('manager')->where('status', 0)->count();

        // Staff counts
        $staffsCount = User::role('staff')->count();
        $activeStaffsCount = User::role('staff')->where('status', 1)->count();
        $inactiveStaffsCount = User::role('staff')->where('status', 0)->count();

        // Shifts
        $totalShifts = Shift::count();

        // Attendance stats (today)
        $today = Carbon::today()->toDateString();

        $presentToday = Attendance::whereDate('date', $today)
            ->where('status', 'present')
            ->count();

        $absentToday = Attendance::whereDate('date', $today)
            ->where('status', 'absent')
            ->count();

        $lateToday = Attendance::whereDate('date', $today)
            ->where('status', 'late')
            ->count();

        // Latest 5 staff
        $latestUsers = User::latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsersCount',
            'managersCount',
            'activeManagersCount',
            'inactiveManagersCount',
            'staffsCount',
            'activeStaffsCount',
            'inactiveStaffsCount',
            'totalShifts',
            'presentToday',
            'absentToday',
            'lateToday',
            'latestUsers'
        ));
    }
}
