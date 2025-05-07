<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            TestMusicianSeeder::class,
            UserSeeder::class,
            ReviewSeeder::class,
        ]);

        // Создаем администратора
        User::create([
            'name' => 'Admin User',
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=admin&backgroundColor=b6e3f4&backgroundType=solid',
        ]);

        // Создаем тестового пользователя
        User::create([
            'name' => 'Test User',
            'first_name' => 'Test',
            'last_name' => 'User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=user&backgroundColor=c0aede&backgroundType=solid',
        ]);

        // Создаем тестового музыканта
        User::create([
            'name' => 'Test Musician',
            'first_name' => 'Test',
            'last_name' => 'Musician',
            'email' => 'musician@example.com',
            'password' => bcrypt('password'),
            'role' => 'musician',
            'instrument' => 'piano',
            'education_level' => 'conservatory',
            'city' => 'Москва',
            'bio' => 'Профессиональный пианист с 10-летним опытом преподавания.',
            'gender' => 'male',
            'birth_date' => Carbon::now()->subYears(30),
            'avatar' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=musician&backgroundColor=ffdfbf&backgroundType=solid',
        ]);

        // Создаем дополнительных музыкантов
        $instruments = [
            'piano' => 'Пианино',
            'guitar' => 'Гитара',
            'violin' => 'Скрипка',
            'drums' => 'Ударные',
            'saxophone' => 'Саксофон',
            'flute' => 'Флейта',
            'cello' => 'Виолончель',
            'trumpet' => 'Труба',
            'bass' => 'Бас-гитара',
            'accordion' => 'Аккордеон'
        ];

        $cities = ['Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 'Казань'];
        $education = ['conservatory', 'music_college', 'music_school', 'self_taught'];

        // Создаем 20 музыкантов
        $backgroundColors = ['b6e3f4', 'c0aede', 'ffdfbf', 'ffd5dc', 'c1f0c1', 'fff4cc'];
        
        for ($i = 1; $i <= 20; $i++) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $firstName = $gender === 'male' ? 
                fake('ru_RU')->firstNameMale() : 
                fake('ru_RU')->firstNameFemale();
            $lastName = fake('ru_RU')->lastName();
            $name = $firstName . ' ' . $lastName;
            
            User::create([
                'name' => $name,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => "musician{$i}@example.com",
                'password' => bcrypt('password'),
                'role' => 'musician',
                'instrument' => array_rand($instruments),
                'education_level' => $education[array_rand($education)],
                'city' => $cities[array_rand($cities)],
                'bio' => fake('ru_RU')->realText(200),
                'gender' => $gender,
                'birth_date' => Carbon::now()->subYears(rand(20, 60)),
                'avatar' => "https://api.dicebear.com/7.x/avataaars/svg?seed={$name}&backgroundColor=" . $backgroundColors[array_rand($backgroundColors)] . "&backgroundType=solid",
            ]);
        }

        // Создаем 30 обычных пользователей
        for ($i = 1; $i <= 30; $i++) {
            $gender = rand(0, 1) ? 'male' : 'female';
            $firstName = $gender === 'male' ? 
                fake('ru_RU')->firstNameMale() : 
                fake('ru_RU')->firstNameFemale();
            $lastName = fake('ru_RU')->lastName();
            $name = $firstName . ' ' . $lastName;

            User::create([
                'name' => $name,
                'first_name' => $firstName,
                'last_name' => $lastName,
                'email' => "user{$i}@example.com",
                'password' => bcrypt('password'),
                'role' => 'user',
                'avatar' => "https://api.dicebear.com/7.x/avataaars/svg?seed={$name}&backgroundColor=" . $backgroundColors[array_rand($backgroundColors)] . "&backgroundType=solid",
            ]);
        }

        // Генерируем аватары для всех музыкантов
        $musicians = User::where('role', 'musician')->get();
        foreach ($musicians as $musician) {
            if (!$musician->avatar) {
                // Генерируем случайный аватар с фоном
                $avatarUrl = "https://api.dicebear.com/7.x/avataaars/svg?seed=" . urlencode($musician->name) . "&backgroundColor=" . $backgroundColors[array_rand($backgroundColors)];
                $avatarContent = file_get_contents($avatarUrl);
                
                // Сохраняем аватар
                $avatarPath = 'avatars/' . $musician->id . '.svg';
                Storage::disk('public')->put($avatarPath, $avatarContent);
                
                // Обновляем пользователя
                $musician->update(['avatar' => $avatarPath]);
            }
        }
    }
}
