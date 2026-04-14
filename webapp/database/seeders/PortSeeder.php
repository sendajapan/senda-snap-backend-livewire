<?php

namespace Database\Seeders;

use App\Models\Port;
use App\Models\User;
use Illuminate\Database\Seeder;

class PortSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/tbl_places.json');

        if (!file_exists($jsonPath)) {
            $this->command?->warn('tbl_places.json not found. Skipping PortSeeder JSON import.');

            return;
        }

        $content = file_get_contents($jsonPath);

        if ($content === false) {
            $this->command?->error('Unable to read tbl_places.json. Skipping PortSeeder JSON import.');

            return;
        }

        $places = json_decode($content, true);

        if (!is_array($places)) {
            $this->command?->error('Failed to decode tbl_places.json. Skipping PortSeeder JSON import.');

            return;
        }

        $validTypes = ['Auction', 'Yard', 'Local Port', 'Overseas Port'];

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($places as $place) {
            $name = isset($place['place_name']) ? trim((string) $place['place_name']) : '';
            $type = isset($place['place_type']) ? trim((string) $place['place_type']) : '';
            $address = isset($place['place_address']) ? (string) $place['place_address'] : '';

            // Basic validation
            if ($name === '' || $type === '' || !in_array($type, $validTypes, true)) {
                $skipped++;

                continue;
            }

            // Map created_by (use null if 0 or user does not exist)
            $createdById = isset($place['created_by']) ? (int) $place['created_by'] : 0;
            $createdBy = null;

            if ($createdById > 0) {
                $user = User::find($createdById);
                if ($user !== null) {
                    $createdBy = $user->id;
                }
            }

            $data = [
                'port_type' => $type,
                'port_address' => $address,
                'created_by' => $createdBy,
            ];

            $port = Port::updateOrCreate(
                ['port_name' => $name],
                $data,
            );

            if ($port->wasRecentlyCreated) {
                $imported++;
            } else {
                $updated++;
            }
        }

        $this->command?->info("Ports imported: {$imported}, updated: {$updated}, skipped: {$skipped}");
    }
}
