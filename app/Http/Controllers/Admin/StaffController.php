<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StaffRequest;
use App\Models\User;
use App\Services\StaffService;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function __construct(
        protected StaffService $staffService
    ) {
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->staffService->getStaffDataTable($request);
        }

        return view('admin.staff.index');
    }

    public function create()
    {
        return view('admin.staff.create');
    }

    public function store(StaffRequest $request)
    {
        $this->staffService->createStaff($request->validated(), $request->has('status'));

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff created successfully.');
    }

    public function show(User $staff)
    {
        return view('admin.staff.show', compact('staff'));
    }

    public function edit(User $staff)
    {
        return view('admin.staff.edit', compact('staff'));
    }

    public function update(StaffRequest $request, User $staff)
    {
        $this->staffService->updateStaff($staff, $request->validated(), $request->has('status'));

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff updated successfully.');
    }

    public function destroy(Request $request, User $staff)
    {
        $this->staffService->deleteStaff($staff);

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'Staff deleted successfully.'
            ]);
        }

        return redirect()->route('admin.staff.index')
            ->with('success', 'Staff deleted successfully.');
    }

    public function toggleStatus($id)
    {
        $staff = $this->staffService->toggleStatus((int) $id);

        return response()->json([
            'success' => true,
            'status' => $staff->status
        ]);
    }
}
