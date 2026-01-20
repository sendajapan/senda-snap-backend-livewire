<?php

namespace Database\Factories;

use App\Models\Port;
use App\Models\ShipLine;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startPort = Port::where('port_type', 'Local Port')->inRandomOrder()->first() ?? Port::factory()->create(['port_type' => 'Local Port']);
        $endPort = Port::where('port_type', 'Local Port')->where('id', '!=', $startPort->id)->inRandomOrder()->first() ?? Port::factory()->create(['port_type' => 'Local Port']);

        return [
            'vessel_name' => fake()->company().' '.fake()->randomElement(['Vessel', 'Ship', 'Freighter', 'Container Ship']),
            'voyage_no' => 'V'.fake()->numerify('####'),
            'carrier_1_id' => ShipLine::where('status', 'Active')->inRandomOrder()->first()?->id,
            'carrier_2_id' => ShipLine::where('status', 'Active')->inRandomOrder()->first()?->id,
            'carrier_3_id' => ShipLine::where('status', 'Active')->inRandomOrder()->first()?->id,
            'start_port_id' => $startPort->id,
            'end_port_id' => $endPort->id,
            'eta' => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d H:i'),
            'status' => fake()->randomElement(['Waiting', 'Loading', 'On-Sea', 'Stop Over', 'Destination']),
            'comment' => fake()->optional()->sentence(),
            'added_by' => User::factory(),
        ];
    }
}
