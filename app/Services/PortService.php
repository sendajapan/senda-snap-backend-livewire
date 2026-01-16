<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Port;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Port Service
 *
 * Ports are global resources shared across all vendors.
 * No vendor scoping needed - all users can see all ports.
 */
class PortService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Port::with('creator');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('port_name', 'like', "%{$search}%")
                    ->orWhere('port_address', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['port_type'])) {
            $query->where('port_type', $filters['port_type']);
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        return $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function listAll(array $filters = []): Collection
    {
        $query = Port::with('creator');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('port_name', 'like', "%{$search}%")
                    ->orWhere('port_address', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['port_type'])) {
            $query->where('port_type', $filters['port_type']);
        }

        return $query->orderBy('port_name', 'asc')->get();
    }

    public function create(array $data): Port
    {
        return Port::create([
            'port_name' => $data['port_name'],
            'port_type' => $data['port_type'],
            'port_address' => $data['port_address'],
            'created_by' => auth()->id(),
        ]);
    }

    public function update(Port $port, array $data): Port
    {
        $port->update(array_filter([
            'port_name' => $data['port_name'] ?? null,
            'port_type' => $data['port_type'] ?? null,
            'port_address' => $data['port_address'] ?? null,
        ], fn ($value) => $value !== null));

        return $port->fresh();
    }

    public function getById(int $id): Port
    {
        return Port::with('creator')->findOrFail($id);
    }

    public function delete(Port $port): bool
    {
        return $port->delete();
    }
}
