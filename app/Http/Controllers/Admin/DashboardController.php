<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\User;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard
     */
    public function index()
    {
        $staffsCount = User::role('staff')->count();
        $activeStaffsCount = User::role('staff')->where('status', 1)->count();
        $inactiveStaffsCount = User::role('staff')->where('status', 0)->count();
        $latestStaffs = User::role('staff')->latest()->take(5)->get();

        // For now, revenue and monthly earning are static as there is no order system yet
        return view('admin.dashboard', compact('staffsCount', 'activeStaffsCount', 'inactiveStaffsCount', 'latestStaffs'));
    }
}
