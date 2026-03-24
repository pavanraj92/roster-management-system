<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class RoleService
{
    /**
     * Build DataTable response for roles listing.
     */
    public function getRoleDataTable(Request $request)
    {
        $query = Role::query()
            ->select(['id', 'name', 'guard_name', 'created_at'])
            ->where('guard_name', 'web')
            ->withCount('permissions')
            ->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->filter(function ($q) use ($request) {
                $search = $request->get('search');
                $keyword = trim((string) ($search['value'] ?? ''));
                if ($keyword !== '') {
                    $q->where('name', 'like', "%{$keyword}%");
                }
            })
            ->addColumn('name', fn(Role $role) => ucfirst($role->name))
            ->addColumn('permissions_count', fn(Role $role) => $role->permissions_count)
            ->addColumn('action', function (Role $role) {
                $btn = '<div class="text-end">
                            <a href="' . route('admin.roles.show', $role->id) . '" class="me-2" title="View">
                                <i class="material-icons md-remove_red_eye text-success"></i>
                            </a>
                            <a href="' . route('admin.roles.edit', $role->id) . '" class="me-2" title="Edit">
                                <i class="material-icons md-edit text-warning"></i>
                            </a>';

                if ($role->name !== 'super-admin' && $role->name !== 'admin') {
                    $btn .= '<form action="' . route('admin.roles.destroy', $role->id) . '" method="POST" class="d-inline delete-form" data-module="Role">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                    <i class="material-icons md-delete_forever text-danger"></i>
                                </button>
                            </form>';
                }

                $btn .= '</div>';
                return $btn;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    /**
     * Return all web guard permissions.
     */
    public function getAllPermissions()
    {
        return Permission::query()
            ->where('guard_name', 'web')
            ->orderBy('group_name')
            ->orderBy('display_name')
            ->orderBy('name')
            ->get();
    }

    /**
     * Create a new role and sync its permissions.
     */
    public function createRole(array $validated, ?array $permissionIds = null): Role
    {
        return DB::transaction(function () use ($validated, $permissionIds) {
            $role = Role::create([
                'name' => $validated['name'],
                'guard_name' => 'web',
            ]);

            $role->syncPermissions($this->resolvePermissions($permissionIds));

            return $role;
        });
    }

    /**
     * Update role name and permissions.
     */
    public function updateRole(Role $role, array $validated, ?array $permissionIds = null): Role
    {
        return DB::transaction(function () use ($role, $validated, $permissionIds) {
            $role->update([
                'name' => $validated['name'],
            ]);

            $role->syncPermissions($this->resolvePermissions($permissionIds));

            return $role;
        });
    }

    /**
     * Delete role if allowed.
     */
    public function deleteRole(Role $role): bool
    {
        // Protected roles
        if (in_array($role->name, ['super-admin', 'admin'])) {
            return false;
        }

        // Check if role is assigned to any user
        if (DB::table('model_has_roles')->where('role_id', $role->id)->exists()) {
            return false;
        }

        return $role->delete();
    }

    /**
     * Sync permissions for a role.
     */
    public function syncPermissions(Role $role, ?array $permissionIds = null): void
    {
        $role->syncPermissions($this->resolvePermissions($permissionIds));
    }

    /**
     * Resolve actual models from ID array to safely sync with Spatie.
     */
    private function resolvePermissions(?array $ids)
    {
        if (empty($ids)) {
            return collect();
        }

        return Permission::query()
            ->webGuard()
            ->whereIn('id', $ids)
            ->get();
    }
}
