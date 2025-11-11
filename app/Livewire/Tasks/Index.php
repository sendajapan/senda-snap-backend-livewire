<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
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

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function updatedPriorityFilter(): void
    {
        $this->resetPage();
    }

    public function updatedFromDate(): void
    {
        $this->resetPage();
    }

    public function updatedToDate(): void
    {
        $this->resetPage();
    }

    #[On('task-saved')]
    public function refreshTasks(): void
    {
        // This will trigger a re-render and refresh the tasks list
    }

    public function render()
    {
        // Today's tasks - sorted by work_time ascending (earliest first)
        $todayTasks = Task::with(['assignedUsers', 'creator'])
            ->whereDate('work_date', today())
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn ($q) => $q->where('priority', $this->priorityFilter))
            ->orderByRaw('CASE WHEN work_time IS NULL THEN 1 ELSE 0 END')
            ->orderBy('work_time', 'asc')
            ->get();

        // All tasks with date range filter
        $allTasksQuery = Task::with(['assignedUsers', 'creator'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn ($q) => $q->where('priority', $this->priorityFilter))
            ->when($this->fromDate, fn ($q) => $q->whereDate('work_date', '>=', $this->fromDate))
            ->when($this->toDate, fn ($q) => $q->whereDate('work_date', '<=', $this->toDate))
            ->orderBy('work_date', 'desc')
            ->orderBy('work_time', 'desc');

        $allTasks = $allTasksQuery->paginate(10);

        return view('livewire.tasks.index', [
            'todayTasks' => $todayTasks,
            'allTasks' => $allTasks,
        ])->layout('components.layouts.app', ['title' => __('Tasks')]);
    }
}
