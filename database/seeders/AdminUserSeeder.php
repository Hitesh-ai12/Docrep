<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@docrep360.com'],
            [
                'name' => 'Admin',
                'username' => 'admin',
                'password' => Hash::make('Admin@123'),
                'role' => 'admin',
            ]
        );
    }
}
