<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Role\RoleRequest;
use App\Models\Role;
use App\Services\RoleService;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct(
        protected RoleService $roleService
    ) {
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return $request->ajax()
            ? $this->roleService->getRoleDataTable($request)
            : view('admin.roles.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.roles.create', [
            'permissions' => $this->roleService->getAllPermissions()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(RoleRequest $request)
    {
        $this->roleService->createRole($request->validated(), $request->validated('permissions'));

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $role->loadMissing('permissions');
        $permissions = $role->permissions;

        return view('admin.roles.show', compact('role', 'permissions'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $role->loadMissing('permissions:id');

        return view('admin.roles.edit', [
            'role' => $role,
            'permissions' => $this->roleService->getAllPermissions(),
            'rolePermissions' => $role->permissions->pluck('id')->all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(RoleRequest $request, Role $role)
    {
        $this->roleService->updateRole($role, $request->validated(), $request->validated('permissions'));

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        if (!$this->roleService->deleteRole($role)) {
            return redirect()->route('admin.roles.index')
                ->with('error', 'Cannot delete this role while it is protected or assigned.');
        }

        return redirect()->route('admin.roles.index')
            ->with('success', 'Role deleted successfully.');
    }

    /**
     * Assign permissions to a role.
     */
    public function assignPermissions(Request $request, Role $role)
    {
        $validated = $request->validate([
            'permissions' => 'array',
            'permissions.*' => 'exists:permissions,id',
        ]);

        $this->roleService->syncPermissions($role, $validated['permissions'] ?? []);

        return response()->json([
            'success' => true,
            'message' => 'Permissions assigned successfully.'
        ]);
    }
}
