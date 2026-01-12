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
        \App\Models\User::create([
            'name' => 'Administrador',
            'email' => 'creamoshojasdevida@gmail.com',
            'password' => bcrypt('43816727sAr@*'),
            'role' => 'admin',
        ]);
    }
}
