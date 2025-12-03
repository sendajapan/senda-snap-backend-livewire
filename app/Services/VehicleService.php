<?php

namespace App\Services;

use App\Models\Vehicle;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class VehicleService
{
    public function __construct(
        protected ExternalVehicleService $externalVehicleService,
        protected SftpService $sftpService
    ) {
    }

    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Vehicle::with(['creator', 'photos', 'consignee', 'tasks']);

        // Search functionality
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('serial_number', 'like', "%{$search}%")
                    ->orWhere('make', 'like', "%{$search}%")
                    ->orWhere('model', 'like', "%{$search}%")
                    ->orWhere('chassis_model', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by make
        if (!empty($filters['make'])) {
            $query->where('make', 'like', "%{$filters['make']}%");
        }

        // Filter by year
        if (!empty($filters['year'])) {
            $query->where('year', $filters['year']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getPaginated(array $filters = [], int $perPage = 10): LengthAwarePaginator
    {
        $query = Vehicle::with(['creator']);

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

    public function create(array $data, int $createdBy): Vehicle
    {
        $vehicleData = array_merge($data, ['created_by' => $createdBy]);

        $vehicle = Vehicle::create($vehicleData);
        $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);

        return $vehicle;
    }

    public function update(Vehicle $vehicle, array $data): Vehicle
    {
        $vehicle->update($data);
        $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);

        return $vehicle;
    }

    public function delete(Vehicle $vehicle): bool
    {
        return $vehicle->delete();
    }

    public function search(string $searchType, string $searchQuery): array
    {
        return $this->externalVehicleService->getVehicleDetails($searchType, $searchQuery);
    }

    public function uploadImages(int $vehicleId, array $images, ?int $createdBy = null): array
    {
        $results = $this->externalVehicleService->getVehicleDetails('vehicle_id', (string) $vehicleId);

        if (empty($results['vehicles']) || !isset($results['vehicles'][0])) {
            throw new \RuntimeException('Vehicle not found');
        }

        $vehicle = $results['vehicles'][0];

        // Upload files to remote server via SFTP
        $imagePath = config('filesystems.disks.sftp.image_path', '/home/kono/public_html/autocraft/avisnew/images/veh_images/');


        $imagePath = ltrim($imagePath, '/');
        $uploadedPaths = $this->sftpService->uploadMultipleFiles($images, $imagePath);

        // Store image records in database
        $dbResult = null;
        if ($createdBy !== null) {
            $fullPaths = array_map(function ($fileName) use ($imagePath) {
                return rtrim($imagePath, '/') . '/' . ltrim($fileName, '/');
            }, $uploadedPaths);

            $dbResult = $this->externalVehicleService->storeVehicleImages($vehicleId, $fullPaths, $createdBy);
        }

        // Generate URLs for uploaded images
        $uploadedImages = [];
        $baseUrl = config('filesystems.disks.sftp.url', 'https://senda.us/autocraft/avisnew/images/veh_images/');

        foreach ($uploadedPaths as $path) {
            $uploadedImages[] = rtrim($baseUrl, '/') . '/' . ltrim($path, '/');
        }

        $existingImages = $vehicle['images'] ?? [];
        $vehicle['images'] = array_merge($existingImages, $uploadedImages);

        return $vehicle;
    }

    public function getById(int $vehicleId): Vehicle
    {
        return Vehicle::with(['creator', 'photos', 'consignee', 'tasks'])->findOrFail($vehicleId);
    }
}
