<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Vehicle extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number',
        'make',
        'model',
        'chassis_model',
        'cc',
        'year',
        'color',
        'vehicle_buy_date',
        'auction_ship_number',
        'net_weight',
        'area',
        'length',
        'width',
        'height',
        'plate_number',
        'buying_price',
        'expected_yard_date',
        'rikso_from',
        'rikso_to',
        'rikso_cost',
        'rikso_company',
        'auction_sheet',
        'tohon_copy',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'vehicle_buy_date' => 'date',
            'expected_yard_date' => 'date',
            'net_weight' => 'decimal:2',
            'length' => 'decimal:2',
            'width' => 'decimal:2',
            'height' => 'decimal:2',
            'buying_price' => 'decimal:2',
            'rikso_cost' => 'decimal:2',
        ];
    }

    public function photos(): HasMany
    {
        return $this->hasMany(VehiclePhoto::class);
    }

    public function consignee(): HasOne
    {
        return $this->hasOne(ConsigneeDetail::class);
    }

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
