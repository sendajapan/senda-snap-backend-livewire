<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
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
            'title' => $this->title,
            'description' => $this->description,
            'work_date' => $this->work_date?->format('Y-m-d'),
            'work_time' => $this->work_time,
            'status' => $this->status,
            'priority' => $this->priority,
            'due_date' => $this->due_date?->format('Y-m-d'),
            'completed_at' => $this->completed_at?->toISOString(),
            'created_at' => $this->created_at->toISOString(),
            'updated_at' => $this->updated_at->toISOString(),
            'assigned_users' => UserResource::collection($this->whenLoaded('assignedUsers')),
            'creator' => new UserResource($this->whenLoaded('creator')),
            'attachments' => TaskAttachmentResource::collection($this->whenLoaded('attachments')),
        ];
    }
}
