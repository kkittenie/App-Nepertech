<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            [
                'email' => 'admin@gmail.com'
            ],
            [
                'first_name' => 'Admin',
                'last_name' => 'NeperTech',

                'name' => 'Admin NeperTech',

                'username' => 'admin',

                'role' => 'admin',

                'password' => Hash::make('123'),
            ]
        );
    }
}