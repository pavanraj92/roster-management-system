<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Shift\ShiftStoreRequest;
use App\Http\Requests\Shift\ShiftUpdateRequest;
use App\Models\Shift;
use App\Services\ShiftService;
use Illuminate\Http\Request;

class ShiftController extends Controller
{
    public function __construct(protected ShiftService $shiftService) {

    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            return $this->shiftService->getShiftDataTable($request);
        }
        return view('admin.shifts.index');
    }

    /**
     * Show the form for creating a new resource.
    */
    public function create()
    {
        return view('admin.shifts.create');
    }

    /**
     * Store A Newly Created Resource In Storage.
     */
    public function store(ShiftStoreRequest $request)
    {
        $this->shiftService->createShift($request->validated());

        return redirect()->route('admin.shifts.index')->with('success', 'Shift created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Shift $shift)
    {
        return view('admin.shifts.show', compact('shift'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Shift $shift)
    {
        return view('admin.shifts.edit', compact('shift'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ShiftUpdateRequest $request, Shift $shift)
    {
        $this->shiftService->updateShift($shift, $request->validated());

        return redirect()->route('admin.shifts.index')->with('success', 'Shift updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, Shift $shift)
    {
        $res = $this->shiftService->deleteShift($shift);

        if( $request->ajax()) {
            if($res){
                return response()->json(['success' => true, 'message' => 'Shift deleted successfully.']);
            }
            return response()->json(['success' => false, 'message' => 'This shift is already assigned']);
        }else{
             if($res){
            return redirect()->route('admin.shifts.index')->with('success', 'Shift deleted successfully.');
             }
            return redirect()->route('admin.shifts.index')->with('error', 'This shift is already assigned.');
        }
    }
}
