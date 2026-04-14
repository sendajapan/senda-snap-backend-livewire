<?php

namespace App\Livewire\Users;

use App\Models\User;
use App\Services\UserService;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class UserModal extends Component
{
    use WithFileUploads;

    public bool $open = false;

    public ?User $user = null;

    public bool $isEditing = false;

    // Form fields
    public string $name = '';

    public string $email = '';

    public string $password = '';

    public string $password_confirmation = '';

    public string $role = 'client';

    public string $phone = '';

    public string $avis_id = '';

    public $avatar = null;

    public ?string $existing_avatar = null;

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,'.($this->user->id ?? 'NULL')],
            'role' => ['required', 'in:admin,manager,employee,client'],
            'phone' => ['nullable', 'string', 'max:20'],
            'avis_id' => ['nullable', 'string', 'max:255'],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ];

        if (! $this->isEditing) {
            $rules['password'] = ['required', 'string', 'min:8', 'confirmed'];
        } elseif (! empty($this->password)) {
            $rules['password'] = ['string', 'min:8', 'confirmed'];
        }

        return $rules;
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 8 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
            'role.required' => 'Role is required.',
            'avatar.image' => 'Avatar must be an image.',
            'avatar.max' => 'Avatar size must not exceed 2MB.',
        ];
    }

    #[On('open-user-modal')]
    public function openModal(?int $userId = null): void
    {
        $this->resetForm();

        if ($userId) {
            $this->user = User::findOrFail($userId);
            $this->isEditing = true;
            $this->name = $this->user->name;
            $this->email = $this->user->email;
            $this->role = $this->user->role;
            $this->phone = $this->user->phone ?? '';
            $this->avis_id = $this->user->avis_id ?? '';
            $this->existing_avatar = $this->user->avatar;
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
        $this->user = null;
        $this->isEditing = false;
        $this->name = '';
        $this->email = '';
        $this->password = '';
        $this->password_confirmation = '';
        $this->role = 'client';
        $this->phone = '';
        $this->avis_id = '';
        $this->avatar = null;
        $this->existing_avatar = null;
        $this->resetValidation();
    }

    public function removeAvatar(UserService $userService): void
    {
        if ($this->isEditing && $this->user && $this->user->avatar) {
            $userService->removeAvatar($this->user);
            $this->existing_avatar = null;
        }
        $this->avatar = null;
    }

    public function save(UserService $userService): void
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'role' => $this->role,
                'phone' => $this->phone ?: null,
                'avis_id' => $this->avis_id ?: null,
            ];

            if (! $this->isEditing || ! empty($this->password)) {
                $data['password'] = $this->password;
            }

            // Handle avatar upload
            if ($this->avatar && is_object($this->avatar) && method_exists($this->avatar, 'store')) {
                $data['avatar'] = $this->avatar;
            }

            if ($this->isEditing) {
                $userService->update($this->user, $data);
                $message = 'User updated successfully.';
            } else {
                $userService->create($data);
                $message = 'User created successfully.';
            }

            $this->dispatch('user-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('User save error: '.$e->getMessage());
            $this->dispatch('notify', message: 'An error occurred. Please try again.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.users.user-modal');
    }
}
