<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Services\TaskService;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskPreview extends Component
{
    public bool $open = false;

    public ?Task $task = null;

    #[On('open-task-preview')]
    public function openPreview(?int $taskId, TaskService $taskService): void
    {
        if ($taskId) {
            $this->task = $taskService->getTaskById($taskId);
        } else {
            $this->task = null;
        }

        $this->open = true;
    }

    public function closePreview(): void
    {
        $this->open = false;
        $this->task = null;
    }

    public function editTask(): void
    {
        if ($this->task) {
            $this->dispatch('open-task-modal', taskId: $this->task->id);
            $this->closePreview();
        }
    }

    public function deleteTask(TaskService $taskService): void
    {
        if ($this->task) {
            try {
                $taskService->delete($this->task);
                $this->dispatch('task-saved');
                $this->dispatch('notify', message: __('Task deleted successfully.'), type: 'success');
                $this->closePreview();
            } catch (\Exception $e) {
                \Log::error('Task delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the task.'), type: 'error');
            }
        }
    }

    public function canDelete(): bool
    {
        $currentUser = auth()->user();
        if (! $currentUser) {
            return false;
        }

        // Only admin or manager can delete
        return in_array($currentUser->role, ['admin', 'manager']);
    }

    public function render()
    {
        return view('livewire.tasks.task-preview');
    }
}
