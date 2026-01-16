<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Port>
 */
class PortFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'port_name' => fake()->city().' Port',
            'port_type' => fake()->randomElement(['Auction', 'Yard', 'Local Port', 'Overseas Port']),
            'port_address' => fake()->address(),
        ];
    }
}
