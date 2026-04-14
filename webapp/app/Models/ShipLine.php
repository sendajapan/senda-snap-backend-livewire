<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShipLine extends Model
{
    use HasFactory;

    protected $table = 'tbl_ship_line';

    protected $fillable = [
        'line_name',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => 'string',
        ];
    }
}
