<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->text(100);

        return [
            'title' => $title,
            'slug' => str()->slug($title),
            'status' => fake()->randomElement(['active', 'completed']),

            'content' => fake()->realText(),

            'user_id' => (User::inRandomOrder()->first())->id
        ];
    }
}
