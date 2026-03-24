<?php

namespace App\Services;

use App\Models\Permission;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PermissionService
{
    /**
     * Build DataTable response for permissions listing.
     */
    public function getPermissionDataTable(Request $request)
    {
        $query = Permission::query()
            ->select(['id', 'name', 'display_name', 'group_name', 'guard_name', 'created_at'])
            ->where('guard_name', 'web')
            ->orderBy('id', 'desc');

        return DataTables::of($query)
            ->addIndexColumn()
            ->filter(function ($q) use ($request) {
                $search = $request->get('search');
                $keyword = trim((string) ($search['value'] ?? ''));
                if ($keyword !== '') {
                    $q->search($keyword);
                }
            })
            ->orderColumn('display_name', fn($q, $order) => $q->orderBy('display_name', $order))
            ->orderColumn('group_name', fn($q, $order) => $q->orderBy('group_name', $order))
            ->addColumn('display_name', fn(Permission $p) => $p->label)
            ->addColumn('group_name', function (Permission $p) {
                if ($p->group_name) {
                    return '<span class="badge bg-info text-dark">' . e($p->group_name) . '</span>';
                }
                return '<span class="text-muted italic">System</span>';
            })
            ->addColumn('action', function (Permission $p) {
                return '
                    <div class="text-end">
                        <a href="' . route('admin.permissions.show', $p->id) . '" class="me-2" title="View">
                            <i class="material-icons md-remove_red_eye text-success"> </i>
                        </a>
                        <a href="' . route('admin.permissions.edit', $p->id) . '" class="me-2" title="Edit">
                            <i class="material-icons md-edit text-warning"> </i>
                        </a>
                        <form action="' . route('admin.permissions.destroy', $p->id) . '"
                              method="POST"
                              class="d-inline delete-form"
                              data-module="Permission">
                            ' . csrf_field() . '
                            ' . method_field('DELETE') . '
                            <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                <i class="material-icons md-delete_forever text-danger"> </i>
                            </button>
                        </form>
                    </div>';
            })
            ->rawColumns(['action', 'group_name'])
            ->make(true);
    }

    /**
     * Create a new permission.
     */
    public function createPermission(array $validated): Permission
    {
        $validated['guard_name'] = 'web';

        return Permission::create($validated);
    }

    /**
     * Update an existing permission.
     */
    public function updatePermission(Permission $permission, array $validated): Permission
    {
        $permission->update($validated);

        return $permission;
    }

    /**
     * Delete a permission.
     */
    public function deletePermission(Permission $permission): void
    {
        if ($permission->roles()->exists()) {
            throw new \RuntimeException('Cannot delete permission while it is assigned to roles.');
        }

        $permission->delete();
    }
}
