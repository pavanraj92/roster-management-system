<?php

namespace App\Services;

use App\Http\Requests\Admin\StaffRequest;
use App\Mail\StaffCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class StaffService
{
    /**
     * Build DataTable response for staff listing.
     */
    public function getStaffDataTable(Request $request)
    {
        $data = User::role('staff')
            ->where('id', '!=', auth()->id())
            ->latest();

        if ($request->status !== null && $request->status !== '') {
            $data->where('status', (int) $request->status);
        }

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $search = $request->get('search');
                $keyword = trim((string) ($search['value'] ?? ''));

                if ($keyword !== '') {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('first_name', 'like', '%' . $keyword . '%')
                            ->orWhere('last_name', 'like', '%' . $keyword . '%')
                            ->orWhere('email', 'like', '%' . $keyword . '%')
                            ->orWhere('phone', 'like', '%' . $keyword . '%')
                            ->orWhere('designation', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->addColumn('name', function ($row) {
                $avatarUrl = $row->avatar_url ?? asset('backend/imgs/people/avatar-1.png');

                return '
                    <div class="d-flex align-items-center staff-cell">
                        <div class="staff-avatar me-3">
                            <img src="' . $avatarUrl . '" alt="' . e($row->name) . '" class="rounded-circle">
                        </div>
                        <div class="staff-meta">
                            <div class="staff-name fw-semibold">' . e($row->name) . '</div>
                            <div class="staff-email text-muted small">' . e($row->email) . '</div>
                            ' . ($row->designation ? '<div class="staff-designation badge bg-light text-dark mt-1">' . e($row->designation) . '</div>' : '') . '
                        </div>
                    </div>
                ';
            })
            ->addColumn('status', function ($row) {
                $checked = $row->status ? 'checked' : '';
                return '<div class="form-check form-switch text-center">
                        <input class="form-check-input toggle-status"
                            type="checkbox"
                            data-id="' . $row->id . '"
                            data-url="' . route('admin.staff.toggle-status', $row->id) . '"
                            ' . $checked . '>
                    </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                        <div class="text-end">
                            <a href="' . route('admin.staff.show', $row->id) . '" class="me-2" title="View">
                                <i class="material-icons md-remove_red_eye text-success"></i>
                            </a>

                            <a href="' . route('admin.staff.edit', $row->id) . '" class="me-2" title="Edit">
                                <i class="material-icons md-edit text-warning"></i>
                            </a>

                            <form action="' . route('admin.staff.destroy', $row->id) . '"
                                  method="POST"
                                  class="d-inline delete-form"
                                  data-module="Staff">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                    <i class="material-icons md-delete_forever text-danger"></i>
                                </button>
                            </form>
                        </div>
                    ';
            })
            ->rawColumns(['name', 'status', 'action'])
            ->make(true);
    }

    /**
     * Create a new staff user and send credentials.
     */
    public function createStaff(array $validated, bool $statusFlag = true): User
    {
        $password = Str::random(10);

        $data = $validated;
        $data['password'] = Hash::make($password);
        $data['status'] = $statusFlag;

        $staff = User::create($data);
        $staff->assignRole('staff');

        try {
            Mail::to($staff->email)->queue(new StaffCreatedMail($staff, $password));
        } catch (\Throwable $e) {
            Log::error('Failed to send staff created email', [
                'staff_id' => $staff->id,
                'error' => $e->getMessage(),
            ]);
        }

        return $staff;
    }

    /**
     * Update an existing staff user.
     */
    public function updateStaff(User $staff, array $validated, bool $statusFlag = true): User
    {
        $data = $validated;
        unset($data['email']);
        unset($data['phone']);
        $data['status'] = $statusFlag;

        $staff->update($data);

        return $staff;
    }

    /**
     * Delete a staff user.
     */
    public function deleteStaff(User $staff): void
    {
        $staff->delete();
    }

    /**
     * Toggle active status of a staff user.
     */
    public function toggleStatus(int $id): User
    {
        $staff = User::findOrFail($id);
        $staff->status = !$staff->status;
        $staff->save();

        return $staff;
    }
}

