<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role; // Import the Role model if needed
use App\Models\User;


class RoleSeede extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        // Define your default roles
        $roles = ['admin', 'cashier', 'staff'];

        foreach ($roles as $role) {
            Role::firstOrCreate(['name' => $role]);
        }

        

        // Assign a default role to the first user (optional)
        $user = User::first();
        if ($user) {
            $user->assignRole('admin');
        }
    }
}
