<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'status' => fake()->randomElement(['pending', 'active', 'inactive']),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->freeEmail(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi',
            'name' => fake()->name(),
            'address' => fake()->streetAddress(),
            'state' => fake()->state(),
            'city' => fake()->city(),
            'post_code' => fake()->postcode(),
            'country' => fake()->countryCode(),
            'thumbnail' => 'default-thumbnail.png',
            'description' => fake()->realText(500),
            'last_seen' => fake()->dateTime(),
            'response_time' => '24 Hours',
            'balance' => fake()->randomFloat(2, 5, 2000),
            'email_verified_at' => null,
            'token' => sha1(uniqid()),
            'specialization' => fake()->randomElement(["Web Designer", 'Web Developper', 'Graphic Designer', 'Translator']),
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
