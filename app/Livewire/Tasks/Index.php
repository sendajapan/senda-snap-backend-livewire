<?php

namespace App\Livewire\Tasks;

use App\Services\TaskService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public string $priorityFilter = '';

    public string $fromDate = '';

    public string $toDate = '';

    public string $assignedToFilter = '';

    // Separate filters for today's tasks
    public string $todayStatusFilter = '';

    public string $todayPriorityFilter = '';

    public string $todayAssignedToFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage('allTasksPage');
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage('allTasksPage');
    }

    public function updatedPriorityFilter(): void
    {
        $this->resetPage('allTasksPage');
    }

    public function updatedFromDate(): void
    {
        $this->resetPage('allTasksPage');
    }

    public function updatedToDate(): void
    {
        $this->resetPage('allTasksPage');
    }

    public function updatedAssignedToFilter(): void
    {
        $this->resetPage('allTasksPage');
    }

    public function updatedTodayStatusFilter(): void
    {
        $this->resetPage('todayTasksPage');
    }

    public function updatedTodayPriorityFilter(): void
    {
        $this->resetPage('todayTasksPage');
    }

    public function updatedTodayAssignedToFilter(): void
    {
        $this->resetPage('todayTasksPage');
    }

    #[On('task-saved')]
    public function refreshTasks(): void
    {
        // This will trigger a re-render and refresh the tasks list
    }

    public function render(TaskService $taskService): View
    {
        // Today's tasks - sorted by work_time ascending (earliest first)
        $todayFilters = [
            'status' => $this->todayStatusFilter !== '' ? $this->todayStatusFilter : null,
            'priority' => $this->todayPriorityFilter !== '' ? $this->todayPriorityFilter : null,
            'assigned_to' => $this->todayAssignedToFilter !== '' ? $this->todayAssignedToFilter : null,
        ];
        $todayTasks = $taskService->getTodayTasks($todayFilters, 5);

        // All tasks with date range filter
        $allTasksFilters = [
            'search' => $this->search,
            'status' => $this->statusFilter !== '' ? $this->statusFilter : null,
            'priority' => $this->priorityFilter !== '' ? $this->priorityFilter : null,
            'assigned_to' => $this->assignedToFilter !== '' ? $this->assignedToFilter : null,
            'from_date' => $this->fromDate,
            'to_date' => $this->toDate,
        ];
        $allTasks = $taskService->getAllTasksFiltered($allTasksFilters, 50, 'allTasksPage');

        // Get all users for the filter dropdowns
        $users = \App\Models\User::orderBy('name')->get();

        return view('livewire.tasks.index', [
            'todayTasks' => $todayTasks,
            'allTasks' => $allTasks,
            'users' => $users,
        ])->layout('components.layouts.app', ['title' => __('Tasks')]);
    }
}
