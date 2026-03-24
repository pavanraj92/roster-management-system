<?php

namespace App\Services;

use App\Mail\UserCreatedMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
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
        $query = User::query()
            ->select([
                'id',
                'first_name',
                'last_name',
                'email',
                'phone',
                'designation',
                'avatar',
                'status',
                'created_at',
            ])
            ->with('roles:id,name')
            ->where('id', '!=', auth()->id())
            ->filterStatus($request->status)
            ->latest();

        return DataTables::of($query)
            ->addIndexColumn()
            ->filter(function ($q) use ($request) {
                $search = $request->get('search');
                $keyword = trim((string) ($search['value'] ?? ''));

                if ($keyword !== '') {
                    $q->search($keyword);
                }
            })
            ->orderColumn('name', function ($q, $order) {
                $q->orderBy('first_name', $order)->orderBy('last_name', $order);
            })
            ->filterColumn('name', function ($q, $keyword) {
                $q->search($keyword);
            })
            ->addColumn('role', function (User $user) {
                return $user->roles->pluck('name')->implode(', ');
            })
            ->addColumn('name', function (User $user) {
                return '
                    <div class="d-flex align-items-center user-cell">
                        <div class="user-avatar me-3">
                            <a href="' . $user->avatar_url . '" class="image-popup">
                                <img style="height: 50px !important; width: 50px !important;" src="' . $user->avatar_url . '" alt="' . e($user->name) . '" class="rounded-circle shadow-sm border">
                            </a>
                        </div>
                        <div class="user-meta">
                            <div class="user-name fw-semibold">' . e($user->name) . '</div>
                            <div class="user-email text-muted small">' . e($user->email) . '</div>
                            ' . ($user->designation ? '<div class="user-designation badge bg-light text-dark mt-1">' . e($user->designation) . '</div>' : '') . '
                        </div>
                    </div>
                ';
            })
            ->addColumn('status', function (User $user) {
                $checked = $user->status ? 'checked' : '';
                return '
                    <div class="form-check form-switch text-center">
                        <input class="form-check-input toggle-status"
                            type="checkbox"
                            data-id="' . $user->id . '"
                            data-url="' . route('admin.user.toggle-status', $user->id) . '"
                            ' . $checked . '>
                    </div>';
            })
            ->addColumn('action', function (User $user) {
                return '
                    <div class="text-end">
                        <a href="' . route('admin.user.show', $user->id) . '" class="me-2" title="View">
                            <i class="material-icons md-remove_red_eye text-success"></i>
                        </a>
                        <a href="' . route('admin.user.edit', $user->id) . '" class="me-2" title="Edit">
                            <i class="material-icons md-edit text-warning"></i>
                        </a>
                        <form action="' . route('admin.user.destroy', $user->id) . '"
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
        [$data, $roles, $avatar] = $this->extractUserPayload($validated);
        $data['password'] = Hash::make($password);
        $data['status'] = $statusFlag;

        $user = DB::transaction(function () use ($data, $roles, $avatar) {
            $user = User::create($data);

            if (!empty($roles)) {
                $user->syncRoles($roles);
            }

            if ($avatar instanceof UploadedFile) {
                $user->uploadMedia($avatar, 'avatar');
            }

            return $user;
        });

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
        [$data, $roles, $avatar] = $this->extractUserPayload($validated);
        $data['status'] = $statusFlag;

        // Disallow updating email and phone on edit
        unset($data['email'], $data['phone']);

        return DB::transaction(function () use ($user, $data, $roles, $avatar) {
            $user->update($data);
            $user->syncRoles($roles);

            if ($avatar instanceof UploadedFile) {
                $user->uploadMedia($avatar, 'avatar');
            }

            return $user;
        });
    }

    /**
     * Delete a user.
     */
    public function deleteUser(User $user): void
    {
        $user->clearMedia('avatar'); // Optional: Cleanup media on permanent delete
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

    /**
     * Helper to extract data, roles and avatar from payload.
     */
    private function extractUserPayload(array $validated): array
    {
        $roles = $validated['roles'] ?? [];
        $avatar = $validated['avatar'] ?? null;

        unset($validated['roles'], $validated['avatar']);

        return [$validated, $roles, $avatar];
    }
}
