<?php

namespace Database\Factories;

use App\Models\Gig;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Extra>
 */
class ExtraFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $change = fake()->randomElement(['no', 'yes']);
        return [
            'title' => 'تطوير 1 ( واجهتين)',
            'price' => fake()->randomFloat(2, 10, 100),
            'change_gig_date' => $change,
            'extra_time' => $change == 'yes' ? rand(1, 15) : 0,

            'gig_id' => (Gig::inRandomOrder()->first())->id
        ];
    }
}
