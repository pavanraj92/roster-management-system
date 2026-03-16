<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    public function run(): void
    {
        // Admin gets all permissions
        $adminRole = Role::firstWhere('name', 'admin');
        if ($adminRole) {
            $allPermissions = Permission::where('guard_name', 'web')->pluck('name'); // use names instead of IDs
            $adminRole->syncPermissions($allPermissions);
        }

        // Limited permissions for manager/staff
        $limitedPermissions = Permission::where('guard_name', 'web')
            ->whereIn('name', ['dashboard_access', 'page_access'])
            ->pluck('name');

        $managerRole = Role::firstWhere('name', 'manager');
        if ($managerRole) {
            $managerRole->syncPermissions($limitedPermissions);
        }

        $staffRole = Role::firstWhere('name', 'staff');
        if ($staffRole) {
            $staffRole->syncPermissions($limitedPermissions);
        }
    }
}