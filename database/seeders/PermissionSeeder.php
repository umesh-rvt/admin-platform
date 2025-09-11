<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            // User Management
            ['name' => 'users.view', 'display_name' => 'View Users', 'module' => 'users', 'description' => 'Can view users list'],
            ['name' => 'users.create', 'display_name' => 'Create Users', 'module' => 'users', 'description' => 'Can create new users'],
            ['name' => 'users.edit', 'display_name' => 'Edit Users', 'module' => 'users', 'description' => 'Can edit existing users'],
            ['name' => 'users.delete', 'display_name' => 'Delete Users', 'module' => 'users', 'description' => 'Can delete users'],
            ['name' => 'users.assign_roles', 'display_name' => 'Assign Roles', 'module' => 'users', 'description' => 'Can assign roles to users'],

            // Role Management
            ['name' => 'roles.view', 'display_name' => 'View Roles', 'module' => 'roles', 'description' => 'Can view roles list'],
            ['name' => 'roles.create', 'display_name' => 'Create Roles', 'module' => 'roles', 'description' => 'Can create new roles'],
            ['name' => 'roles.edit', 'display_name' => 'Edit Roles', 'module' => 'roles', 'description' => 'Can edit existing roles'],
            ['name' => 'roles.delete', 'display_name' => 'Delete Roles', 'module' => 'roles', 'description' => 'Can delete roles'],
            ['name' => 'roles.assign_permissions', 'display_name' => 'Assign Permissions', 'module' => 'roles', 'description' => 'Can assign permissions to roles'],

            // Permission Management
            ['name' => 'permissions.view', 'display_name' => 'View Permissions', 'module' => 'permissions', 'description' => 'Can view permissions list'],
            ['name' => 'permissions.create', 'display_name' => 'Create Permissions', 'module' => 'permissions', 'description' => 'Can create new permissions'],
            ['name' => 'permissions.edit', 'display_name' => 'Edit Permissions', 'module' => 'permissions', 'description' => 'Can edit existing permissions'],
            ['name' => 'permissions.delete', 'display_name' => 'Delete Permissions', 'module' => 'permissions', 'description' => 'Can delete permissions'],

            // Category Management
            ['name' => 'categories.view', 'display_name' => 'View Categories', 'module' => 'categories', 'description' => 'Can view categories list'],
            ['name' => 'categories.create', 'display_name' => 'Create Categories', 'module' => 'categories', 'description' => 'Can create new categories'],
            ['name' => 'categories.edit', 'display_name' => 'Edit Categories', 'module' => 'categories', 'description' => 'Can edit existing categories'],
            ['name' => 'categories.delete', 'display_name' => 'Delete Categories', 'module' => 'categories', 'description' => 'Can delete categories'],

            // Page Management
            ['name' => 'pages.view', 'display_name' => 'View Pages', 'module' => 'pages', 'description' => 'Can view pages list'],
            ['name' => 'pages.create', 'display_name' => 'Create Pages', 'module' => 'pages', 'description' => 'Can create new pages'],
            ['name' => 'pages.edit', 'display_name' => 'Edit Pages', 'module' => 'pages', 'description' => 'Can edit existing pages'],
            ['name' => 'pages.delete', 'display_name' => 'Delete Pages', 'module' => 'pages', 'description' => 'Can delete pages'],
            ['name' => 'pages.publish', 'display_name' => 'Publish Pages', 'module' => 'pages', 'description' => 'Can publish/unpublish pages'],

            // Page Sections
            ['name' => 'page_sections.view', 'display_name' => 'View Page Sections', 'module' => 'page_sections', 'description' => 'Can view page sections'],
            ['name' => 'page_sections.create', 'display_name' => 'Create Page Sections', 'module' => 'page_sections', 'description' => 'Can create new page sections'],
            ['name' => 'page_sections.edit', 'display_name' => 'Edit Page Sections', 'module' => 'page_sections', 'description' => 'Can edit existing page sections'],
            ['name' => 'page_sections.delete', 'display_name' => 'Delete Page Sections', 'module' => 'page_sections', 'description' => 'Can delete page sections'],

            // Contact Management
            ['name' => 'contacts.view', 'display_name' => 'View Contact Submissions', 'module' => 'contacts', 'description' => 'Can view contact form submissions'],
            ['name' => 'contacts.reply', 'display_name' => 'Reply to Contacts', 'module' => 'contacts', 'description' => 'Can reply to contact submissions'],
            ['name' => 'contacts.delete', 'display_name' => 'Delete Contacts', 'module' => 'contacts', 'description' => 'Can delete contact submissions'],

            // Settings Management
            ['name' => 'settings.view', 'display_name' => 'View Settings', 'module' => 'settings', 'description' => 'Can view system settings'],
            ['name' => 'settings.edit', 'display_name' => 'Edit Settings', 'module' => 'settings', 'description' => 'Can edit system settings'],

            // Activity Logs
            ['name' => 'activity_logs.view', 'display_name' => 'View Activity Logs', 'module' => 'activity_logs', 'description' => 'Can view activity logs'],

            // Dashboard
            ['name' => 'dashboard.view', 'display_name' => 'View Dashboard', 'module' => 'dashboard', 'description' => 'Can view admin dashboard'],
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission['name']],
                $permission
            );
        }
    }
}
