<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ShippingCompany>
 */
class ShippingCompanyFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'company_name' => fake()->company(),
            'company_type' => fake()->randomElement(['Transporter', 'Shipping Line', 'Workshop', 'PROVIDER', 'EXPENSE', 'COURIER']),
            'company_status' => fake()->randomElement(['Active', 'Inactive']),
            'company_name_jp' => fake()->optional()->company(),
            'per_m3' => fake()->optional()->numberBetween(100, 10000),
            'per_container' => fake()->optional()->numberBetween(500, 50000),
            'zip' => fake()->optional()->postcode(),
            'country_name' => fake()->country(),
            'state' => fake()->optional()->state(),
            'city' => fake()->city(),
            'address' => fake()->optional()->streetAddress(),
        ];
    }
}
