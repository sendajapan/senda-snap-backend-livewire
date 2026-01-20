<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ShipLine;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Ship Line Service
 *
 * Ship lines are global resources shared across all vendors.
 * No vendor scoping needed - all users can see all ship lines.
 */
class ShipLineService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = ShipLine::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('line_name', 'like', "%{$search}%");
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $sortBy = $filters['sort_by'] ?? 'line_name';
        $sortDirection = $filters['sort_direction'] ?? 'asc';

        return $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function listAll(array $filters = []): Collection
    {
        $query = ShipLine::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('line_name', 'like', "%{$search}%");
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('line_name', 'asc')->get();
    }

    public function create(array $data): ShipLine
    {
        return ShipLine::create([
            'line_name' => $data['line_name'],
            'status' => $data['status'] ?? 'Active',
        ]);
    }

    public function update(ShipLine $shipLine, array $data): ShipLine
    {
        $shipLine->update(array_filter([
            'line_name' => $data['line_name'] ?? null,
            'status' => $data['status'] ?? null,
        ], fn ($value) => $value !== null));

        return $shipLine->fresh();
    }

    public function getById(int $id): ShipLine
    {
        return ShipLine::findOrFail($id);
    }

    public function delete(ShipLine $shipLine): bool
    {
        return $shipLine->delete();
    }
}
