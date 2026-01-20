<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ScheduleStopover extends Model
{
    use HasFactory;

    protected $fillable = [
        'schedule_id',
        'port_id',
        'stopover_eta',
        'stopover_etd',
        'status',
        'added_by',
    ];

    protected function casts(): array
    {
        return [
            'stopover_eta' => 'datetime',
            'stopover_etd' => 'datetime',
            'status' => 'string',
        ];
    }

    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    public function port(): BelongsTo
    {
        return $this->belongsTo(Port::class);
    }

    public function addedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'added_by');
    }
}
