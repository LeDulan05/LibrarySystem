<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Check if admin already exists
        if (!User::where('email', 'admin@admin.com')->exists()) {
            User::create([
                'first_name' => 'Admin',
                'last_name' => 'User',
                'student_id' => 'ADMIN001',
                'course' => null,
                'email' => 'admin@admin.com',
                'password' => Hash::make('Password123'),
                'role' => 'admin',      // Add if column exists
                'status' => 'active',    // Add if column exists
            ]);
            
            $this->command->info('Admin user created successfully!');
            $this->command->info('Email: admin@admin.com');
            $this->command->info('Password: Password123');
        } else {
            $this->command->info('Admin user already exists!');
        }
    }
}