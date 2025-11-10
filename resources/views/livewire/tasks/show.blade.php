<?php

use App\Models\Task;
use Livewire\Volt\Component;

new class extends Component {
    public Task $task;

    public function mount(Task $task): void
    {
        $this->task = $task->load(['vehicle', 'assignedUser', 'creator', 'attachments.uploader']);
    }
}; ?>

<x-layouts.app :title="__('Task Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ $task->title }}</flux:heading>
                <flux:text>{{ __('Task Details') }}</flux:text>
            </div>
            <flux:button :href="route('tasks.edit', $task)" icon="pencil" wire:navigate>
                {{ __('Edit Task') }}
            </flux:button>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="md:col-span-2 space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Task Information') }}</h3>
                    <dl class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Description') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->description }}</dd>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Work Date') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->work_date->format('M d, Y') }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Work Time') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->work_time }}</dd>
                            </div>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Vehicle') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $task->vehicle->serial_number }} - {{ $task->vehicle->make }} {{ $task->vehicle->model }}
                            </dd>
                        </div>
                        <div class="grid gap-4 md:grid-cols-2">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Assigned To') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->assignedUser->name }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Created By') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->creator->name }}</dd>
                            </div>
                        </div>
                    </dl>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Attachments') }}</h3>
                    @if($task->attachments->count() > 0)
                        <div class="space-y-3">
                            @foreach($task->attachments as $attachment)
                                <div class="flex items-center justify-between rounded-lg border border-gray-200 p-3 dark:border-gray-700">
                                    <div class="flex items-center gap-3">
                                        <flux:icon.document class="size-6 text-gray-400" />
                                        <div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $attachment->file_name }}</div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('Uploaded by :name', ['name' => $attachment->uploader->name]) }}</div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No attachments') }}</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Status') }}</h3>
                    <div class="space-y-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Priority') }}</dt>
                            <dd class="mt-1">
                                <flux:badge :color="match($task->priority) { 'urgent' => 'red', 'high' => 'orange', 'medium' => 'yellow', default => 'gray' }">
                                    {{ ucfirst($task->priority) }}
                                </flux:badge>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Status') }}</dt>
                            <dd class="mt-1">
                                <flux:badge :color="match($task->status) { 'completed' => 'green', 'running' => 'blue', 'cancelled' => 'red', default => 'gray' }">
                                    {{ ucfirst($task->status) }}
                                </flux:badge>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Due Date') }}</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->due_date?->format('M d, Y') ?? '-' }}</dd>
                        </div>
                        @if($task->completed_at)
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Completed At') }}</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $task->completed_at->format('M d, Y H:i') }}</dd>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-layouts.app>
