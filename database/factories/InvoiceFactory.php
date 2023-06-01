<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        $type = fake()->randomElement(['order', 'refund', 'withdraw']);

        return [
            'status' => fake()->randomElement(['pending', 'completed']),
            'type' => $type,
            'payment_method' => fake()->randomElement(['paypal', 'bank']),
            'details' => null,
            'amount' => fake()->randomFloat(2, 10, 200),
            'order_id' => ($type == 'order') ? (Order::inRandomOrder()->first())->id : null,
            'user_id' => (User::inRandomOrder()->first())->id,
        ];
    }
}
