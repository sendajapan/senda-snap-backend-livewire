<?php

namespace App\Livewire\Tasks;

use App\Services\TaskService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class TodayTasks extends Component
{
    public ?string $statusFilter = null;

    #[On('task-saved')]
    public function refreshTasks(): void
    {
        // This will trigger a re-render and refresh the tasks list
    }

    #[On('delete-task')]
    public function deleteTask($taskId = null, TaskService $taskService): void
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

    public function updatedStatusFilter($value): void
    {
        // Reset to null if empty string is selected, otherwise keep the value
        $this->statusFilter = ($value === '' || $value === null) ? null : $value;

        // Log for debugging
        \Log::info('TodayTasks - Status Filter Updated', [
            'value' => $value,
            'statusFilter' => $this->statusFilter,
        ]);
    }

    public function clearFilters(): void
    {
        $this->statusFilter = null;
    }

    public function render(TaskService $taskService): View
    {
        // Build filters array, only including non-null and non-empty values
        $filters = [];

        if ($this->statusFilter !== null && $this->statusFilter !== '') {
            $filters['status'] = $this->statusFilter;
        }

        // Get today's tasks with filters
        $tasks = $taskService->getTodayTasksAll($filters);

        return view('livewire.tasks.today-tasks', [
            'tasks' => $tasks,
        ])->layout('components.layouts.app', ['title' => __("Today's Tasks")]);
    }
}
