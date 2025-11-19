<?php

namespace App\Livewire\Users;

use App\Services\UserService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

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
    public function deleteUser(array $payload, UserService $userService): void
    {
        $userId = $payload['userId'] ?? null;
        if ($userId) {
            try {
                $user = $userService->getById($userId);
                $userService->delete($user);
                $this->dispatch('notify', message: __('User deleted successfully.'), type: 'success');
            } catch (\Exception $e) {
                \Log::error('User delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the user.'), type: 'error');
            }
        }
    }

    public function render(UserService $userService)
    {
        $filters = [
            'search' => $this->search,
            'role' => $this->roleFilter,
        ];

        $users = $userService->getPaginated($filters, 10);

        return view('livewire.users.index', [
            'users' => $users,
        ])->layout('components.layouts.app', ['title' => __('Users')]);
    }
}
