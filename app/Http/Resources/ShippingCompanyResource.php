<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShippingCompanyResource extends JsonResource
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
            'company_name' => $this->company_name,
            'company_type' => $this->company_type,
            'company_status' => $this->company_status,
            'company_name_jp' => $this->company_name_jp,
            'per_m3' => $this->per_m3,
            'per_container' => $this->per_container,
            'zip' => $this->zip,
            'country_name' => $this->country_name,
            'state' => $this->state,
            'city' => $this->city,
            'address' => $this->address,
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
