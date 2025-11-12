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
