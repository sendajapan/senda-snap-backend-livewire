<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class VendorService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Vendor::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';
        $query->orderBy($sortBy, $sortDirection);

        return $query->paginate($perPage);
    }

    public function listAll(array $filters = []): Collection
    {
        $query = Vendor::query();

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('name', 'asc')->get();
    }

    public function create(array $data): Vendor
    {
        return Vendor::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'website' => $data['website'] ?? null,
            'status' => $data['status'] ?? 'active',
            'external_db_host' => $data['external_db_host'],
            'external_db_port' => $data['external_db_port'] ?? '3306',
            'external_db_database' => $data['external_db_database'],
            'external_db_username' => $data['external_db_username'],
            'external_db_password' => $data['external_db_password'], // Will be encrypted automatically
            'external_image_path' => $data['external_image_path'],
            'external_image_base_url' => $data['external_image_base_url'],
        ]);
    }

    public function update(Vendor $vendor, array $data): Vendor
    {
        $updateData = array_filter([
            'name' => $data['name'] ?? null,
            'email' => $data['email'] ?? null,
            'phone' => $data['phone'] ?? null,
            'address' => $data['address'] ?? null,
            'website' => $data['website'] ?? null,
            'status' => $data['status'] ?? null,
            'external_db_host' => $data['external_db_host'] ?? null,
            'external_db_port' => $data['external_db_port'] ?? null,
            'external_db_database' => $data['external_db_database'] ?? null,
            'external_db_username' => $data['external_db_username'] ?? null,
            'external_image_path' => $data['external_image_path'] ?? null,
            'external_image_base_url' => $data['external_image_base_url'] ?? null,
        ], fn ($value) => $value !== null);

        // Only update password if provided (not empty)
        if (isset($data['external_db_password']) && ! empty($data['external_db_password'])) {
            $updateData['external_db_password'] = $data['external_db_password']; // Will be encrypted automatically
        }

        $vendor->update($updateData);

        return $vendor->fresh();
    }

    public function getById(int $id): Vendor
    {
        return Vendor::findOrFail($id);
    }

    public function delete(Vendor $vendor): bool
    {
        return $vendor->delete();
    }
}
