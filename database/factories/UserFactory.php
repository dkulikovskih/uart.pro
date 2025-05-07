<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
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

        $educationLevels = [
            'conservatory' => 'Консерватория',
            'music_college' => 'Музыкальное училище',
            'music_school' => 'Музыкальная школа',
            'self_taught' => 'Самоучка'
        ];

        $cities = [
            'Москва', 'Санкт-Петербург', 'Новосибирск', 'Екатеринбург', 
            'Казань', 'Нижний Новгород', 'Челябинск', 'Омск', 'Самара', 'Ростов-на-Дону'
        ];

        $isMusician = $this->faker->boolean(70); // 70% шанс быть музыкантом
        $firstName = $this->faker->firstName();
        $lastName = $this->faker->lastName();

        return [
            'first_name' => $firstName,
            'last_name' => $lastName,
            'name' => $firstName . ' ' . $lastName,
            'email' => $this->faker->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => Hash::make('password'),
            'remember_token' => Str::random(10),
            'role' => $isMusician ? 'musician' : 'user',
            'avatar' => null,
            'instrument' => $isMusician ? $this->faker->randomElement(array_keys($instruments)) : null,
            'education_level' => $isMusician ? $this->faker->randomElement(array_keys($educationLevels)) : null,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'birth_date' => $this->faker->dateTimeBetween('-60 years', '-18 years'),
            'city' => $this->faker->randomElement($cities),
            'bio' => $isMusician ? $this->faker->paragraph() : null,
            'instruments' => $isMusician ? $this->faker->randomElements(array_keys($instruments), $this->faker->numberBetween(1, 3)) : null,
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }
}
