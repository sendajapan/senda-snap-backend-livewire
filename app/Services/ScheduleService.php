<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Schedule;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ScheduleService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Schedule::with([
            'carrier1',
            'carrier2',
            'carrier3',
            'startPort',
            'endPort',
            'stopovers.port',
            'addedBy',
        ]);

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('vessel_name', 'like', "%{$search}%")
                    ->orWhere('voyage_no', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['vessel_name'])) {
            $query->where('vessel_name', 'like', "%{$filters['vessel_name']}%");
        }

        if (! empty($filters['voyage_no'])) {
            $query->where('voyage_no', 'like', "%{$filters['voyage_no']}%");
        }

        if (! empty($filters['carrier_id'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('carrier_1_id', $filters['carrier_id'])
                    ->orWhere('carrier_2_id', $filters['carrier_id'])
                    ->orWhere('carrier_3_id', $filters['carrier_id']);
            });
        }

        if (! empty($filters['start_port_id'])) {
            $query->where('start_port_id', $filters['start_port_id']);
        }

        if (! empty($filters['end_port_id'])) {
            $query->where('end_port_id', $filters['end_port_id']);
        }

        return $query->latest('created_at')->paginate($perPage);
    }

    public function getById(int $id): Schedule
    {
        return Schedule::with([
            'carrier1',
            'carrier2',
            'carrier3',
            'startPort',
            'endPort',
            'stopovers.port',
            'addedBy',
        ])->findOrFail($id);
    }

    public function create(array $data, int $userId): Schedule
    {
        $schedule = Schedule::create([
            'vessel_name' => $data['vessel_name'],
            'voyage_no' => $data['voyage_no'],
            'carrier_1_id' => $data['carrier_1_id'] ?? null,
            'carrier_2_id' => $data['carrier_2_id'] ?? null,
            'carrier_3_id' => $data['carrier_3_id'] ?? null,
            'start_port_id' => $data['start_port_id'],
            'end_port_id' => $data['end_port_id'],
            'eta' => $data['eta'],
            'status' => $data['status'] ?? 'Waiting',
            'comment' => $data['comment'] ?? null,
            'added_by' => $userId,
        ]);

        $schedule->load([
            'carrier1',
            'carrier2',
            'carrier3',
            'startPort',
            'endPort',
            'stopovers.port',
            'addedBy',
        ]);

        return $schedule;
    }

    public function update(Schedule $schedule, array $data): Schedule
    {
        $schedule->update(array_filter([
            'vessel_name' => $data['vessel_name'] ?? null,
            'voyage_no' => $data['voyage_no'] ?? null,
            'carrier_1_id' => $data['carrier_1_id'] ?? null,
            'carrier_2_id' => $data['carrier_2_id'] ?? null,
            'carrier_3_id' => $data['carrier_3_id'] ?? null,
            'start_port_id' => $data['start_port_id'] ?? null,
            'end_port_id' => $data['end_port_id'] ?? null,
            'eta' => $data['eta'] ?? null,
            'status' => $data['status'] ?? null,
            'comment' => $data['comment'] ?? null,
        ], fn ($value) => $value !== null));

        $schedule->load([
            'carrier1',
            'carrier2',
            'carrier3',
            'startPort',
            'endPort',
            'stopovers.port',
            'addedBy',
        ]);

        return $schedule;
    }

    public function delete(Schedule $schedule): bool
    {
        return (bool) $schedule->delete();
    }
}
