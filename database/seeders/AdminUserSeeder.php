<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'creamoshojasdevida@gmail.com'],
            [
                'name' => 'Administrador',
                'password' => \Illuminate\Support\Facades\Hash::make('43816727sAr@*'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );
    }
}
