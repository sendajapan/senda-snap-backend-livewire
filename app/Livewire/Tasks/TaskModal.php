<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use Livewire\Attributes\On;
use Livewire\Component;

class TaskModal extends Component
{
    public bool $open = false;

    public ?Task $task = null;

    public bool $isEditing = false;

    // Form fields
    public string $title = '';

    public string $description = '';

    public string $work_date = '';

    public string $work_time = '';

    public string $status = 'pending';

    public string $priority = 'medium';

    public ?int $vehicle_id = null;

    public ?int $assigned_to = null;

    public string $due_date = '';

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'work_date' => ['nullable', 'date'],
            'work_time' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,running,completed,cancelled'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'vehicle_id' => ['nullable', 'exists:vehicles,id'],
            'assigned_to' => ['nullable', 'exists:users,id'],
            'due_date' => ['nullable', 'date'],
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'status.required' => 'Status is required.',
            'priority.required' => 'Priority is required.',
            'vehicle_id.exists' => 'Selected vehicle does not exist.',
            'assigned_to.exists' => 'Selected user does not exist.',
        ];
    }

    #[On('open-task-modal')]
    public function openModal(?int $taskId = null): void
    {
        $this->resetForm();

        if ($taskId) {
            $this->task = Task::findOrFail($taskId);
            $this->isEditing = true;
            $this->title = $this->task->title;
            $this->description = $this->task->description ?? '';
            $this->work_date = $this->task->work_date?->format('Y-m-d') ?? '';
            $this->work_time = $this->task->work_time ?? '';
            $this->status = $this->task->status;
            $this->priority = $this->task->priority;
            $this->vehicle_id = $this->task->vehicle_id;
            $this->assigned_to = $this->task->assigned_to;
            $this->due_date = $this->task->due_date?->format('Y-m-d') ?? '';
        } else {
            $this->isEditing = false;
        }

        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->task = null;
        $this->isEditing = false;
        $this->title = '';
        $this->description = '';
        $this->work_date = '';
        $this->work_time = '';
        $this->status = 'pending';
        $this->priority = 'medium';
        $this->vehicle_id = null;
        $this->assigned_to = null;
        $this->due_date = '';
        $this->resetValidation();
    }

    public function save(): void
    {
        $this->validate();

        try {
            $data = [
                'title' => $this->title,
                'description' => $this->description ?: null,
                'work_date' => $this->work_date ?: null,
                'work_time' => $this->work_time ?: null,
                'status' => $this->status,
                'priority' => $this->priority,
                'vehicle_id' => $this->vehicle_id,
                'assigned_to' => $this->assigned_to,
                'due_date' => $this->due_date ?: null,
            ];

            if ($this->isEditing) {
                $this->task->update($data);
                $message = 'Task updated successfully.';
            } else {
                $data['created_by'] = auth()->id();
                Task::create($data);
                $message = 'Task created successfully.';
            }

            $this->dispatch('task-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'An error occurred. Please try again.', type: 'error');
        }
    }

    public function render()
    {
        $vehicles = Vehicle::orderBy('serial_number')->get();
        $users = User::orderBy('name')->get();

        return view('livewire.tasks.task-modal', [
            'vehicles' => $vehicles,
            'users' => $users,
        ]);
    }
}
