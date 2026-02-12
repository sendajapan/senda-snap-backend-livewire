<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ScheduleStopoverResource extends JsonResource
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
            'schedule_id' => $this->schedule_id,
            'port' => $this->whenLoaded('port', function () {
                return new PortResource($this->port);
            }),
            'stopover_eta' => $this->stopover_eta?->toISOString(),
            'stopover_etd' => $this->stopover_etd?->toISOString(),
            'status' => $this->status,
            'added_by_name' => $this->added_by_name,
            'added_by' => $this->whenLoaded('addedBy', function () {
                return $this->addedBy ? new UserResource($this->addedBy) : null;
            }),
            'created_at' => $this->created_at?->toISOString(),
            'updated_at' => $this->updated_at?->toISOString(),
        ];
    }
}
