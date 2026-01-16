<?php

namespace App\Models\Concerns;

use App\Models\Vendor;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Trait for models that belong to a vendor.
 *
 * Provides:
 * - vendor() relationship
 * - scopeForVendor() query scope for multi-tenancy filtering
 */
trait BelongsToVendor
{
    /**
     * Get the vendor that owns this model.
     */
    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }

    /**
     * Scope to filter by vendor.
     * Admin users can see all records (pass null to skip filtering).
     */
    public function scopeForVendor(Builder $query, ?int $vendorId): Builder
    {
        if ($vendorId !== null) {
            return $query->where('vendor_id', $vendorId);
        }

        return $query;
    }

    /**
     * Scope to filter by current user's vendor.
     * Admin users (vendor_id = null) can see all records.
     */
    public function scopeForCurrentVendor(Builder $query): Builder
    {
        $user = auth()->user();

        // Admin users have no vendor restriction
        if (! $user || $user->role === 'admin' || ! $user->vendor_id) {
            return $query;
        }

        return $query->where('vendor_id', $user->vendor_id);
    }
}
