<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\VehiclePhoto>
 */
class VehiclePhotoFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'vehicle_id' => Vehicle::factory(),
            'photo_path' => 'vehicles/'.fake()->uuid().'.jpg',
            'photo_type' => fake()->randomElement(['exterior', 'interior', 'engine', 'document', 'other']),
            'uploaded_by' => User::factory(),
        ];
    }
}
