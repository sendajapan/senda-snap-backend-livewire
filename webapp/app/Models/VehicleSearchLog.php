<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVendor;
use App\Services\ExternalVehicleService;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class VehicleSearchLog extends Model
{
    use BelongsToVendor;
    use HasFactory;

    protected $fillable = [
        'user_id',
        'vendor_id',
        'search_type',
        'search_query',
        'vehicles_found',
        'vehicle_ids',
        'ip_address',
        'user_agent',
    ];

    protected function casts(): array
    {
        return [
            'vehicle_ids' => 'array',
            'vehicles_found' => 'integer',
        ];
    }

    /**
     * User who performed the search.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope to order by most recent first.
     */
    public function scopeRecent(Builder $query): Builder
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Get vendor name or default vendor name for admin users.
     */
    public function getVendorNameAttribute(): string
    {
        if ($this->vendor) {
            return $this->vendor->name;
        }

        // For admin users or when vendor is null, return default vendor name
        $defaultVendor = Vendor::where('email', 'info@autocraftjapan.com')->first();

        return $defaultVendor ? $defaultVendor->name : __('Default Vendor');
    }

    /**
     * Get fresh vehicle data from external database.
     * This fetches the vehicles using the stored vehicle IDs.
     */
    public function getVehiclesAttribute(): array
    {
        if (empty($this->vehicle_ids) || ! is_array($this->vehicle_ids)) {
            return [];
        }

        try {
            // Get the vendor (or default vendor for admin)
            $vendor = $this->vendor;
            if (! $vendor) {
                $vendor = Vendor::where('email', 'info@autocraftjapan.com')->first();
            }

            if (! $vendor) {
                return [];
            }

            // Validate vendor has external vehicle configuration
            if (
                ! $vendor->external_db_host || ! $vendor->external_db_database ||
                ! $vendor->external_db_username || ! $vendor->external_db_password ||
                ! $vendor->external_image_path || ! $vendor->external_image_base_url
            ) {
                return [];
            }

            $externalService = new ExternalVehicleService(
                dbHost: $vendor->external_db_host,
                dbPort: $vendor->external_db_port ?? '3306',
                dbDatabase: $vendor->external_db_database,
                dbUsername: $vendor->external_db_username,
                dbPassword: $vendor->external_db_password,
                imagePath: $vendor->external_image_path,
                imageBaseUrl: $vendor->external_image_base_url
            );

            // Fetch vehicles by their IDs
            $vehicles = [];
            foreach ($this->vehicle_ids as $vehicleId) {
                try {
                    $result = $externalService->getVehicleDetails('vehicle_id', (string) $vehicleId);
                    if (! empty($result['vehicles'])) {
                        $vehicles = array_merge($vehicles, $result['vehicles']);
                    }
                } catch (\Exception $e) {
                    // Skip vehicles that can't be fetched
                    continue;
                }
            }

            return $vehicles;
        } catch (\Exception $e) {
            return [];
        }
    }
}
