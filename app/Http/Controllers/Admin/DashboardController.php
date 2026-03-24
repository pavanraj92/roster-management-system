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
        $userCounts = User::role(['staff', 'manager'])
            ->selectRaw('COUNT(*) as total_users')
            ->selectRaw('SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_users')
            ->selectRaw('SUM(CASE WHEN status = 0 THEN 1 ELSE 0 END) as inactive_users')
            ->first();

        $totalUsersCount = (int) ($userCounts->total_users ?? 0);
        $activeUsersCount = (int) ($userCounts->active_users ?? 0);
        $inactiveUsersCount = (int) ($userCounts->inactive_users ?? 0);

        // Shifts
        $totalShifts = Shift::count();

        // Attendance stats (today)
        $today = Carbon::today()->toDateString();

        $attendanceStats = Attendance::query()
            ->whereDate('date', $today)
            ->selectRaw("SUM(CASE WHEN status = 'present' THEN 1 ELSE 0 END) as present_today")
            ->selectRaw("SUM(CASE WHEN status = 'absent' THEN 1 ELSE 0 END) as absent_today")
            ->selectRaw("SUM(CASE WHEN status = 'late' THEN 1 ELSE 0 END) as late_today")
            ->first();

        $presentToday = (int) ($attendanceStats->present_today ?? 0);
        $absentToday = (int) ($attendanceStats->absent_today ?? 0);
        $lateToday = (int) ($attendanceStats->late_today ?? 0);

        // Latest 5 staff
        $latestUsers = User::query()
            ->select(['id', 'first_name', 'last_name', 'email', 'created_at'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'totalUsersCount',
            'activeUsersCount',
            'inactiveUsersCount',
            // 'managersCount',
            // 'activeManagersCount',
            // 'inactiveManagersCount',
            // 'staffsCount',
            // 'activeStaffsCount',
            // 'inactiveStaffsCount',
            'totalShifts',
            'presentToday',
            'absentToday',
            'lateToday',
            'latestUsers'
        ));
    }
}
