<?php

declare(strict_types=1);

namespace App\Livewire\Notices;

use App\Models\Notice;
use App\Services\NoticeService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class NoticeModal extends Component
{
    public bool $open = false;

    public ?Notice $notice = null;

    public bool $isEditing = false;

    // Form fields
    public string $message = '';

    public bool $is_active = true;

    public ?string $starts_at = null;

    public ?string $ends_at = null;

    public function mount(): void
    {
        // Only admin can access notices
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Only administrators can manage notices.');
        }
    }

    protected function rules(): array
    {
        return [
            'message' => ['required', 'string', 'max:500'],
            'is_active' => ['boolean'],
            'starts_at' => ['nullable', 'date'],
            'ends_at' => ['nullable', 'date', 'after:starts_at'],
        ];
    }

    protected function messages(): array
    {
        return [
            'message.required' => 'Notice message is required.',
            'message.max' => 'Notice message must not exceed 500 characters.',
            'ends_at.after' => 'End date must be after start date.',
        ];
    }

    #[On('open-notice-modal')]
    public function openModal(?int $noticeId = null): void
    {
        $this->resetForm();

        if ($noticeId) {
            $this->notice = Notice::findOrFail($noticeId);
            $this->isEditing = true;
            $this->message = $this->notice->message;
            $this->is_active = $this->notice->is_active;
            $this->starts_at = $this->notice->starts_at?->format('Y-m-d\TH:i');
            $this->ends_at = $this->notice->ends_at?->format('Y-m-d\TH:i');
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
        $this->notice = null;
        $this->isEditing = false;
        $this->message = '';
        $this->is_active = true;
        $this->starts_at = null;
        $this->ends_at = null;
        $this->resetValidation();
    }

    public function save(NoticeService $noticeService): void
    {
        $this->validate();

        try {
            $data = [
                'message' => $this->message,
                'is_active' => $this->is_active,
                'starts_at' => $this->starts_at ?: null,
                'ends_at' => $this->ends_at ?: null,
            ];

            if ($this->isEditing && $this->notice) {
                $noticeService->update($this->notice, $data);
                $this->dispatch('notify', message: __('Notice updated successfully.'), type: 'success');
            } else {
                $noticeService->create($data);
                $this->dispatch('notify', message: __('Notice created successfully.'), type: 'success');
            }

            $this->dispatch('notice-saved');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Notice save error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while saving the notice.'), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.notices.notice-modal');
    }
}
