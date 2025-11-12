<?php

namespace App\Livewire\Tasks;

use App\Services\TaskService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class AllTasks extends Component
{
    public ?string $search = null;

    public ?string $statusFilter = null;

    public ?string $fromDate = null;

    public ?string $toDate = null;

    #[On('task-saved')]
    public function refreshTasks(): void
    {
        // This will trigger a re-render and refresh the tasks list
    }

    public function updatedSearch($value): void
    {
        // Trim and reset to null if empty
        $this->search = trim($value) === '' ? null : trim($value);
    }

    public function updatedStatusFilter($value): void
    {
        // Reset to null if empty string is selected, otherwise keep the value
        $this->statusFilter = ($value === '' || $value === null) ? null : $value;

        // Log for debugging
        \Log::info('Status Filter Updated', [
            'value' => $value,
            'statusFilter' => $this->statusFilter,
        ]);
    }

    public function updatedFromDate($value): void
    {
        // Reset to null if empty
        $this->fromDate = ($value === '' || $value === null) ? null : $value;
    }

    public function updatedToDate($value): void
    {
        // Reset to null if empty
        $this->toDate = ($value === '' || $value === null) ? null : $value;
    }

    public function clearFilters(): void
    {
        $this->search = null;
        $this->statusFilter = null;
        $this->fromDate = null;
        $this->toDate = null;
    }

    public function render(TaskService $taskService): View
    {
        // Build filters array, only including non-null and non-empty values
        $filters = [];

        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }

        if ($this->statusFilter !== null && $this->statusFilter !== '') {
            $filters['status'] = $this->statusFilter;
        }

        if ($this->fromDate !== null && $this->fromDate !== '') {
            $filters['from_date'] = $this->fromDate;
        }

        if ($this->toDate !== null && $this->toDate !== '') {
            $filters['to_date'] = $this->toDate;
        }

        // Get all tasks with filters
        $tasks = $taskService->getAllTasksFilteredAll($filters);

        // Debug logging (can be removed after testing)
        \Log::info('AllTasks Filters', [
            'search' => $this->search,
            'statusFilter' => $this->statusFilter,
            'fromDate' => $this->fromDate,
            'toDate' => $this->toDate,
            'applied_filters' => $filters,
            'task_count' => $tasks->count(),
        ]);

        return view('livewire.tasks.all-tasks', [
            'tasks' => $tasks,
        ])->layout('components.layouts.app', ['title' => __('All Tasks')]);
    }
}
