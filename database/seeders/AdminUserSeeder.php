<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        $adminUser = User::firstOrCreate([
            'name' => 'Admin User',
            'email' => 'umeshl@whitelabeliq.com',
        ], [
            'password' => Hash::make('Umesh@123'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Assign admin role
        $adminRole = Role::where('name', 'admin')->first();
        if ($adminRole) {
            $adminUser->roles()->syncWithoutDetaching([$adminRole->id]);
        }

        // Create a regular user for testing
        $regularUser = User::firstOrCreate([
            'name' => 'Regular User',
            'email' => 'user@example.com',
        ], [
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_active' => true,
        ]);

        // Assign user role
        $userRole = Role::where('name', 'user')->first();
        if ($userRole) {
            $regularUser->roles()->syncWithoutDetaching([$userRole->id]);
        }
    }
}
