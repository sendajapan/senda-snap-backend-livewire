<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * ShippingCompany Model
 *
 * Global resource shared across all vendors.
 * Tracks who created it via created_by.
 */
class ShippingCompany extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_name',
        'company_type',
        'company_status',
        'company_name_jp',
        'per_m3',
        'per_container',
        'zip',
        'country_name',
        'state',
        'city',
        'address',
        'created_by',
    ];

    /**
     * User who created this shipping company.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
