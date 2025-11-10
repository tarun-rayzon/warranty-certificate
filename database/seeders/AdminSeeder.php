<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        // Create admin user
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@rayzon.com',
            'mobile' => '1212121212',
            'password' => bcrypt('12345678'), // Change to a secure password
        ]);

        // Assign admin role
        $adminRole = Role::where('name', 'admin')->first();
        $admin->assignRole($adminRole);
    }
}
