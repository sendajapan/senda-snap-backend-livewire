<?php

namespace App\Livewire\Users;

use App\Models\Notice;
use App\Models\Schedule;
use App\Models\ScheduleStopover;
use App\Services\UserService;
use Exception;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Log;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $roleFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedRoleFilter(): void
    {
        $this->resetPage();
    }

    #[On('user-saved')]
    public function refreshUsers(): void
    {
        // This will trigger a re-render and refresh the users list
    }

    #[On('delete-user')]
    public function deleteUser($userId = null, ?UserService $userService = null): void
    {
        // Handle both direct userId parameter and object/array with userId property
        if (is_array($userId)) {
            $userId = $userId['userId'] ?? null;
        } elseif (is_object($userId)) {
            $userId = $userId->userId ?? null;
        }

        if (! $userId) {
            return;
        }

        try {
            if (! $userService) {
                $userService = app(UserService::class);
            }
            $user = $userService->getById($userId);

            // Check for child records that will be cascade deleted
            $noticeCount = Notice::where('created_by', $userId)->count();
            $scheduleCount = Schedule::where('added_by', $userId)->count();
            $stopoverCount = ScheduleStopover::where('added_by', $userId)->count();

            $warnings = [];
            if ($noticeCount > 0) {
                $warnings[] = __(':count notice(s)', ['count' => $noticeCount]);
            }
            if ($scheduleCount > 0) {
                $warnings[] = __(':count schedule(s)', ['count' => $scheduleCount]);
            }
            if ($stopoverCount > 0) {
                $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
            }

            $userService->delete($user);
            $this->dispatch('notify', message: __('User deleted successfully.'), type: 'success');
        } catch (Exception $e) {
            Log::error('User delete error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while deleting the user.'), type: 'error');
        }
    }

    /**
     * Get child record warnings for a user
     */
    public function getUserWarnings(int $userId): array
    {
        $noticeCount = Notice::where('created_by', $userId)->count();
        $scheduleCount = Schedule::where('added_by', $userId)->count();
        $stopoverCount = ScheduleStopover::where('added_by', $userId)->count();

        $warnings = [];
        if ($noticeCount > 0) {
            $warnings[] = __(':count notice(s)', ['count' => $noticeCount]);
        }
        if ($scheduleCount > 0) {
            $warnings[] = __(':count schedule(s)', ['count' => $scheduleCount]);
        }
        if ($stopoverCount > 0) {
            $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
        }

        return $warnings;
    }

    public function render(UserService $userService)
    {
        $filters = [
            'search' => $this->search,
            'role' => $this->roleFilter,
        ];

        $users = $userService->getPaginated($filters);

        return view('livewire.users.index', [
            'users' => $users,
        ])->layout('components.layouts.app', ['title' => __('Users')]);
    }
}
