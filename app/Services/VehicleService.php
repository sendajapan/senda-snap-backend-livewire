<?php

namespace App\Services;

use App\Models\Vehicle;
use App\Models\Vendor;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/**
 * Vehicle Service
 *
 * Vehicles belong to vendors. Users can only see vehicles within their vendor.
 * Admin users can see all vehicles.
 *
 * ExternalVehicleService is created dynamically based on the current user's vendor configuration.
 */
class VehicleService
{
    public function __construct(
        protected SftpService $sftpService
    ) {
    }

    /**
     * Get ExternalVehicleService instance for the current user's vendor.
     * For admin users (vendor_id = null), uses the default vendor (AUTOCRAFT JAPAN LTD).
     */
    protected function getExternalVehicleService(): ExternalVehicleService
    {
        $user = auth()->user();

        if (!$user) {
            throw new \RuntimeException('User must be authenticated to access external vehicle service.');
        }

        // For admin users (vendor_id = null), use default vendor
        if (!$user->vendor_id) {
            $vendor = Vendor::where('email', 'info@autocraftjapan.com')->first();

            if (!$vendor) {
                throw new \RuntimeException('Default vendor (AUTOCRAFT JAPAN LTD) not found.');
            }
        } else {
            // Load vendor relationship if not already loaded
            if (!$user->relationLoaded('vendor')) {
                $user->load('vendor');
            }

            $vendor = $user->vendor;

            if (!$vendor) {
                throw new \RuntimeException('Vendor not found for user.');
            }
        }

        // Validate vendor has external vehicle configuration
        if (
            !$vendor->external_db_host || !$vendor->external_db_database ||
            !$vendor->external_db_username || !$vendor->external_db_password ||
            !$vendor->external_image_path || !$vendor->external_image_base_url
        ) {
            throw new \RuntimeException('Vendor external vehicle configuration is incomplete.');
        }

        return new ExternalVehicleService(
            dbHost: $vendor->external_db_host,
            dbPort: $vendor->external_db_port ?? '3306',
            dbDatabase: $vendor->external_db_database,
            dbUsername: $vendor->external_db_username,
            dbPassword: $vendor->external_db_password, // Automatically decrypted by model
            imagePath: $vendor->external_image_path,
            imageBaseUrl: $vendor->external_image_base_url
        );
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Vehicle::with(['creator', 'photos', 'consignee', 'tasks'])
            ->forCurrentVendor();

        $this->applyFilters($query, $filters);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Vehicle::with('creator')
            ->forCurrentVendor();

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('serial_number', 'like', "%{$filters['search']}%")
                    ->orWhere('make', 'like', "%{$filters['search']}%")
                    ->orWhere('model', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getById(int $vehicleId): Vehicle
    {
        return Vehicle::with(['creator', 'photos', 'consignee', 'tasks'])
            ->forCurrentVendor()
            ->findOrFail($vehicleId);
    }

    public function create(array $data, int $createdBy): Vehicle
    {
        // Auto-assign vendor_id from current user
        $user = auth()->user();
        $vendorId = $data['vendor_id'] ?? $user?->vendor_id;

        $vehicle = Vehicle::create(array_merge($data, [
            'created_by' => $createdBy,
            'vendor_id' => $vendorId,
        ]));

        return $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);
    }

    public function update(Vehicle $vehicle, array $data): Vehicle
    {
        $vehicle->update($data);

        return $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);
    }

    public function delete(Vehicle $vehicle): bool
    {
        return $vehicle->delete();
    }

    public function search(string $searchType, string $searchQuery): array
    {
        $externalService = $this->getExternalVehicleService();

        return $externalService->getVehicleDetails($searchType, $searchQuery);
    }

    public function uploadImages(int $vehicleId, array $images, ?int $createdBy = null): array
    {
        $externalService = $this->getExternalVehicleService();
        $results = $externalService->getVehicleDetails('vehicle_id', (string) $vehicleId);

        if (empty($results['vehicles']) || !isset($results['vehicles'][0])) {
            throw new \RuntimeException('Vehicle not found');
        }

        $vehicle = $results['vehicles'][0];

        // Upload files to remote server via SFTP
        $imagePath = $externalService->getImagePath();
        $imagePath = ltrim($imagePath, '/');
        $uploadedPaths = $this->sftpService->uploadMultipleFiles($images, $imagePath);

        // Store image records in database
        if ($createdBy !== null) {
            $fullPaths = array_map(
                fn($fileName) => rtrim($imagePath, '/') . '/' . ltrim($fileName, '/'),
                $uploadedPaths
            );
            $externalService->storeVehicleImages($vehicleId, $fullPaths, $createdBy);
        }

        // Generate URLs for uploaded images using vendor's base URL
        $uploadedImages = [];
        $baseUrl = $externalService->getImageBaseUrl();

        foreach ($uploadedPaths as $path) {
            $uploadedImages[] = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }

        $vehicle['images'] = array_merge($vehicle['images'] ?? [], $uploadedImages);

        return $vehicle;
    }

    private function applyFilters($query, array $filters): void
    {
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('make', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('chassis_model', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['make'])) {
            $query->where('make', 'like', "%{$filters['make']}%");
        }

        if (!empty($filters['year'])) {
            $query->where('year', $filters['year']);
        }
    }
}
