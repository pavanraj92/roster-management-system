<?php

namespace App\Services;

use App\Http\Requests\Admin\StaffRequest;
use App\Mail\StaffCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
            ->filterStatus($request->status)
            ->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $search = $request->get('search');
                $keyword = trim((string) ($search['value'] ?? ''));

                if ($keyword !== '') {
                    $query->search($keyword);
                }
            })
            ->addColumn('name', function ($row) {
                return '
                    <div class="d-flex align-items-center staff-cell">
                        <div class="staff-avatar me-3">
                            <a href="' . $row->avatar_url . '" class="image-popup">
                                <img style="height: 50px !important; width: 50px !important;" src="' . $row->avatar_url . '" alt="' . e($row->name) . '" class="rounded-circle shadow-sm border">
                            </a>
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
        [$data, $avatar] = $this->extractStaffPayload($validated);
        $data['password'] = Hash::make($password);
        $data['status'] = $statusFlag;

        $staff = DB::transaction(function () use ($data, $avatar) {
            $staff = User::create($data);
            $staff->assignRole('staff');

            if ($avatar instanceof \Illuminate\Http\UploadedFile) {
                $staff->uploadMedia($avatar, 'avatar');
            }

            return $staff;
        });

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
        [$data, $avatar] = $this->extractStaffPayload($validated);
        unset($data['email'], $data['phone']);
        $data['status'] = $statusFlag;

        return DB::transaction(function () use ($staff, $data, $avatar) {
            $staff->update($data);

            if ($avatar instanceof \Illuminate\Http\UploadedFile) {
                $staff->uploadMedia($avatar, 'avatar');
            }

            return $staff;
        });
    }

    /**
     * Delete a staff user.
     */
    public function deleteStaff(User $staff): void
    {
        $staff->clearMedia('avatar');
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

    private function extractStaffPayload(array $validated): array
    {
        $avatar = $validated['avatar'] ?? null;
        unset($validated['avatar']);
        return [$validated, $avatar];
    }
}

