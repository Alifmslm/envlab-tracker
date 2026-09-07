<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Seed the application's default users.
     *
     * Roles (see Section 5, User Roles & Access Control):
     * - admin : Lab Head. Full access: create, view, update, delete
     *           all sample data + full statistics dashboard.
     * - staff : Analyst. View sample list & dashboard; update only
     *           analysis status and testing notes. Cannot create/delete.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Lab Head',
                'email' => 'admin@example.com',
                'password' => 'password',
                'role' => User::ROLE_ADMIN,
            ],
            [
                'name' => 'Analyst',
                'email' => 'staff@example.com',
                'password' => 'password',
                'role' => User::ROLE_STAFF,
            ],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                $user,
            );
        }
    }
}
