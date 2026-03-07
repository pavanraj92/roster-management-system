<?php

namespace App\Services;

use App\Models\Shift;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ShiftService
{
    /**
     * Build DataTable response for shifts listing.
     */
    public function getShiftDataTable(Request $request)
    {
        $data = Shift::query()->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $search = $request->get('search');
                $keyword = $search['value'] ?? '';
                if ($keyword !== '') {
                    $query->where('name', 'like', '%' . $keyword . '%');
                }
            })
            ->addColumn('name', function ($row) {
                return e($row->name);
            })
            ->addColumn('start_time', function ($row) {
                return \Carbon\Carbon::parse($row->start_time)->format('h:i A');
            })
            ->addColumn('end_time', function ($row) {
                return \Carbon\Carbon::parse($row->end_time)->format('h:i A');
            })
            ->addColumn('color', function ($row) {
                if (! $row->color) {
                    return '<span class="text-muted">—</span>';
                }
                return '<span class="badge" style="background-color: ' . e($row->color) . '; color: #fff;">' . e($row->color) . '</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="text-end">
                            <a href="' . route('admin.shifts.show', $row->id) . '" class="me-2" title="View">
                                <i class="material-icons md-remove_red_eye" style="color: #28a745;"> </i>
                            </a>
                            <a href="' . route('admin.shifts.edit', $row->id) . '" class="me-2" title="Edit">
                                <i class="material-icons md-edit" style="color: #ffc107;"> </i>
                            </a>
                            <form action="' . route('admin.shifts.destroy', $row->id) . '" method="POST" class="d-inline delete-form" data-module="Shift">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                    <i class="material-icons md-delete_forever" style="color: #dc3545;"> </i>
                                </button>
                            </form>
                        </div>';
                return $btn;
            })
            ->rawColumns(['action', 'color'])
            ->make(true);
    }

    /**
     * Create a new shift.
     */
    public function createShift(array $validated): Shift
    {
        return Shift::create($validated);
    }

    /**
     * Update a shift.
     */
    public function updateShift(Shift $shift, array $validated): Shift
    {
        $shift->update($validated);

        return $shift;
    }

    /**
     * Delete a shift (soft delete).
     */
    public function deleteShift(Shift $shift): bool
    {
        $shift->delete();

        return true;
    }
}
