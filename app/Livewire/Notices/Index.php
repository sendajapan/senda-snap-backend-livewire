<?php

declare(strict_types=1);

namespace App\Livewire\Notices;

use App\Services\NoticeService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public function mount(): void
    {
        // Only admin can access notices
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Only administrators can manage notices.');
        }
    }

    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
        $this->resetPage();
    }

    #[On('notice-saved')]
    public function refreshNotices(): void
    {
        $this->resetPage();
    }

    #[On('delete-notice')]
    public function deleteNotice(array $payload, NoticeService $noticeService): void
    {
        $noticeId = $payload['noticeId'] ?? null;
        if ($noticeId) {
            try {
                $notice = $noticeService->getById($noticeId);
                $noticeService->delete($notice);
                $this->dispatch('notify', message: __('Notice deleted successfully.'), type: 'success');
            } catch (\Exception $e) {
                \Log::error('Notice delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the notice.'), type: 'error');
            }
        }
    }

    public function render(NoticeService $noticeService): View
    {
        $filters = [];
        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }

        $notices = $noticeService->list($filters, 15);

        return view('livewire.notices.index', [
            'notices' => $notices,
        ])->layout('components.layouts.app', ['title' => __('Notices')]);
    }
}
