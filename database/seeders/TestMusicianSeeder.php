<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestMusicianSeeder extends Seeder
{
    public function run(): void
    {
        $musicians = [
            [
                'name' => 'Анна Петрова',
                'first_name' => 'Анна',
                'last_name' => 'Петрова',
                'email' => 'anna@test.com',
                'password' => Hash::make('password'),
                'role' => 'musician',
                'instrument' => 'piano',
                'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=anna&backgroundColor=ffd5dc&backgroundType=solid',
                'education_level' => 'conservatory',
                'bio' => 'Профессиональная пианистка с 15-летним опытом. Окончила консерваторию с отличием.',
                'city' => 'Москва',
                'gender' => 'female',
                'birth_date' => '1990-05-15',
            ],
            [
                'name' => 'Иван Смирнов',
                'first_name' => 'Иван',
                'last_name' => 'Смирнов',
                'email' => 'ivan@test.com',
                'password' => Hash::make('password'),
                'role' => 'musician',
                'instrument' => 'guitar',
                'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=ivan&backgroundColor=b6e3f4&backgroundType=solid',
                'education_level' => 'music_college',
                'bio' => 'Гитарист с 10-летним стажем. Играю в различных жанрах от классики до рока.',
                'city' => 'Санкт-Петербург',
                'gender' => 'male',
                'birth_date' => '1988-03-20',
            ],
            [
                'name' => 'Мария Иванова',
                'first_name' => 'Мария',
                'last_name' => 'Иванова',
                'email' => 'maria@test.com',
                'password' => Hash::make('password'),
                'role' => 'musician',
                'instrument' => 'violin',
                'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=maria&backgroundColor=ffdfbf&backgroundType=solid',
                'education_level' => 'conservatory',
                'bio' => 'Скрипачка с консерваторским образованием. Участница международных конкурсов.',
                'city' => 'Казань',
                'gender' => 'female',
                'birth_date' => '1992-07-10',
            ],
        ];

        foreach ($musicians as $musician) {
            User::create($musician);
        }
    }
} 