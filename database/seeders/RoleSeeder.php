<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $adminRole = Role::create([
            'name' => 'admin',
            'display_name' => 'Administrator',
            'description' => 'Full system administrator with all permissions',
            'is_active' => true,
        ]);

        // Create User Role
        $userRole = Role::create([
            'name' => 'user',
            'display_name' => 'User',
            'description' => 'Regular user with limited permissions',
            'is_active' => true,
        ]);

        // Create Editor Role
        $editorRole = Role::create([
            'name' => 'editor',
            'display_name' => 'Editor',
            'description' => 'Content editor with page management permissions',
            'is_active' => true,
        ]);

        // Assign all permissions to admin role
        $allPermissions = Permission::all();
        $adminRole->permissions()->attach($allPermissions->pluck('id'));

        // Assign limited permissions to user role
        $userPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'pages.view',
        ])->get();
        $userRole->permissions()->attach($userPermissions->pluck('id'));

        // Assign content permissions to editor role
        $editorPermissions = Permission::whereIn('name', [
            'dashboard.view',
            'pages.view',
            'pages.create',
            'pages.edit',
            'pages.publish',
            'page_sections.view',
            'page_sections.create',
            'page_sections.edit',
            'contacts.view',
            'contacts.reply',
        ])->get();
        $editorRole->permissions()->attach($editorPermissions->pluck('id'));
    }
}
