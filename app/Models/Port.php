<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Port Model
 *
 * Global resource shared across all vendors.
 * Tracks who created it via created_by.
 */
class Port extends Model
{
    use HasFactory;

    protected $fillable = [
        'port_name',
        'port_type',
        'port_address',
        'created_by',
    ];

    /**
     * User who created this port.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
