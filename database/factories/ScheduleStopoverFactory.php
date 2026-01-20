<?php

namespace Database\Factories;

use App\Models\Port;
use App\Models\Schedule;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ScheduleStopover>
 */
class ScheduleStopoverFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $port = Port::whereIn('port_type', ['Overseas Port', 'Local Port'])->inRandomOrder()->first() ?? Port::factory()->create(['port_type' => fake()->randomElement(['Overseas Port', 'Local Port'])]);

        $eta = fake()->dateTimeBetween('now', '+2 months');
        $etd = fake()->dateTimeBetween($eta, '+1 week');

        return [
            'schedule_id' => Schedule::factory(),
            'port_id' => $port->id,
            'stopover_eta' => $eta,
            'stopover_etd' => $etd,
            'status' => fake()->randomElement(['Waiting', 'Loading', 'On-Sea', 'Stop Over', 'Destination']),
            'added_by' => User::factory(),
        ];
    }
}
