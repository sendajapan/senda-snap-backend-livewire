<?php

use App\Models\User;
use Livewire\Volt\Component;
use Illuminate\Support\Facades\Hash;

new class extends Component {
    public string $name = '';
    public string $email = '';
    public string $password = '';
    public string $password_confirmation = '';
    public string $role = 'client';
    public string $phone = '';
    public string $avis_id = '';

    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,manager,employee,client',
            'phone' => 'nullable|string|max:20',
            'avis_id' => 'nullable|string|max:255',
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'phone' => $validated['phone'],
            'avis_id' => $validated['avis_id'],
        ]);

        session()->flash('success', 'User created successfully.');

        $this->redirect(route('users.index'), navigate: true);
    }
}; ?>

<x-layouts.app :title="__('Create User')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-6">
        <div>
            <flux:heading size="xl">{{ __('Create User') }}</flux:heading>
            <flux:text>{{ __('Add a new user to the system') }}</flux:text>
        </div>

        <div class="max-w-2xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <form wire:submit="save" class="space-y-6">
                <flux:field>
                    <flux:label>{{ __('Name') }}</flux:label>
                    <flux:input wire:model="name" placeholder="{{ __('Enter name') }}" />
                    <flux:error name="name" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Email') }}</flux:label>
                    <flux:input type="email" wire:model="email" placeholder="{{ __('Enter email') }}" />
                    <flux:error name="email" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Password') }}</flux:label>
                    <flux:input type="password" wire:model="password" placeholder="{{ __('Enter password') }}" />
                    <flux:error name="password" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Confirm Password') }}</flux:label>
                    <flux:input type="password" wire:model="password_confirmation" placeholder="{{ __('Confirm password') }}" />
                    <flux:error name="password_confirmation" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Role') }}</flux:label>
                    <flux:select wire:model="role">
                        <option value="client">{{ __('Client') }}</option>
                        <option value="employee">{{ __('Employee') }}</option>
                        <option value="manager">{{ __('Manager') }}</option>
                        <option value="admin">{{ __('Admin') }}</option>
                    </flux:select>
                    <flux:error name="role" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Phone') }}</flux:label>
                    <flux:input wire:model="phone" placeholder="{{ __('Enter phone number') }}" />
                    <flux:error name="phone" />
                </flux:field>

                <flux:field>
                    <flux:label>{{ __('Avis ID') }}</flux:label>
                    <flux:input wire:model="avis_id" placeholder="{{ __('Enter Avis ID') }}" />
                    <flux:error name="avis_id" />
                </flux:field>

                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">{{ __('Create User') }}</flux:button>
                    <flux:button :href="route('users.index')" variant="ghost" wire:navigate>{{ __('Cancel') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
