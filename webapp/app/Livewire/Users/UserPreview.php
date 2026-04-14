<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UserPreview extends Component
{
    public bool $open = false;

    public ?User $user = null;

    #[On('open-user-preview')]
    public function openPreview(?int $userId, UserService $userService): void
    {
        if ($userId) {
            $this->user = $userService->getById($userId);
        } else {
            $this->user = null;
        }

        $this->open = true;
    }

    public function closePreview(): void
    {
        $this->open = false;
        $this->user = null;
    }

    public function editUser(): void
    {
        if ($this->user) {
            $this->dispatch('open-user-modal', userId: $this->user->id);
            $this->closePreview();
        }
    }

    public function deleteUser(UserService $userService): void
    {
        if ($this->user) {
            try {
                $userService->delete($this->user);
                $this->dispatch('user-saved');
                $this->dispatch('notify', message: __('User deleted successfully.'), type: 'success');
                $this->closePreview();
            } catch (\Exception $e) {
                \Log::error('User delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the user.'), type: 'error');
            }
        }
    }

    public function canDelete(): bool
    {
        $currentUser = Auth::user();
        if (! $currentUser || ! $this->user) {
            return false;
        }

        // Only admin or manager can delete
        if (! in_array($currentUser->role, ['admin', 'manager'])) {
            return false;
        }

        // Manager cannot delete their own account
        if ($currentUser->role === 'manager' && $currentUser->id === $this->user->id) {
            return false;
        }

        // Manager cannot delete admin accounts
        if ($currentUser->role === 'manager' && $this->user->role === 'admin') {
            return false;
        }

        return true;
    }

    public function render()
    {
        return view('livewire.users.user-preview');
    }
}
