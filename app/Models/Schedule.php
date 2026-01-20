<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'vessel_name',
        'voyage_no',
        'carrier_1_id',
        'carrier_2_id',
        'carrier_3_id',
        'start_port_id',
        'end_port_id',
        'eta',
        'status',
        'comment',
        'added_by',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }

    public function carrier1(): BelongsTo
    {
        return $this->belongsTo(ShippingCompany::class, 'carrier_1_id');
    }

    public function carrier2(): BelongsTo
    {
        return $this->belongsTo(ShippingCompany::class, 'carrier_2_id');
    }

    public function carrier3(): BelongsTo
    {
        return $this->belongsTo(ShippingCompany::class, 'carrier_3_id');
    }

    public function startPort(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'start_port_id');
    }

    public function endPort(): BelongsTo
    {
        return $this->belongsTo(Port::class, 'end_port_id');
    }

    public function stopovers(): HasMany
    {
        return $this->hasMany(ScheduleStopover::class);
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
