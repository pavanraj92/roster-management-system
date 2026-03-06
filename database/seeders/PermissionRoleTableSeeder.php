<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PermissionRoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin gets all permissions
        $adminRole = Role::findByName('admin', 'web');
        $allPermissions = Permission::where('guard_name', 'web')->pluck('id');
        $adminRole->syncPermissions($allPermissions);

        // Define specific permissions for other roles
        $limitedPermissions = Permission::where('guard_name', 'web')
            ->whereIn('name', ['dashboard_access', 'page_access'])
            ->pluck('id');

        // Manager gets limited permissions
        $managerRole = Role::findByName('manager', 'web');
        $managerRole->syncPermissions($limitedPermissions);

        // Staff gets limited permissions
        $staffRole = Role::findByName('staff', 'web');
        $staffRole->syncPermissions($limitedPermissions);
    }
}
