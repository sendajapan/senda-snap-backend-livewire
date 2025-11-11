<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
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

    public function render(): View
    {
        // Today's tasks - sorted by work_time ascending (earliest first)
        $todayTasks = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->whereDate('work_date', today())
            ->when($this->todayStatusFilter !== '', fn ($q) => $q->where('status', $this->todayStatusFilter))
            ->when($this->todayPriorityFilter !== '', fn ($q) => $q->where('priority', $this->todayPriorityFilter))
            ->when($this->todayAssignedToFilter !== '', function ($q) {
                $q->whereHas('assignedUsers', function ($query) {
                    $query->where('users.id', $this->todayAssignedToFilter);
                });
            })
            ->orderByRaw('CASE WHEN work_time IS NULL THEN 1 ELSE 0 END')
            ->orderBy('work_time', 'asc')
            ->paginate(5, ['*'], 'todayTasksPage');

        // All tasks with date range filter
        $allTasksQuery = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter !== '', fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter !== '', fn ($q) => $q->where('priority', $this->priorityFilter))
            ->when($this->assignedToFilter !== '', function ($q) {
                $q->whereHas('assignedUsers', function ($query) {
                    $query->where('users.id', $this->assignedToFilter);
                });
            })
            ->when($this->fromDate, fn ($q) => $q->whereDate('work_date', '>=', $this->fromDate))
            ->when($this->toDate, fn ($q) => $q->whereDate('work_date', '<=', $this->toDate))
            ->orderBy('work_date', 'desc')
            ->orderBy('work_time', 'desc');

        $allTasks = $allTasksQuery->paginate(50, ['*'], 'allTasksPage');

        // Get all users for the filter dropdowns
        $users = \App\Models\User::orderBy('name')->get();

        return view('livewire.tasks.index', [
            'todayTasks' => $todayTasks,
            'allTasks' => $allTasks,
            'users' => $users,
        ])->layout('components.layouts.app', ['title' => __('Tasks')]);
    }
}
