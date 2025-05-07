<?php

namespace Database\Factories;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $comments = [
            'Отличный музыкант! Очень профессионально и душевно.',
            'Прекрасное выступление, все гости были в восторге.',
            'Очень талантливый исполнитель, рекомендую!',
            'Отличная работа, все прошло на высшем уровне.',
            'Профессионал своего дела, спасибо за прекрасный вечер!',
            'Замечательный музыкант, создал отличную атмосферу.',
            'Очень довольны выступлением, все было просто супер!',
            'Талантливый исполнитель, всем рекомендую.',
            'Отличная музыка и профессионализм, спасибо!',
            'Прекрасное выступление, все прошло идеально.'
        ];

        return [
            'user_id' => User::factory(),
            'musician_id' => User::factory()->state(['role' => 'musician']),
            'rating' => $this->faker->numberBetween(4, 5),
            'comment' => $this->faker->randomElement($comments),
        ];
    }
}
