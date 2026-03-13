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
        $data = Permission::where('guard_name', 'web')->latest();

        return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                $search = $request->get('search');
                $keyword = trim((string) ($search['value'] ?? ''));

                if ($keyword !== '') {
                    $query->where(function ($q) use ($keyword) {
                        $q->where('display_name', 'like', '%' . $keyword . '%')
                            ->orWhere('group_name', 'like', '%' . $keyword . '%');
                    });
                }
            })
            ->orderColumn('display_name', function ($query, $order) {
                $query->orderBy('display_name', $order);
            })
            ->orderColumn('group_name', function ($query, $order) {
                $query->orderBy('group_name', $order);
            })
            ->addColumn('display_name', function ($row) {
                return $row->display_name ?: ucfirst(str_replace('_', ' ', (string) $row->name));
            })
            ->addColumn('group_name', function ($row) {
                return $row->group_name ?: '<span class="text-muted">-</span>';
            })
            ->addColumn('action', function ($row) {
                $btn = '<div class="text-end">
                                <a href="' . route('admin.permissions.show', $row->id) . '" class="me-2" title="View">
                                    <i class="material-icons md-remove_red_eye" style="color: #28a745;"> </i>
                                </a>
                                <a href="' . route('admin.permissions.edit', $row->id) . '" class="me-2" title="Edit">
                                    <i class="material-icons md-edit" style="color: #ffc107;"> </i>
                                </a>
                                <form action="' . route('admin.permissions.destroy', $row->id) . '" method="POST" class="d-inline delete-form" data-module="Permission">
                                    ' . csrf_field() . '
                                    ' . method_field('DELETE') . '
                                    <button type="submit" class="border-0 bg-transparent p-0" title="Delete">
                                        <i class="material-icons md-delete_forever" style="color: #dc3545;"> </i>
                                    </button>
                                </form>
                            </div>';
                return $btn;
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
        $permission->delete();
    }
}

