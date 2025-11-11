<?php

use App\Models\Task;
use App\Models\User;
use App\Models\Vehicle;
use Livewire\Volt\Component;

new class extends Component {
    public string $title = '';
    public string $description = '';
    public string $work_date = '';
    public string $work_time = '';
    public string $priority = 'medium';
    public string $vehicle_id = '';
    public string $assigned_to = '';
    public string $due_date = '';

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'work_date' => 'required|date',
            'work_time' => 'required',
            'priority' => 'required|in:low,medium,high,urgent',
            'vehicle_id' => 'required|exists:vehicles,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date',
        ];
    }

    public function with(): array
    {
        return [
            'vehicles' => Vehicle::orderBy('serial_number')->get(),
            'users' => User::orderBy('name')->get(),
        ];
    }

    public function save(): void
    {
        $validated = $this->validate();
        $validated['created_by'] = auth()->id();
        Task::create($validated);
        session()->flash('success', 'Task created successfully.');
        $this->redirect(route('tasks.index'), navigate: true);
    }
}; ?>

<x-layouts.app :title="__('Create Task')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div>
            <flux:heading size="xl">{{ __('Create Task') }}</flux:heading>
            <flux:text>{{ __('Add a new task') }}</flux:text>
        </div>
        <div class="max-w-2xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <form wire:submit="save" class="space-y-6">
                <flux:field>
                    <flux:label>{{ __('Title') }}</flux:label>
                    <flux:input wire:model="title" />
                    <flux:error name="title" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('Description') }}</flux:label>
                    <flux:textarea wire:model="description" rows="4" />
                    <flux:error name="description" />
                </flux:field>
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Work Date') }}</flux:label>
                        <flux:input type="date" wire:model="work_date" />
                        <flux:error name="work_date" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Work Time') }}</flux:label>
                        <flux:input type="time" wire:model="work_time" />
                        <flux:error name="work_time" />
                    </flux:field>
                </div>
                <flux:field>
                    <flux:label>{{ __('Vehicle') }}</flux:label>
                    <flux:select wire:model="vehicle_id">
                        <option value="">{{ __('Select Vehicle') }}</option>
                        @foreach($vehicles as $vehicle)
                            <option value="{{ $vehicle->id }}">{{ $vehicle->serial_number }} - {{ $vehicle->make }} {{ $vehicle->model }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="vehicle_id" />
                </flux:field>
                <flux:field>
                    <flux:label>{{ __('Assigned To') }}</flux:label>
                    <flux:select wire:model="assigned_to">
                        <option value="">{{ __('Select User') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </flux:select>
                    <flux:error name="assigned_to" />
                </flux:field>
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Priority') }}</flux:label>
                        <flux:select wire:model="priority">
                            <option value="low">{{ __('Low') }}</option>
                            <option value="medium">{{ __('Medium') }}</option>
                            <option value="high">{{ __('High') }}</option>
                            <option value="urgent">{{ __('Urgent') }}</option>
                        </flux:select>
                        <flux:error name="priority" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Due Date') }}</flux:label>
                        <flux:input type="date" wire:model="due_date" />
                        <flux:error name="due_date" />
                    </flux:field>
                </div>
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">{{ __('Create Task') }}</flux:button>
                    <flux:button :href="route('tasks.index')" variant="ghost" wire:navigate>{{ __('Cancel') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
