<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $timestamp = now();
        $createDate =  date('Y-m-d H:i:s');

        $permissions = [
            [
                'name'              => 'dashboard_access',
                'display_name'      => 'Menu Access',
                'guard_name'        => 'web',
                'group_name'        => 'dashboard',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'role_access',
                'display_name'      => 'Menu Access',
                'guard_name'        => 'web',
                'group_name'        => 'roles',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'role_list',
                'display_name'      => 'List Roles',
                'guard_name'        => 'web',
                'group_name'        => 'roles',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'role_create',
                'display_name'      => 'Create Role',
                'guard_name'        => 'web',
                'group_name'        => 'roles',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'role_edit',
                'display_name'      => 'Edit Role',
                'guard_name'        => 'web',
                'group_name'        => 'roles',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'role_delete',
                'display_name'      => 'Delete Role',
                'guard_name'        => 'web',
                'group_name'        => 'roles',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'role_show',
                'display_name'      => 'View Role',
                'guard_name'        => 'web',
                'group_name'        => 'roles',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'user_access',
                'display_name'      => 'Menu Access',
                'guard_name'        => 'web',
                'group_name'        => 'user',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'user_list',
                'display_name'      => 'List Users',
                'guard_name'        => 'web',
                'group_name'        => 'user',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'user_create',
                'display_name'      => 'Create User',
                'guard_name'        => 'web',
                'group_name'        => 'user',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'user_edit',
                'display_name'      => 'Edit User',
                'guard_name'        => 'web',
                'group_name'        => 'user',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'user_delete',
                'display_name'      => 'Delete User',
                'guard_name'        => 'web',
                'group_name'        => 'user',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'user_show',
                'display_name'      => 'View User',
                'guard_name'        => 'web',
                'group_name'        => 'user',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            // Pages
            [
                'name'              => 'page_access',
                'display_name'      => 'Menu Access',
                'guard_name'        => 'web',
                'group_name'        => 'pages',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'page_list',
                'display_name'      => 'List Pages',
                'guard_name'        => 'web',
                'group_name'        => 'pages',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'page_create',
                'display_name'      => 'Create Page',
                'guard_name'        => 'web',
                'group_name'        => 'pages',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'page_edit',
                'display_name'      => 'Edit Page',
                'guard_name'        => 'web',
                'group_name'        => 'pages',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'page_delete',
                'display_name'      => 'Delete Page',
                'guard_name'        => 'web',
                'group_name'        => 'pages',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'page_show',
                'display_name'      => 'View Page',
                'guard_name'        => 'web',
                'group_name'        => 'pages',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'page_toggle_status',
                'display_name'      => 'Toggle Page Status',
                'guard_name'        => 'web',
                'group_name'        => 'pages',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],

            // Email Templates
            [
                'name'              => 'email_template_access',
                'display_name'      => 'Menu Access',
                'guard_name'        => 'web',
                'group_name'        => 'email_templates',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'email_template_list',
                'display_name'      => 'List Email Templates',
                'guard_name'        => 'web',
                'group_name'        => 'email_templates',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'email_template_create',
                'display_name'      => 'Create Email Template',
                'guard_name'        => 'web',
                'group_name'        => 'email_templates',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'email_template_edit',
                'display_name'      => 'Edit Email Template',
                'guard_name'        => 'web',
                'group_name'        => 'email_templates',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'email_template_delete',
                'display_name'      => 'Delete Email Template',
                'guard_name'        => 'web',
                'group_name'        => 'email_templates',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'email_template_show',
                'display_name'      => 'View Email Template',
                'guard_name'        => 'web',
                'group_name'        => 'email_templates',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'email_template_toggle_status',
                'display_name'      => 'Toggle Email Template Status',
                'guard_name'        => 'web',
                'group_name'        => 'email_templates',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],

            // Settings & related
            [
                'name'              => 'setting_access',
                'display_name'      => 'Menu Access',
                'guard_name'        => 'web',
                'group_name'        => 'settings',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'setting_update',
                'display_name'      => 'Update Settings',
                'guard_name'        => 'web',
                'group_name'        => 'settings',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],

            // Banners (under settings)
            [
                'name'              => 'banner_list',
                'display_name'      => 'List Banners',
                'guard_name'        => 'web',
                'group_name'        => 'banners',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'banner_create',
                'display_name'      => 'Create Banner',
                'guard_name'        => 'web',
                'group_name'        => 'banners',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'banner_edit',
                'display_name'      => 'Edit Banner',
                'guard_name'        => 'web',
                'group_name'        => 'banners',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'banner_delete',
                'display_name'      => 'Delete Banner',
                'guard_name'        => 'web',
                'group_name'        => 'banners',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'banner_toggle_status',
                'display_name'      => 'Toggle Banner Status',
                'guard_name'        => 'web',
                'group_name'        => 'banners',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],

            // Visibility settings
            [
                'name'              => 'visibility_view',
                'display_name'      => 'View Visibility Settings',
                'guard_name'        => 'web',
                'group_name'        => 'visibility',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
            [
                'name'              => 'visibility_update',
                'display_name'      => 'Update Visibility Settings',
                'guard_name'        => 'web',
                'group_name'        => 'visibility',
                'created_at'        => $createDate,
                'updated_at'        => $timestamp,
            ],
        ];

        Permission::upsert(
            $permissions,
            ['name', 'guard_name'], // unique columns
            ['display_name', 'group_name', 'updated_at'] // columns to update
        );
    }
}
