<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\ShippingCompany;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

/**
 * Shipping Company Service
 *
 * Shipping companies are global resources shared across all vendors.
 * No vendor scoping needed - all users can see all shipping companies.
 */
class ShippingCompanyService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = ShippingCompany::with('creator');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('company_name_jp', 'like', "%{$search}%")
                    ->orWhere('city', 'like', "%{$search}%")
                    ->orWhere('country_name', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['company_type'])) {
            $query->where('company_type', $filters['company_type']);
        }

        if (! empty($filters['company_status'])) {
            $query->where('company_status', $filters['company_status']);
        }

        $sortBy = $filters['sort_by'] ?? 'created_at';
        $sortDirection = $filters['sort_direction'] ?? 'desc';

        return $query->orderBy($sortBy, $sortDirection)->paginate($perPage);
    }

    public function listAll(array $filters = []): Collection
    {
        $query = ShippingCompany::with('creator');

        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'like', "%{$search}%")
                    ->orWhere('company_name_jp', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['company_type'])) {
            $query->where('company_type', $filters['company_type']);
        }

        if (! empty($filters['company_status'])) {
            $query->where('company_status', $filters['company_status']);
        }

        return $query->orderBy('company_name', 'asc')->get();
    }

    public function create(array $data): ShippingCompany
    {
        return ShippingCompany::create([
            'company_name' => $data['company_name'],
            'company_type' => $data['company_type'],
            'company_status' => $data['company_status'] ?? 'Active',
            'company_name_jp' => $data['company_name_jp'] ?? null,
            'per_m3' => $data['per_m3'] ?? null,
            'per_container' => $data['per_container'] ?? null,
            'zip' => $data['zip'] ?? null,
            'country_name' => $data['country_name'] ?? null,
            'state' => $data['state'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
            'created_by' => auth()->id(),
        ]);
    }

    public function update(ShippingCompany $shippingCompany, array $data): ShippingCompany
    {
        $shippingCompany->update(array_filter([
            'company_name' => $data['company_name'] ?? null,
            'company_type' => $data['company_type'] ?? null,
            'company_status' => $data['company_status'] ?? null,
            'company_name_jp' => $data['company_name_jp'] ?? null,
            'per_m3' => $data['per_m3'] ?? null,
            'per_container' => $data['per_container'] ?? null,
            'zip' => $data['zip'] ?? null,
            'country_name' => $data['country_name'] ?? null,
            'state' => $data['state'] ?? null,
            'city' => $data['city'] ?? null,
            'address' => $data['address'] ?? null,
        ], fn ($value) => $value !== null));

        return $shippingCompany->fresh();
    }

    public function getById(int $id): ShippingCompany
    {
        return ShippingCompany::with('creator')->findOrFail($id);
    }

    public function delete(ShippingCompany $shippingCompany): bool
    {
        return $shippingCompany->delete();
    }
}
