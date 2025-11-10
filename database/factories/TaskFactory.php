<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $workDate = fake()->dateTimeBetween('-1 month', '+1 month');

        return [
            'title' => fake()->sentence(4),
            'description' => fake()->paragraph(),
            'work_date' => $workDate,
            'work_time' => fake()->time('H:i'),
            'status' => fake()->randomElement(['pending', 'running', 'completed', 'cancelled']),
            'priority' => fake()->randomElement(['low', 'medium', 'high', 'urgent']),
            'vehicle_id' => Vehicle::factory(),
            'assigned_to' => User::factory(),
            'created_by' => User::factory(),
            'due_date' => fake()->optional()->dateTimeBetween($workDate, '+1 month'),
            'completed_at' => null,
        ];
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
