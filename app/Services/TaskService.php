<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class TaskService
{
    public function list(array $filters = [], int $perPage = 100): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments']);

        // if got search keyword then search in title or description
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // filter by status if needed
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // filter by priority also can
        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        // filter by which user assigned to
        if (!empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', function ($q) use ($filters) {
                $q->where('users.id', $filters['assigned_to']);
            });
        }

        // filter by date from and to
        if (!empty($filters['date_from'])) {
            $query->where('work_date', '>=', $filters['date_from']);
        }
        if (!empty($filters['date_to'])) {
            $query->where('work_date', '<=', $filters['date_to']);
        }

        // sorting, default is newest first
        if (!empty($filters['sort_by']) && !empty($filters['sort_direction'])) {
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

        // assign users to this task if got any
        if (!empty($assignedUserIds)) {
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
        ], fn($value) => $value !== null));

        // update who assigned to this task also if got changes
        if ($assignedUserIds !== null) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $task;
    }

    public function delete(Task $task): bool
    {
        // need to delete all files first before deleting task
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

    /**
     * Add multiple files to task one by one
     *
     * @param  array<int, UploadedFile>  $files
     */
    public function addAttachments(Task $task, array $files, int $uploadedBy): void
    {
        foreach ($files as $file) {
            $this->uploadAttachment($task, $file, $uploadedBy);
        }
        $task->load(['attachments']);
    }

    /**
     * Remove all files from this task
     */
    public function clearAttachments(Task $task): void
    {
        foreach ($task->attachments as $attachment) {
            $this->deleteAttachment($attachment);
        }
        $task->load(['attachments']);
    }

    /**
     * Replace all old files with new ones
     * If no files given, then just clear all files only
     *
     * @param  array<int, UploadedFile>  $files
     */
    public function replaceAttachments(Task $task, array $files, int $uploadedBy): void
    {
        $this->clearAttachments($task);
        if (!empty($files)) {
            $this->addAttachments($task, $files, $uploadedBy);
        }
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
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['priority'])) {
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
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }
        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getTodayTasks(array $filters = [], int $perPage = 5): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->whereDate('work_date', today());

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['assigned_to'])) {
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

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (!empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (!empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', function ($q) use ($filters) {
                $q->where('users.id', $filters['assigned_to']);
            });
        }

        if (!empty($filters['from_date'])) {
            $query->whereDate('work_date', '>=', $filters['from_date']);
        }

        if (!empty($filters['to_date'])) {
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

    /**
     * Get today's tasks without pagination
     */
    public function getTodayTasksAll(array $filters = []): Collection
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->whereDate('work_date', today());

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '' && $filters['status'] !== null) {
            $query->where('status', $filters['status']);
        }

        // Apply priority filter
        if (isset($filters['priority']) && $filters['priority'] !== '' && $filters['priority'] !== null) {
            $query->where('priority', $filters['priority']);
        }

        // Apply assigned user filter
        if (isset($filters['assigned_to']) && $filters['assigned_to'] !== '' && $filters['assigned_to'] !== null) {
            $query->whereHas('assignedUsers', function ($q) use ($filters) {
                $q->where('users.id', $filters['assigned_to']);
            });
        }

        return $query->orderByRaw('CASE WHEN work_time IS NULL THEN 1 ELSE 0 END')
            ->orderBy('work_time', 'asc')
            ->get();
    }

    /**
     * Get all tasks with filters without pagination
     */
    public function getAllTasksFilteredAll(array $filters = []): Collection
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments']);

        // Apply search filter
        if (isset($filters['search']) && $filters['search'] !== '' && $filters['search'] !== null) {
            $query->where(function ($q) use ($filters) {
                $q->where('title', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        // Apply status filter
        if (isset($filters['status']) && $filters['status'] !== '' && $filters['status'] !== null) {
            $query->where('status', $filters['status']);
        }

        // Apply priority filter
        if (isset($filters['priority']) && $filters['priority'] !== '' && $filters['priority'] !== null) {
            $query->where('priority', $filters['priority']);
        }

        // Apply assigned user filter
        if (isset($filters['assigned_to']) && $filters['assigned_to'] !== '' && $filters['assigned_to'] !== null) {
            $query->whereHas('assignedUsers', function ($q) use ($filters) {
                $q->where('users.id', $filters['assigned_to']);
            });
        }

        // Apply date range filters
        if (isset($filters['from_date']) && $filters['from_date'] !== '' && $filters['from_date'] !== null) {
            $query->whereDate('work_date', '>=', $filters['from_date']);
        }

        if (isset($filters['to_date']) && $filters['to_date'] !== '' && $filters['to_date'] !== null) {
            $query->whereDate('work_date', '<=', $filters['to_date']);
        }

        return $query->orderBy('work_date', 'desc')
            ->orderBy('work_time', 'desc')
            ->get();
    }
}
