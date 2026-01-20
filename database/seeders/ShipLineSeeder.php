<?php

namespace Database\Seeders;

use App\Models\ShipLine;
use Illuminate\Database\Seeder;

class ShipLineSeeder extends Seeder
{
    public function run(): void
    {
        $jsonPath = database_path('seeders/tbl_ship_line.json');

        if (! file_exists($jsonPath)) {
            $this->command?->warn('tbl_ship_line.json not found. Skipping ShipLineSeeder JSON import.');

            return;
        }

        $content = file_get_contents($jsonPath);

        if ($content === false) {
            $this->command?->error('Unable to read tbl_ship_line.json. Skipping ShipLineSeeder JSON import.');

            return;
        }

        $shipLines = json_decode($content, true);

        if (! is_array($shipLines)) {
            $this->command?->error('Failed to decode tbl_ship_line.json. Skipping ShipLineSeeder JSON import.');

            return;
        }

        $imported = 0;
        $updated = 0;
        $skipped = 0;

        foreach ($shipLines as $line) {
            $lineName = isset($line['line_name']) ? trim((string) $line['line_name']) : '';
            $active = isset($line['Active']) ? (string) $line['Active'] : '0';

            // Basic validation
            if ($lineName === '') {
                $skipped++;

                continue;
            }

            // Map Active ("1" or "0") to status ("Active" or "Inactive")
            $status = ($active === '1') ? 'Active' : 'Inactive';

            $data = [
                'status' => $status,
            ];

            $shipLine = ShipLine::updateOrCreate(
                ['line_name' => $lineName],
                $data,
            );

            if ($shipLine->wasRecentlyCreated) {
                $imported++;
            } else {
                $updated++;
            }
        }

        $this->command?->info("Ship lines imported: {$imported}, updated: {$updated}, skipped: {$skipped}");
    }
}
