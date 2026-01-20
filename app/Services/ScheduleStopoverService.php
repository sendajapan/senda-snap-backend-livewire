<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ScheduleStopover;

class ScheduleStopoverService
{
    public function create(array $data, int $userId): ScheduleStopover
    {
        $stopover = ScheduleStopover::create([
            'schedule_id' => $data['schedule_id'],
            'port_id' => $data['port_id'],
            'stopover_eta' => $data['stopover_eta'] ?? null,
            'stopover_etd' => $data['stopover_etd'] ?? null,
            'status' => $data['status'] ?? 'Waiting',
            'added_by' => $userId,
        ]);

        $stopover->load(['schedule', 'port', 'addedBy']);

        return $stopover;
    }

    public function update(ScheduleStopover $stopover, array $data): ScheduleStopover
    {
        $stopover->update(array_filter([
            'port_id' => $data['port_id'] ?? null,
            'stopover_eta' => $data['stopover_eta'] ?? null,
            'stopover_etd' => $data['stopover_etd'] ?? null,
            'status' => $data['status'] ?? null,
        ], fn ($value) => $value !== null));

        $stopover->load(['schedule', 'port', 'addedBy']);

        return $stopover;
    }

    public function delete(ScheduleStopover $stopover): bool
    {
        return (bool) $stopover->delete();
    }
}
