<?php

namespace Database\Factories;

use App\Models\User;
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
            'created_by' => User::factory(),
            'due_date' => fake()->optional()->dateTimeBetween($workDate, '+1 month'),
            'completed_at' => null,
        ];
    }

    /**
     * Configure the model factory.
     */
    public function configure(): static
    {
        return $this->afterCreating(function ($task) {
            // Assign 1-3 random users to the task
            $users = User::inRandomOrder()->take(fake()->numberBetween(1, 3))->pluck('id');
            if ($users->isEmpty()) {
                // If no users exist, create some
                $users = User::factory()->count(2)->create()->pluck('id');
            }
            $task->assignedUsers()->attach($users);
        });
    }

    public function completed(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }
}
