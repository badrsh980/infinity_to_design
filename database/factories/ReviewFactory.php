<?php

namespace Database\Factories;

use App\Models\Gig;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->realText(100),
            'reply' => fake()->randomElement([null, fake()->realText(50)]),
            'user_id' => (User::inRandomOrder()->first())->id,
            'gig_id' => (Gig::inRandomOrder()->first())->id
        ];
    }
}
