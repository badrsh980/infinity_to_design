<?php

namespace Database\Factories;

use App\Models\Chat;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ChatMessage>
 */
class ChatMessageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => fake()->realText(50),
            'readed' => fake()->randomElement(['yes', 'no']),
            'chat_id' => (Chat::inRandomOrder()->first())->id,
            'user_id' => (User::inRandomOrder()->first())->id,
        ];
    }
}
