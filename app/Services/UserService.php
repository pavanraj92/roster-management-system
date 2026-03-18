<?php

namespace App\Services;

use App\Http\Requests\Admin\UserRequest;
use App\Mail\UserCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;

class UserService
{
    /**
     * Build DataTable response for user listing.
     */
    public function getUserDataTable(Request $request)
    {
        $data = User::query()
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
            ->orderColumn('name', function ($query, $order) {
                $query->orderBy('first_name', $order)->orderBy('last_name', $order);
            })
            ->filterColumn('name', function ($query, $keyword) {
                $query->where(function ($q) use ($keyword) {
                    $q->where('first_name', 'like', '%' . $keyword . '%')
                        ->orWhere('last_name', 'like', '%' . $keyword . '%')
                        ->orWhereRaw("CONCAT(COALESCE(first_name, ''), ' ', COALESCE(last_name, '')) LIKE ?", ['%' . $keyword . '%']);
                });
            })
            ->addColumn('role', function ($row) {
                return $row->roles->pluck('name')->implode(', ');
            })
            ->addColumn('name', function ($row) {
                $avatarUrl = $row->avatar_url ?? asset('backend/imgs/theme/avatar-1.png');
                return '
                    <div class="d-flex align-items-center user-cell">
                        <div class="user-avatar me-3">
                            <img style="height: 50px !important; width: 50px !important;" src="' . $avatarUrl . '" alt="' . e($row->name) . '" class="rounded-circle">
                        </div>
                        <div class="user-meta">
                            <div class="user-name fw-semibold">' . e($row->name) . '</div>
                            <div class="user-email text-muted small">' . e($row->email) . '</div>
                            ' . ($row->designation ? '<div class="user-designation badge bg-light text-dark mt-1">' . e($row->designation) . '</div>' : '') . '
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
                            data-url="' . route('admin.user.toggle-status', $row->id) . '"
                            ' . $checked . '>
                    </div>';
            })
            ->addColumn('action', function ($row) {
                return '
                    <div class="text-end">
                        <a href="' . route('admin.user.show', $row->id) . '" class="me-2" title="View">
                            <i class="material-icons md-remove_red_eye text-success"></i>
                        </a>

                        <a href="' . route('admin.user.edit', $row->id) . '" class="me-2" title="Edit">
                            <i class="material-icons md-edit text-warning"></i>
                        </a>

                        <form action="' . route('admin.user.destroy', $row->id) . '"
                              method="POST"
                              class="d-inline delete-form"
                              data-module="User">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                <i class="material-icons md-delete_forever text-danger"></i>
                            </button>
                        </form>
                    </div>
                ';
            })
            ->rawColumns(['name', 'role', 'status', 'action'])
            ->make(true);
    }

    /**
     * Create a new user and send credentials.
     */
    public function createUser(array $validated, bool $statusFlag = true): User
    {
        $password = Str::random(10);

        $data = $validated;

        $roles = $data['roles'] ?? [];
        unset($data['roles']);

        $data['password'] = Hash::make($password);
        $data['status'] = $statusFlag;

        $user = User::create($data);

        // Assign roles (multi-role support)
        if (!empty($roles)) {
            $user->syncRoles($roles);
        }

        try {
            Mail::to($user->email)->queue(new UserCreatedMail($user, $password));
        } catch (\Throwable $e) {
            Log::error('Failed to send user created email', [
                'user_id' => $user->id,
                'error' => $e->getMessage(),
            ]);
        }

        return $user;
    }

    /**
     * Update an existing user.
     */
    public function updateUser(User $user, array $validated, bool $statusFlag = true): User
    {
        $data = $validated;

        $roles = $data['roles'] ?? [];
        unset($data['roles']);
        unset($data['email']);
        unset($data['phone']);

        $data['status'] = $statusFlag;

        $user->update($data);

        // Sync roles (removes old + adds new)
        $user->syncRoles($roles);

        return $user;
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user): void
    {
        $user->delete();
    }

    /**
     * Toggle active status of a user.
     */
    public function toggleStatus(int $id): User
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;
        $user->save();

        return $user;
    }
}

