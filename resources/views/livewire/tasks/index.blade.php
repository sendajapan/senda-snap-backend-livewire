<div class="flex h-full w-full flex-1 flex-col gap-6 p-6" x-data="{
    openModal(taskId = null) {
        $wire.$dispatch('open-task-modal', { taskId: taskId })
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Tasks Management')"
        :description="__('Manage all tasks and assignments')"
        variant="emerald">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Task') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="emerald">
        <div class="mb-4 flex gap-4">
            <div class="flex-1">
                <flux:input wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search by title or description...') }}" icon="magnifying-glass" />
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

        <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Title') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Vehicle') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Assigned To') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Priority') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Status') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Due Date') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Created At') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Updated At') }}
                        </th>
                        <th
                            class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($tasks as $task)
                        <x-task-table-row :task="$task" />
                    @empty
                        <tr>
                            <td colspan="9" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ __('No tasks found') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('Try adjusting your search or filters') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $tasks->links() }}
        </div>
    </x-table-card>

    <!-- Task Modal -->
    <livewire:tasks.task-modal />
</div>
