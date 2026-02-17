<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Port;
use App\Models\Schedule;
use App\Models\ShipLine;
use Carbon\Carbon;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Validation\ValidationException;

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

        // When listing public schedules, show all where is_public = true (no filter by added_by)
        $isPublic = array_key_exists('is_public', $filters) ? (bool) $filters['is_public'] : false;
        $query->where('is_public', $isPublic);

        return $query->latest('created_at')->paginate($perPage);
    }

    /**
     * Same as list() but returns all matching schedules (no pagination). For export.
     */
    public function listAll(array $filters = []): Collection
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

        $isPublic = array_key_exists('is_public', $filters) ? (bool) $filters['is_public'] : false;
        $query->where('is_public', $isPublic);

        return $query->latest('created_at')->get();
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

    public function create(array $data, ?int $userId, ?string $addedByName, bool $isPublic = false): Schedule
    {
        $schedule = Schedule::create([
            'vessel_name' => $data['vessel_name'],
            'voyage_no' => $data['voyage_no'],
            'carrier_1_id' => $data['carrier_1_id'] ?? null,
            'carrier_2_id' => $data['carrier_2_id'] ?? null,
            'carrier_3_id' => $data['carrier_3_id'] ?? null,
            'start_port_id' => $data['start_port_id'],
            'end_port_id' => $data['end_port_id'],
            'eta' => $data['eta'] ?? null,
            'etd' => $data['etd'] ?? null,
            'status' => $data['status'] ?? 'Waiting',
            'comment' => $data['comment'] ?? null,
            'added_by' => $userId,
            'added_by_name' => $userId !== null ? null : ($addedByName ?? 'Guest'),
            'is_public' => $isPublic,
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

    public function update(Schedule $schedule, array $data, ?int $userId = null, ?string $addedByName = null): Schedule
    {
        $payload = array_filter([
            'vessel_name' => $data['vessel_name'] ?? null,
            'voyage_no' => $data['voyage_no'] ?? null,
            'carrier_1_id' => $data['carrier_1_id'] ?? null,
            'carrier_2_id' => $data['carrier_2_id'] ?? null,
            'carrier_3_id' => $data['carrier_3_id'] ?? null,
            'start_port_id' => $data['start_port_id'] ?? null,
            'end_port_id' => $data['end_port_id'] ?? null,
            'eta' => $data['eta'] ?? null,
            'etd' => $data['etd'] ?? null,
            'status' => $data['status'] ?? null,
            'comment' => $data['comment'] ?? null,
        ], fn ($value) => $value !== null);

        // When provided (e.g. public schedule last editor), update who is shown as "Created by"
        if ($userId !== null) {
            $payload['added_by'] = $userId;
            $payload['added_by_name'] = null;
        } elseif ($addedByName !== null) {
            $payload['added_by'] = null;
            $payload['added_by_name'] = $addedByName;
        }

        $schedule->update(array_filter($payload, fn ($value, $key) => in_array($key, ['added_by', 'added_by_name'], true) || $value !== null, ARRAY_FILTER_USE_BOTH));

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

    /**
     * Create a single schedule from an import row (canonical keys: vessel_name, voyage_no, carrier_1_name, start_port_name, end_port_name, eta, status, comment).
     * Resolves port and carrier names to IDs. Throws ValidationException with messages keyed by field for inline display.
     *
     * @param  array<string, mixed>  $row
     *
     * @throws ValidationException
     */
    public function createFromImportRow(array $row, ?int $userId, ?string $addedByName): Schedule
    {
        $vesselName = trim((string) ($row['vessel_name'] ?? ''));
        $voyageNo = trim((string) ($row['voyage_no'] ?? ''));
        $startPortName = trim((string) ($row['start_port_name'] ?? ''));
        $endPortName = trim((string) ($row['end_port_name'] ?? ''));
        $etaRaw = $row['eta'] ?? '';
        $status = trim((string) ($row['status'] ?? 'Waiting')) ?: 'Waiting';
        $comment = trim((string) ($row['comment'] ?? '')) ?: null;
        $carrier1Name = trim((string) ($row['carrier_1_name'] ?? '')) ?: null;

        $errors = [];

        if ($vesselName === '') {
            $errors['vessel_name'] = [__('Vessel name is required.')];
        }
        if ($voyageNo === '') {
            $errors['voyage_no'] = [__('Voyage number is required.')];
        }

        $startPort = $startPortName !== '' ? Port::where('port_name', $startPortName)->first() : null;
        $startPortId = $startPort?->id;

        $endPort = $endPortName !== '' ? Port::where('port_name', $endPortName)->first() : null;
        $endPortId = $endPort?->id;

        if ($startPortName === '') {
            $errors['start_port_name'] = [__('Start port is required.')];
        }
        if ($endPortName === '') {
            $errors['end_port_name'] = [__('End port is required.')];
        }
        if ($startPortName !== '' && $startPortId === null) {
            $errors['start_port_name'] = [__('Start port not found: :name', ['name' => $startPortName])];
        }
        if ($endPortName !== '' && $endPortId === null) {
            $errors['end_port_name'] = [__('End port not found: :name', ['name' => $endPortName])];
        }

        $eta = null;
        if ($etaRaw !== '') {
            try {
                $eta = Carbon::parse($etaRaw)->startOfDay();
            } catch (\Throwable) {
                $errors['eta'] = [__('Invalid date format for ETA.')];
            }
        }
        if ($eta === null && $etaRaw === '') {
            $errors['eta'] = [__('ETA is required.')];
        }

        $carrier1Id = null;
        if ($carrier1Name !== null && $carrier1Name !== '') {
            $carrier = ShipLine::where('line_name', $carrier1Name)->first();
            if (! $carrier) {
                $errors['carrier_1_name'] = [__('Carrier not found: :name', ['name' => $carrier1Name])];
            } else {
                $carrier1Id = $carrier->id;
            }
        }

        if ($errors !== []) {
            throw ValidationException::withMessages($errors);
        }

        return $this->create([
            'vessel_name' => $vesselName,
            'voyage_no' => $voyageNo,
            'carrier_1_id' => $carrier1Id,
            'start_port_id' => $startPortId,
            'end_port_id' => $endPortId,
            'eta' => $eta->format('Y-m-d'),
            'etd' => isset($row['etd']) && trim((string) $row['etd']) !== '' ? Carbon::parse($row['etd'])->format('Y-m-d') : null,
            'status' => $status,
            'comment' => $comment,
        ], $userId, $addedByName, true);
    }

    /**
     * Create one schedule from a group of canonical import rows (same group key).
     * Case A: one row → schedule with that row's ETA, POD → end port.
     * Case B: multiple rows → sort by ETA asc; schedule gets first row's POL/carrier/vessel/voyage/etd/comment, last row's ETA and POD; stopovers for rows 1..n-1.
     *
     * @param  array<int, array<string, string>>  $canonicalRows
     *
     * @throws ValidationException
     */
    public function createFromImportGroup(array $canonicalRows, ?int $userId, ?string $addedByName): Schedule
    {
        if (count($canonicalRows) === 0) {
            throw ValidationException::withMessages(['_' => [__('Group has no rows.')]]);
        }

        $rows = $canonicalRows;
        usort($rows, function (array $a, array $b) {
            $etaA = trim((string) ($a['eta'] ?? ''));
            $etaB = trim((string) ($b['eta'] ?? ''));
            if ($etaA === '' || $etaB === '') {
                return 0;
            }
            try {
                return Carbon::parse($etaA)->getTimestamp() <=> Carbon::parse($etaB)->getTimestamp();
            } catch (\Throwable) {
                return 0;
            }
        });

        $first = $rows[0];
        $last = $rows[count($rows) - 1];
        $shippingLine = trim((string) ($first['shipping_line'] ?? ''));
        $vesselName = trim((string) ($first['vessel_name'] ?? ''));
        $voyageNo = trim((string) ($first['voyage_no'] ?? ''));
        $pol = trim((string) ($first['pol'] ?? ''));
        $etdRaw = trim((string) ($first['etd'] ?? ''));
        $comment = trim((string) ($first['comment'] ?? '')) ?: null;

        $errors = [];

        // Case-insensitive carrier lookup; auto-create if not found
        $carrier1Id = null;
        if ($shippingLine !== '') {
            $carrier = ShipLine::whereRaw('LOWER(line_name) = ?', [mb_strtolower($shippingLine)])->first();
            if (! $carrier) {
                $carrier = ShipLine::create(['line_name' => $shippingLine, 'status' => 'Active']);
            }
            $carrier1Id = $carrier->id;
        }

        // Case-insensitive port lookup for POL; auto-create if not found
        $startPortId = null;
        if ($pol !== '') {
            $startPort = Port::whereRaw('LOWER(port_name) = ?', [mb_strtolower($pol)])->first();
            if (! $startPort) {
                $startPort = Port::create(['port_name' => mb_strtoupper($pol), 'port_type' => 'Overseas Port', 'port_address' => '']);
            }
            $startPortId = $startPort->id;
        } else {
            $errors['pol'] = [__('Start port (POL) is required.')];
        }

        if ($vesselName === '') {
            $errors['vessel_name'] = [__('Vessel name is required.')];
        }
        $etd = null;
        if ($etdRaw !== '') {
            try {
                $etd = Carbon::parse($etdRaw)->format('Y-m-d');
            } catch (\Throwable) {
                $errors['etd'] = [__('Invalid date format for ETD.')];
            }
        }

        $lastPod = trim((string) ($last['pod'] ?? ''));
        $lastEtaRaw = trim((string) ($last['eta'] ?? ''));

        // Case-insensitive port lookup for POD; auto-create if not found
        $endPortId = null;
        if ($lastPod !== '') {
            $endPort = Port::whereRaw('LOWER(port_name) = ?', [mb_strtolower($lastPod)])->first();
            if (! $endPort) {
                $endPort = Port::create(['port_name' => mb_strtoupper($lastPod), 'port_type' => 'Overseas Port', 'port_address' => '']);
            }
            $endPortId = $endPort->id;
        } else {
            $errors['pod'] = [__('End port (POD) is required.')];
        }

        // ETA is optional - parse if provided, null if empty/TBA
        $eta = null;
        if ($lastEtaRaw !== '') {
            try {
                $eta = Carbon::parse($lastEtaRaw)->format('Y-m-d');
            } catch (\Throwable) {
                // Invalid date, keep null
            }
        }

        if ($errors !== []) {
            throw ValidationException::withMessages($errors);
        }

        // Update if exists (match by vessel_name + voyage_no + start_port_id + etd), else insert
        $existingQuery = Schedule::where('vessel_name', $vesselName)
            ->where('voyage_no', $voyageNo)
            ->where('start_port_id', $startPortId)
            ->where('is_public', true);

        if ($etd !== null) {
            $existingQuery->where('etd', $etd);
        } else {
            $existingQuery->whereNull('etd');
        }

        $existing = $existingQuery->first();

        if ($existing) {
            $schedule = $this->update($existing, [
                'vessel_name' => $vesselName,
                'voyage_no' => $voyageNo,
                'carrier_1_id' => $carrier1Id,
                'start_port_id' => $startPortId,
                'end_port_id' => $endPortId,
                'eta' => $eta,
                'etd' => $etd,
                'status' => $existing->status,
                'comment' => $comment,
            ], $userId, $addedByName);

            // Remove old stopovers before re-creating
            $existing->stopovers()->delete();
        } else {
            $schedule = $this->create([
                'vessel_name' => $vesselName,
                'voyage_no' => $voyageNo,
                'carrier_1_id' => $carrier1Id,
                'start_port_id' => $startPortId,
                'end_port_id' => $endPortId,
                'eta' => $eta,
                'etd' => $etd,
                'status' => 'Waiting',
                'comment' => $comment,
            ], $userId, $addedByName, true);
        }

        if (count($rows) > 1) {
            $stopoverService = app(ScheduleStopoverService::class);
            for ($i = 1; $i < count($rows); $i++) {
                $r = $rows[$i];
                $podName = trim((string) ($r['pod'] ?? ''));
                $etaStr = trim((string) ($r['eta'] ?? ''));
                if ($podName === '') {
                    continue;
                }
                $port = Port::whereRaw('LOWER(port_name) = ?', [mb_strtolower($podName)])->first();
                if (! $port) {
                    $port = Port::create(['port_name' => mb_strtoupper($podName), 'port_type' => 'Overseas Port', 'port_address' => '']);
                }
                $stopoverEta = null;
                if ($etaStr !== '') {
                    try {
                        $stopoverEta = Carbon::parse($etaStr)->format('Y-m-d 00:00:00');
                    } catch (\Throwable) {
                        $stopoverEta = null;
                    }
                }
                $stopoverService->create([
                    'schedule_id' => $schedule->id,
                    'port_id' => $port->id,
                    'stopover_eta' => $stopoverEta,
                    'stopover_etd' => null,
                    'status' => 'Waiting',
                ], $userId, $addedByName);
            }
        }

        return $schedule->load(['carrier1', 'startPort', 'endPort', 'stopovers.port', 'addedBy']);
    }
}
