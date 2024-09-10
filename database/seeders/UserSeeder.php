<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::insert([
            [
                'name' => 'Illya',
                'email' => 'illya.kolom01@gmail.com',
                'role' => 'admin',
                'password' => '$2y$12$zdQ8n3kMClfwTsPkZmMTSu4Wm8IMgC4Ajjle2M8gDW8tHqMRjOpiK'
                ],
            [
                'name' => 'User',
                'email' => 'user@gmail.com',
                'role' => 'user',
                'password' => '$2y$12$zdQ8n3kMClfwTsPkZmMTSu4Wm8IMgC4Ajjle2M8gDW8tHqMRjOpiK'
            ],
        ]);
    }
}
