<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'name' => 'Иван Иванов',
                'first_name' => 'Иван',
                'last_name' => 'Иванов',
                'email' => 'user1@test.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=ivan&backgroundColor=c1f0c1&backgroundType=solid',
            ],
            [
                'name' => 'Елена Смирнова',
                'first_name' => 'Елена',
                'last_name' => 'Смирнова',
                'email' => 'user2@test.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=elena&backgroundColor=ffd5dc&backgroundType=solid',
            ],
            [
                'name' => 'Алексей Петров',
                'first_name' => 'Алексей',
                'last_name' => 'Петров',
                'email' => 'user3@test.com',
                'password' => Hash::make('password'),
                'role' => 'user',
                'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=alexey&backgroundColor=b6e3f4&backgroundType=solid',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}
