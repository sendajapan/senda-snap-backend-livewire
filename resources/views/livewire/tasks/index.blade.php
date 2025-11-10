<div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Tasks') }}</flux:heading>
                <flux:text>{{ __('Manage all tasks') }}</flux:text>
            </div>
            <flux:button :href="route('tasks.create')" icon="plus" wire:navigate>
                {{ __('Add Task') }}
            </flux:button>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Search tasks...') }}" icon="magnifying-glass" />
                </div>
                <div class="w-40">
                    <flux:select wire:model.live="statusFilter">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="running">{{ __('Running') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                        <option value="cancelled">{{ __('Cancelled') }}</option>
                    </flux:select>
                </div>
                <div class="w-40">
                    <flux:select wire:model.live="priorityFilter">
                        <option value="">{{ __('All Priority') }}</option>
                        <option value="low">{{ __('Low') }}</option>
                        <option value="medium">{{ __('Medium') }}</option>
                        <option value="high">{{ __('High') }}</option>
                        <option value="urgent">{{ __('Urgent') }}</option>
                    </flux:select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Title') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Vehicle') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Assigned To') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Priority') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Status') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Due Date') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        @forelse($tasks as $task)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $task->title }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $task->vehicle->serial_number ?? '-' }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $task->assignedUser->name ?? '-' }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <flux:badge :color="match($task->priority) { 'urgent' => 'red', 'high' => 'orange', 'medium' => 'yellow', default => 'gray' }">
                                        {{ ucfirst($task->priority) }}
                                    </flux:badge>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <flux:badge :color="match($task->status) { 'completed' => 'green', 'running' => 'blue', 'cancelled' => 'red', default => 'gray' }">
                                        {{ ucfirst($task->status) }}
                                    </flux:badge>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $task->due_date?->format('M d, Y') ?? '-' }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex gap-2">
                                        <flux:button size="sm" variant="ghost" :href="route('tasks.show', $task)" icon="eye" wire:navigate></flux:button>
                                        <flux:button size="sm" variant="ghost" :href="route('tasks.edit', $task)" icon="pencil" wire:navigate></flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No tasks found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $tasks->links() }}</div>
        </div>
</div>
