<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TaskService
{
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments']);

        // Search functionality
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Filter by priority
        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        // Filter by assigned user
        if (! empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', function ($q) use ($filters) {
                $q->where('users.id', $filters['assigned_to']);
            });
        }

        // Filter by date range
        if (! empty($filters['date_from'])) {
            $query->where('work_date', '>=', $filters['date_from']);
        }
        if (! empty($filters['date_to'])) {
            $query->where('work_date', '<=', $filters['date_to']);
        }

        // Sorting
        if (! empty($filters['sort_by']) && ! empty($filters['sort_direction'])) {
            $query->orderBy($filters['sort_by'], $filters['sort_direction']);
        } else {
            $query->orderBy('created_at', 'desc');
        }

        return $query->paginate($perPage);
    }

    public function create(array $data, array $assignedUserIds = []): Task
    {
        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'work_date' => $data['work_date'] ?? null,
            'work_time' => $data['work_time'] ?? null,
            'priority' => $data['priority'],
            'status' => $data['status'] ?? 'pending',
            'created_by' => $data['created_by'],
            'due_date' => $data['due_date'] ?? null,
        ]);

        // Assign users to task
        if (! empty($assignedUserIds)) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $task;
    }

    public function update(Task $task, array $data, ?array $assignedUserIds = null): Task
    {
        $task->update(array_filter([
            'title' => $data['title'] ?? null,
            'description' => $data['description'] ?? null,
            'work_date' => $data['work_date'] ?? null,
            'work_time' => $data['work_time'] ?? null,
            'priority' => $data['priority'] ?? null,
            'status' => $data['status'] ?? null,
            'due_date' => $data['due_date'] ?? null,
        ], fn ($value) => $value !== null));

        // Update assigned users if provided
        if ($assignedUserIds !== null) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $task;
    }

    public function delete(Task $task): bool
    {
        // Delete associated attachments
        foreach ($task->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        return $task->delete();
    }

    public function assign(Task $task, array $userIds): Task
    {
        $task->assignedUsers()->sync($userIds);
        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $task;
    }

    public function updateStatus(Task $task, string $status): Task
    {
        $updateData = ['status' => $status];

        if ($status === 'completed') {
            $updateData['completed_at'] = now();
        } else {
            $updateData['completed_at'] = null;
        }

        $task->update($updateData);
        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $task;
    }

    public function uploadAttachment(
        Task $task,
        UploadedFile $file,
        int $uploadedBy,
        ?string $fileName = null
    ): TaskAttachment {
        $filePath = $file->store('task-attachments', 'public');
        $fileName = $fileName ?? $file->getClientOriginalName();
        $fileType = $file->getClientMimeType();

        return $task->attachments()->create([
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'uploaded_by' => $uploadedBy,
        ]);
    }

    public function deleteAttachment(TaskAttachment $attachment): bool
    {
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        return $attachment->delete();
    }

    public function getMyTasks(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->where('created_by', $userId);

        // Apply filters
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getAssignedTasks(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->whereHas('assignedUsers', function ($q) use ($userId) {
                $q->where('users.id', $userId);
            });

        // Apply filters
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getTodayTasks(array $filters = [], int $perPage = 5): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->whereDate('work_date', today());

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (! empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', function ($q) use ($filters) {
                $q->where('users.id', $filters['assigned_to']);
            });
        }

        return $query->orderByRaw('CASE WHEN work_time IS NULL THEN 1 ELSE 0 END')
            ->orderBy('work_time', 'asc')
            ->paginate($perPage, ['*'], 'todayTasksPage');
    }

    public function getAllTasksFiltered(array $filters = [], int $perPage = 50, string $pageName = 'allTasksPage'): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments']);

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (! empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', function ($q) use ($filters) {
                $q->where('users.id', $filters['assigned_to']);
            });
        }

        if (! empty($filters['from_date'])) {
            $query->whereDate('work_date', '>=', $filters['from_date']);
        }

        if (! empty($filters['to_date'])) {
            $query->whereDate('work_date', '<=', $filters['to_date']);
        }

        return $query->orderBy('work_date', 'desc')
            ->orderBy('work_time', 'desc')
            ->paginate($perPage, ['*'], $pageName);
    }

    public function getTaskById(int $taskId): Task
    {
        return Task::with(['assignedUsers', 'creator', 'attachments'])->findOrFail($taskId);
    }
}
