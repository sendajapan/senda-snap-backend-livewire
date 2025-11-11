<?php

namespace App\Livewire\Users;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

    public $avatar;

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

    public function removeAvatar(): void
    {
        if ($this->isEditing && $this->user && $this->user->avatar) {
            Storage::disk('public')->delete($this->user->avatar);
            $this->user->update(['avatar' => null]);
            $this->existing_avatar = null;
        }
        $this->avatar = null;
    }

    public function save(): void
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
                $data['password'] = Hash::make($this->password);
            }

            // Handle avatar upload
            if ($this->avatar) {
                // Delete old avatar if editing
                if ($this->isEditing && $this->user && $this->user->avatar) {
                    Storage::disk('public')->delete($this->user->avatar);
                }

                $data['avatar'] = $this->avatar->store('avatars', 'public');
            }

            if ($this->isEditing) {
                $this->user->update($data);
                $message = 'User updated successfully.';
            } else {
                User::create($data);
                $message = 'User created successfully.';
            }

            $this->dispatch('user-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            $this->dispatch('notify', message: 'An error occurred. Please try again.', type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.users.user-modal');
    }
}
