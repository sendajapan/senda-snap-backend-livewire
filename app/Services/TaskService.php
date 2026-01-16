<?php

namespace App\Services;

use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

/**
 * Task Service
 *
 * Tasks belong to vendors. Users can only see tasks within their vendor.
 * Admin users can see all tasks.
 */
class TaskService
{
    // ========================================
    // List / Query Methods
    // ========================================

    public function list(array $filters = [], int $perPage = 100): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forCurrentVendor();

        $this->applyFilters($query, $filters);

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getTaskById(int $taskId): Task
    {
        return Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forCurrentVendor()
            ->findOrFail($taskId);
    }

    public function getMyTasks(int $userId, array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forCurrentVendor()
            ->where('created_by', $userId);

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
            ->forCurrentVendor()
            ->whereHas('assignedUsers', fn ($q) => $q->where('users.id', $userId));

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
            ->forCurrentVendor()
            ->whereDate('work_date', today());

        $this->applyBasicFilters($query, $filters);

        return $query
            ->orderByRaw('CASE WHEN work_time IS NULL THEN 1 ELSE 0 END')
            ->orderBy('work_time', 'asc')
            ->paginate($perPage, ['*'], 'todayTasksPage');
    }

    public function getTodayTasksAll(array $filters = []): Collection
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forCurrentVendor()
            ->whereDate('work_date', today());

        $this->applyBasicFilters($query, $filters);

        return $query
            ->orderByRaw('CASE WHEN work_time IS NULL THEN 1 ELSE 0 END')
            ->orderBy('work_time', 'asc')
            ->get();
    }

    public function getAllTasksFiltered(array $filters = [], int $perPage = 50, string $pageName = 'allTasksPage'): LengthAwarePaginator
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forCurrentVendor();

        $this->applyFilters($query, $filters);

        return $query
            ->orderBy('work_date', 'desc')
            ->orderBy('work_time', 'desc')
            ->paginate($perPage, ['*'], $pageName);
    }

    public function getAllTasksFilteredAll(array $filters = []): Collection
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forCurrentVendor();

        $this->applyFilters($query, $filters);

        return $query
            ->orderBy('work_date', 'desc')
            ->orderBy('work_time', 'desc')
            ->get();
    }

    public function getTasksGroupedByStatus(array $filters = []): array
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->forCurrentVendor();

        $this->applyFilters($query, $filters, ['status']);

        $tasks = $query->orderBy('created_at', 'desc')->get();

        return [
            'pending' => $tasks->where('status', 'pending')->values(),
            'running' => $tasks->where('status', 'running')->values(),
            'completed' => $tasks->where('status', 'completed')->values(),
            'cancelled' => $tasks->where('status', 'cancelled')->values(),
        ];
    }

    // ========================================
    // CRUD Methods
    // ========================================

    public function create(array $data, array $assignedUserIds = []): Task
    {
        // Auto-assign vendor_id from current user
        $user = auth()->user();
        $vendorId = $data['vendor_id'] ?? $user?->vendor_id;

        $task = Task::create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'work_date' => $data['work_date'] ?? null,
            'work_time' => $data['work_time'] ?? null,
            'priority' => $data['priority'],
            'status' => $data['status'] ?? 'pending',
            'created_by' => $data['created_by'],
            'due_date' => $data['due_date'] ?? null,
            'vendor_id' => $vendorId,
        ]);

        if (! empty($assignedUserIds)) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        return $task->load(['assignedUsers', 'creator', 'attachments']);
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

        if ($assignedUserIds !== null) {
            $task->assignedUsers()->sync($assignedUserIds);
        }

        return $task->load(['assignedUsers', 'creator', 'attachments']);
    }

    public function delete(Task $task): bool
    {
        foreach ($task->attachments as $attachment) {
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }
        }

        return $task->delete();
    }

    public function updateStatus(Task $task, string $status): Task
    {
        $task->update([
            'status' => $status,
            'completed_at' => $status === 'completed' ? now() : null,
        ]);

        return $task->fresh()->load(['assignedUsers', 'creator', 'attachments']);
    }

    public function assign(Task $task, array $userIds): Task
    {
        $task->assignedUsers()->sync($userIds);

        return $task->load(['assignedUsers', 'creator', 'attachments']);
    }

    // ========================================
    // Attachment Methods
    // ========================================

    public function addAttachments(Task $task, array $files, int $uploadedBy): void
    {
        foreach ($files as $file) {
            $this->uploadAttachment($task, $file, $uploadedBy);
        }
        $task->load('attachments');
    }

    public function clearAttachments(Task $task): void
    {
        foreach ($task->attachments as $attachment) {
            $this->deleteAttachment($attachment);
        }
        $task->load('attachments');
    }

    public function replaceAttachments(Task $task, array $files, int $uploadedBy): void
    {
        $this->clearAttachments($task);

        if (! empty($files)) {
            $this->addAttachments($task, $files, $uploadedBy);
        }
    }

    public function uploadAttachment(Task $task, UploadedFile $file, int $uploadedBy, ?string $fileName = null): TaskAttachment
    {
        $filePath = $file->store('task-attachments', 'public');

        return $task->attachments()->create([
            'file_path' => $filePath,
            'file_name' => $fileName ?? $file->getClientOriginalName(),
            'file_type' => $file->getClientMimeType(),
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

    // ========================================
    // Private Filter Methods
    // ========================================

    private function applyFilters($query, array $filters, array $exclude = []): void
    {
        if (! empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        if (! in_array('status', $exclude) && ! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (! empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', fn ($q) => $q->where('users.id', $filters['assigned_to']));
        }

        if (! empty($filters['date_from']) || ! empty($filters['from_date'])) {
            $date = $filters['date_from'] ?? $filters['from_date'];
            $query->whereDate('work_date', '>=', $date);
        }

        if (! empty($filters['date_to']) || ! empty($filters['to_date'])) {
            $date = $filters['date_to'] ?? $filters['to_date'];
            $query->whereDate('work_date', '<=', $date);
        }
    }

    private function applyBasicFilters($query, array $filters): void
    {
        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['priority'])) {
            $query->where('priority', $filters['priority']);
        }

        if (! empty($filters['assigned_to'])) {
            $query->whereHas('assignedUsers', fn ($q) => $q->where('users.id', $filters['assigned_to']));
        }
    }
}
