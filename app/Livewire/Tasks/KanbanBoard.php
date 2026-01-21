<?php

declare(strict_types=1);

namespace App\Livewire\Tasks;

use App\Services\TaskService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class KanbanBoard extends Component
{
    public ?string $search = null;

    public ?string $priorityFilter = null;

    public ?string $assignedToFilter = null;

    public ?string $fromDate = null;

    public ?string $toDate = null;

    public int $refreshKey = 0;

    /**
     * Mount the component and set default date filters.
     */
    public function mount(): void
    {
        // Set default date range: first day of current month to today
        $this->fromDate = now()->startOfMonth()->format('Y-m-d');
        $this->toDate = now()->format('Y-m-d');
    }

    #[On('task-saved')]
    public function refreshTasks(): void
    {
        // This will trigger a re-render and refresh the tasks
        // The refreshKey is already incremented in updateTaskStatus()
    }

    #[On('delete-task')]
    public function deleteTask($taskId, TaskService $taskService): void
    {
        // Handle both direct taskId parameter and object with taskId property
        if (is_array($taskId) || is_object($taskId)) {
            $taskId = is_array($taskId) ? ($taskId['taskId'] ?? null) : ($taskId->taskId ?? null);
        }

        if ($taskId) {
            try {
                $task = $taskService->getTaskById($taskId);
                $taskService->delete($task);
                $this->dispatch('notify', message: __('Task deleted successfully.'), type: 'success');
            } catch (\Exception $e) {
                \Log::error('Task delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the task.'), type: 'error');
            }
        }
    }

    /**
     * Get child record warnings for a task
     */
    public function getTaskWarnings(int $taskId): array
    {
        $task = \App\Models\Task::withCount('attachments')->findOrFail($taskId);
        $warnings = [];

        if ($task->attachments_count > 0) {
            $warnings[] = __(':count attachment(s)', ['count' => $task->attachments_count]);
        }

        return $warnings;
    }

    /**
     * Update task status when dragged to a new column
     */
    public function updateTaskStatus(int $taskId, string $newStatus, TaskService $taskService): void
    {
        try {
            $task = $taskService->getTaskById($taskId);
            $taskService->updateStatus($task, $newStatus);

            // Increment refresh key to force Livewire to completely re-render all columns
            // The wire:key change will trigger a full re-render of the Kanban board
            $this->refreshKey++;

            $this->dispatch('notify', message: __('Task status updated successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Task status update error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while updating the task status.'), type: 'error');
        }
    }

    public function updatedSearch($value): void
    {
        $this->search = trim($value) === '' ? null : trim($value);
        // Force refresh by incrementing refreshKey to ensure view updates
        $this->refreshKey++;
    }

    public function updatedPriorityFilter($value): void
    {
        $trimmedValue = is_string($value) ? trim($value) : $value;
        $this->priorityFilter = ($trimmedValue === '' || $trimmedValue === null) ? null : $trimmedValue;
        // Force refresh by incrementing refreshKey to ensure view updates
        $this->refreshKey++;
        \Log::info('updatedPriorityFilter called', [
            'original_value' => $value,
            'trimmed_value' => $trimmedValue,
            'final_value' => $this->priorityFilter,
        ]);
    }

    public function updatedAssignedToFilter($value): void
    {
        $this->assignedToFilter = ($value === '' || $value === null) ? null : $value;
        // Force refresh by incrementing refreshKey to ensure view updates
        $this->refreshKey++;
    }

    public function updatedFromDate($value): void
    {
        $this->fromDate = ($value === '' || $value === null) ? null : $value;
        // Force refresh by incrementing refreshKey to ensure view updates
        $this->refreshKey++;
    }

    public function updatedToDate($value): void
    {
        $this->toDate = ($value === '' || $value === null) ? null : $value;
        // Force refresh by incrementing refreshKey to ensure view updates
        $this->refreshKey++;
    }

    public function clearFilters(): void
    {
        $this->search = null;
        $this->priorityFilter = null;
        $this->assignedToFilter = null;
        // Reset to default date range: first day of current month to today
        $this->fromDate = now()->startOfMonth()->format('Y-m-d');
        $this->toDate = now()->format('Y-m-d');
    }

    public function render(TaskService $taskService): View
    {
        // Build filters array, only including non-null and non-empty values
        $filters = [];

        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }

        if ($this->priorityFilter !== null && $this->priorityFilter !== '') {
            $filters['priority'] = $this->priorityFilter;
        }

        if ($this->assignedToFilter !== null && $this->assignedToFilter !== '') {
            $filters['assigned_to'] = $this->assignedToFilter;
        }

        if ($this->fromDate !== null && $this->fromDate !== '') {
            $filters['from_date'] = $this->fromDate;
        }

        if ($this->toDate !== null && $this->toDate !== '') {
            $filters['to_date'] = $this->toDate;
        }

        // Debug logging for priority filter
        \Log::info('KanbanBoard Filters', [
            'priorityFilter' => $this->priorityFilter,
            'filters' => $filters,
        ]);

        // Get tasks grouped by status
        $tasksByStatus = $taskService->getTasksGroupedByStatus($filters);

        // Get all users for filter dropdown
        $users = \App\Models\User::orderBy('name')->get();

        return view('livewire.tasks.kanban-board', [
            'tasksByStatus' => $tasksByStatus,
            'users' => $users,
        ])->layout('components.layouts.app', ['title' => __('Kanban Board')]);
    }
}
