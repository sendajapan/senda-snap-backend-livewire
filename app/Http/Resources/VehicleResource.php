<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class VehicleResource extends JsonResource
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
            'serial_number' => $this->serial_number,
            'make' => $this->make,
            'model' => $this->model,
            'chassis_model' => $this->chassis_model,
            'cc' => $this->cc,
            'year' => $this->year,
            'color' => $this->color,
            'vehicle_buy_date' => $this->vehicle_buy_date?->format('Y-m-d'),
            'auction_ship_number' => $this->auction_ship_number,
            'net_weight' => $this->net_weight,
            'area' => $this->area,
            'length' => $this->length,
            'width' => $this->width,
            'height' => $this->height,
            'plate_number' => $this->plate_number,
            'buying_price' => $this->buying_price,
            'expected_yard_date' => $this->expected_yard_date?->format('Y-m-d'),
            'rikso_from' => $this->rikso_from,
            'rikso_to' => $this->rikso_to,
            'rikso_cost' => $this->rikso_cost,
            'rikso_company' => $this->rikso_company,
            'auction_sheet' => $this->auction_sheet,
            'tohon_copy' => $this->tohon_copy,
            'status' => $this->status,
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'photos' => $this->whenLoaded('photos'),
            'consignee' => $this->whenLoaded('consignee'),
            'tasks' => TaskResource::collection($this->whenLoaded('tasks')),
        ];
    }
}
