<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\TaskAttachment;
use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class TaskModal extends Component
{
    use WithFileUploads;

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

    public array $assigned_to = [];

    public string $due_date = '';

    public array $attachments = [];

    public array $existingAttachments = [];

    protected function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'work_date' => ['nullable', 'date'],
            'work_time' => ['nullable', 'string'],
            'status' => ['required', 'in:pending,running,completed,cancelled'],
            'priority' => ['required', 'in:low,medium,high,urgent'],
            'assigned_to' => ['nullable', 'array'],
            'assigned_to.*' => ['exists:users,id'],
            'due_date' => ['nullable', 'date'],
            'attachments.*' => ['nullable', 'file', 'max:10240'], // 10MB max per file
        ];
    }

    protected function messages(): array
    {
        return [
            'title.required' => 'Task title is required.',
            'status.required' => 'Status is required.',
            'priority.required' => 'Priority is required.',
            'assigned_to.*.exists' => 'One or more selected users do not exist.',
        ];
    }

    #[On('open-task-modal')]
    public function openModal(?int $taskId = null): void
    {
        $this->resetForm();

        if ($taskId) {
            $this->task = Task::with(['assignedUsers', 'attachments.uploader'])->findOrFail($taskId);
            $this->isEditing = true;
            $this->title = $this->task->title;
            $this->description = $this->task->description ?? '';
            $this->work_date = $this->task->work_date?->format('Y-m-d') ?? '';
            $this->work_time = $this->task->work_time ?? '';
            $this->status = $this->task->status;
            $this->priority = $this->task->priority;
            $this->assigned_to = $this->task->assignedUsers->pluck('id')->toArray();
            $this->due_date = $this->task->due_date?->format('Y-m-d') ?? '';
            $this->existingAttachments = $this->task->attachments->toArray();
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
        $this->assigned_to = [];
        $this->due_date = '';
        $this->attachments = [];
        $this->existingAttachments = [];
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
                'due_date' => $this->due_date ?: null,
            ];

            if ($this->isEditing) {
                $this->task->update($data);
                $this->task->assignedUsers()->sync($this->assigned_to);
                $task = $this->task;
                $message = 'Task updated successfully.';
            } else {
                $data['created_by'] = auth()->id();
                $task = Task::create($data);
                $task->assignedUsers()->sync($this->assigned_to);
                $message = 'Task created successfully.';
            }

            // Handle file uploads
            if (! empty($this->attachments)) {
                foreach ($this->attachments as $file) {
                    if (is_object($file) && method_exists($file, 'store')) {
                        $path = $file->store('task-attachments', 'public');
                        $task->attachments()->create([
                            'file_path' => $path,
                            'file_name' => $file->getClientOriginalName(),
                            'file_type' => $file->getMimeType(),
                            'uploaded_by' => auth()->id(),
                        ]);
                    }
                }
            }

            $this->dispatch('task-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Task save error: '.$e->getMessage());
            $this->dispatch('notify', message: 'An error occurred. Please try again.', type: 'error');
        }
    }

    public function deleteAttachment(int $attachmentId): void
    {
        try {
            $attachment = TaskAttachment::findOrFail($attachmentId);

            // Check if user has permission to delete
            if ($attachment->uploaded_by !== auth()->id() && ! in_array(auth()->user()->role, ['admin', 'manager'])) {
                $this->dispatch('notify', message: 'You do not have permission to delete this attachment.', type: 'error');

                return;
            }

            // Delete file from storage
            if (Storage::disk('public')->exists($attachment->file_path)) {
                Storage::disk('public')->delete($attachment->file_path);
            }

            // Delete record
            $attachment->delete();

            // Refresh existing attachments
            if ($this->task) {
                $this->existingAttachments = $this->task->fresh()->attachments->toArray();
            }

            $this->dispatch('notify', message: 'Attachment deleted successfully.', type: 'success');
        } catch (\Exception $e) {
            \Log::error('Attachment delete error: '.$e->getMessage());
            $this->dispatch('notify', message: 'An error occurred while deleting attachment.', type: 'error');
        }
    }

    public function removeNewAttachment(int $index): void
    {
        unset($this->attachments[$index]);
        $this->attachments = array_values($this->attachments);
    }

    public function render()
    {
        $users = User::orderBy('name')->get();

        return view('livewire.tasks.task-modal', [
            'users' => $users,
        ]);
    }
}
