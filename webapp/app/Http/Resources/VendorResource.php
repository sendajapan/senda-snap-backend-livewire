<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VendorResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'phone' => $this->phone,
            'address' => $this->address,
            'city' => $this->city,
            'state' => $this->state,
            'country' => $this->country,
            'zip' => $this->zip,
            'website' => $this->website,
            'status' => $this->status,
            // External vehicle config (exclude password for security)
            'external_db_host' => $this->external_db_host,
            'external_db_port' => $this->external_db_port,
            'external_db_database' => $this->external_db_database,
            'external_db_username' => $this->external_db_username,
            // external_db_password is hidden in model
            'external_image_path' => $this->external_image_path,
            'external_image_base_url' => $this->external_image_base_url,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
