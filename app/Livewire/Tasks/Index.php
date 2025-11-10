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

    #[On('task-saved')]
    public function refreshTasks(): void
    {
        // This will trigger a re-render and refresh the tasks list
    }

    public function render()
    {
        $tasks = Task::with(['vehicle', 'assignedUser', 'creator'])
            ->when($this->search, function ($query) {
                $query->where(function ($q) {
                    $q->where('title', 'like', "%{$this->search}%")
                        ->orWhere('description', 'like', "%{$this->search}%");
                });
            })
            ->when($this->statusFilter, fn ($q) => $q->where('status', $this->statusFilter))
            ->when($this->priorityFilter, fn ($q) => $q->where('priority', $this->priorityFilter))
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('livewire.tasks.index', [
            'tasks' => $tasks,
        ])->layout('components.layouts.app', ['title' => __('Tasks')]);
    }
}
