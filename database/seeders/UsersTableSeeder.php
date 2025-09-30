<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'name' => 'super admin',
            'email' => 'super_admin@app.com',
            'password' => bcrypt('12345678'),
        ]);

        $user->addRole('super_admin');

        // Get all existing permissions
        $allPermissions = Permission::pluck('name')->toArray();

        // Assign all permissions to the 'Admin' role
        $user->syncPermissions($allPermissions);
    }
}
