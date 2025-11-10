<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'serial_number' => fake()->unique()->bothify('VH####??'),
            'make' => fake()->randomElement(['Toyota', 'Honda', 'Nissan', 'Mazda', 'Subaru', 'Mitsubishi']),
            'model' => fake()->randomElement(['Camry', 'Civic', 'Altima', 'CX-5', 'Outback', 'Lancer']),
            'chassis_model' => fake()->bothify('??##'),
            'cc' => fake()->randomElement([1500, 1800, 2000, 2400, 2500, 3000]),
            'year' => fake()->year(),
            'color' => fake()->randomElement(['White', 'Black', 'Silver', 'Red', 'Blue', 'Gray']),
            'vehicle_buy_date' => fake()->dateTimeBetween('-1 year', 'now'),
            'auction_ship_number' => fake()->bothify('AS###'),
            'net_weight' => fake()->randomFloat(2, 1000, 2000),
            'area' => fake()->randomElement(['Tokyo', 'Osaka', 'Nagoya', 'Yokohama', 'Kobe']),
            'length' => fake()->randomFloat(2, 4.0, 5.5),
            'width' => fake()->randomFloat(2, 1.6, 2.0),
            'height' => fake()->randomFloat(2, 1.3, 1.7),
            'plate_number' => fake()->optional()->bothify('???-###'),
            'buying_price' => fake()->randomFloat(2, 15000, 40000),
            'expected_yard_date' => fake()->dateTimeBetween('now', '+2 months'),
            'rikso_from' => fake()->optional()->city(),
            'rikso_to' => fake()->optional()->city(),
            'rikso_cost' => fake()->optional()->randomFloat(2, 300, 800),
            'rikso_company' => fake()->optional()->company(),
            'auction_sheet' => fake()->optional()->word(),
            'tohon_copy' => fake()->optional()->word(),
            'status' => fake()->randomElement(['pending', 'in_yard', 'ready', 'sold']),
            'created_by' => User::factory(),
        ];
    }
}
