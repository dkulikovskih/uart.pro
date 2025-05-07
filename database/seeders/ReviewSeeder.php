<?php

namespace Database\Seeders;

use App\Models\Review;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReviewSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $musicians = User::where('role', 'musician')->get();
        $users = User::where('role', 'user')->get();

        foreach ($musicians as $musician) {
            // Создаем 3-5 отзывов для каждого музыканта
            $reviewCount = rand(3, 5);
            
            for ($i = 0; $i < $reviewCount; $i++) {
                Review::factory()->create([
                    'musician_id' => $musician->id,
                    'user_id' => $users->random()->id,
                ]);
            }
        }
    }
}
