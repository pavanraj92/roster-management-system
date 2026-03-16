<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shift;
use App\Services\AttendanceService;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{
    public function __construct(
        protected AttendanceService $attendanceService
    ) {}

    public function index(Request $request)
    {
        $shifts = Shift::all();
        if ($request->ajax()) {
            return $this->attendanceService->getAttendanceDataTable($request);
        }

        return view('admin.attendance.index', compact('shifts'));
    }

    public function show($id)
    {
        return $this->attendanceService->showAttendance($id);
    }
}
