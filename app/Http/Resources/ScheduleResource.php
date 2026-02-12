<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleResource extends JsonResource
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
            'vessel_name' => $this->vessel_name,
            'voyage_no' => $this->voyage_no,
            'carrier_1' => $this->whenLoaded('carrier1', function () {
                return [
                    'id' => $this->carrier1->id,
                    'line_name' => $this->carrier1->line_name,
                ];
            }),
            'carrier_2' => $this->whenLoaded('carrier2', function () {
                return [
                    'id' => $this->carrier2->id,
                    'line_name' => $this->carrier2->line_name,
                ];
            }),
            'carrier_3' => $this->whenLoaded('carrier3', function () {
                return [
                    'id' => $this->carrier3->id,
                    'line_name' => $this->carrier3->line_name,
                ];
            }),
            'start_port' => $this->whenLoaded('startPort', function () {
                return new PortResource($this->startPort);
            }),
            'end_port' => $this->whenLoaded('endPort', function () {
                return new PortResource($this->endPort);
            }),
            'eta' => $this->eta?->format('Y-m-d'),
            'status' => $this->status,
            'comment' => $this->comment,
            'is_public' => $this->is_public,
            'added_by_name' => $this->added_by_name,
            'creator_display_name' => $this->creatorDisplayName(),
            'stopovers' => ScheduleStopoverResource::collection($this->whenLoaded('stopovers')),
            'added_by' => $this->whenLoaded('addedBy', function () {
                return $this->addedBy ? new UserResource($this->addedBy) : null;
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
