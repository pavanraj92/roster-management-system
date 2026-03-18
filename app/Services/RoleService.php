<?php

namespace App\Services;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class RoleService
{
    /**
     * Build DataTable response for roles listing.
     */
    public function getRoleDataTable(Request $request)
    {
        $data = Role::where('guard_name', 'web')->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $search = $request->get('search');
                $keyword = trim((string) ($search['value'] ?? ''));
                if ($keyword !== '') {
                    $query->where('name', 'like', '%' . $keyword . '%');
                }
            })
            ->addColumn('name', function ($row) {
                return ucfirst($row->name);
            })
            ->addColumn('permissions_count', function ($row) {
                return $row->permissions()->count();
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="text-end">
                                <a href="' . route('admin.roles.show', $row->id) . '" class="me-2" title="View">
                                    <i class="material-icons md-remove_red_eye" style="color: #28a745;"> </i>
                                </a>
                                <a href="' . route('admin.roles.edit', $row->id) . '" class="me-2" title="Edit">
                                    <i class="material-icons md-edit" style="color: #ffc107;"> </i>
                                </a>';

                if ($row->name !== 'super-admin') {
                    $btn .= '<form action="' . route('admin.roles.destroy', $row->id) . '" method="POST" class="d-inline delete-form" data-module="Role">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                        <i class="material-icons md-delete_forever" style="color: #dc3545;"> </i>
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
        return Permission::where('guard_name', 'web')->get();
    }

    /**
     * Create a new role and sync its permissions.
     */
    public function createRole(array $validated, ?array $permissionIds = null): Role
    {
        $role = Role::create([
            'name' => $validated['name'],
            'guard_name' => 'web',
        ]);

        if (!empty($permissionIds)) {
            $perms = Permission::whereIn('id', $permissionIds)->get();
            $role->syncPermissions($perms);
        }

        return $role;
    }

    /**
     * Update role name and permissions.
     */
    public function updateRole(Role $role, array $validated, ?array $permissionIds = null): Role
    {
        $role->update([
            'name' => $validated['name'],
        ]);

        if (!is_null($permissionIds)) {
            $perms = Permission::whereIn('id', $permissionIds)->get();
            $role->syncPermissions($perms);
        } else {
            $role->syncPermissions([]);
        }

        return $role;
    }

    /**
     * Delete role if allowed.
     */
    public function deleteRole(Role $role): bool
    {
        if ($role->name === 'super-admin') {
            return false;
        }

        $role->delete();

        return true;
    }

    /**
     * Sync permissions for a role.
     */
    public function syncPermissions(Role $role, ?array $permissionIds = null): void
    {
        $role->syncPermissions($permissionIds ?? []);
    }
}

