<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Vendor Model
 *
 * Represents a company/organization using this system.
 * Each vendor has their own users, tasks, and vehicles.
 */
class Vendor extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'email',
        'phone',
        'address',
        'website',
        'status',
        'external_db_host',
        'external_db_port',
        'external_db_database',
        'external_db_username',
        'external_db_password',
        'external_image_path',
        'external_image_base_url',
    ];

    protected $hidden = [
        'external_db_password', // Hide encrypted password from JSON
    ];

    protected function casts(): array
    {
        return [
            'external_db_password' => 'encrypted', // Automatically encrypt/decrypt
        ];
    }

    /**
     * Users belonging to this vendor.
     */
    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * Tasks belonging to this vendor.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }

    /**
     * Vehicles belonging to this vendor.
     */
    public function vehicles(): HasMany
    {
        return $this->hasMany(Vehicle::class);
    }

    /**
     * Check if vendor is active.
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }
}
