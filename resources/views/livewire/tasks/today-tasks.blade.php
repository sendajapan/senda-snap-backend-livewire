<div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{
    openModal(taskId = null) {
        $wire.$dispatch('open-task-modal', { taskId: taskId })
    },
    openPreview(taskId = null) {
        $wire.$dispatch('open-task-preview', { taskId: taskId })
    },
    confirmDelete(taskId, taskTitle = null) {
        return window.confirmDelete(taskId, taskTitle);
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Today\'s Tasks')"
        :description="__('Manage tasks scheduled for today')"
        variant="emerald">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Task') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Today's Tasks Table Card -->
    <x-table-card variant="emerald">
        <div class="mb-4">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                {{ __("Today's Tasks") }} ({{ $tasks->count() }})
            </h3>

            <!-- Filters -->
            <div class="flex flex-col md:flex-row flex-wrap gap-3 md:gap-4">
                <div class="w-full md:w-48 flex-shrink-0">
                    <flux:select wire:model.live="statusFilter" placeholder="{{ __('All Status') }}">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="running">{{ __('Running') }}</option>
                        <option value="completed">{{ __('Completed') }}</option>
                        <option value="cancelled">{{ __('Cancelled') }}</option>
                    </flux:select>
                </div>

                <!-- Clear Filters Button -->
                @if($statusFilter)
                    <div class="flex items-center w-full md:w-auto">
                        <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark" class="w-full md:w-auto">
                            {{ __('Clear Filters') }}
                        </flux:button>
                    </div>
                @endif
            </div>

            <!-- Active Filters Display -->
            @if($statusFilter)
                <div class="mt-3 flex flex-wrap gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>

                    <flux:badge color="blue" size="sm">
                        {{ __('Status:') }} {{ ucfirst($statusFilter) }}
                    </flux:badge>
                </div>
            @endif
        </div>

        <!-- Table View (2xl and above) -->
        <div class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50"
             wire:key="today-tasks-table-{{ md5($statusFilter ?? 'all') }}">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Time') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Title') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden lg:table-cell">
                            {{ __('Assigned To') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden xl:table-cell">
                            {{ __('Assigned By') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Priority') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Status') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($tasks as $task)
                        <x-task-table-row :task="$task" :showTimeFirst="true" wire:key="task-{{ $task->id }}" />
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 md:px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ __('No tasks scheduled for today') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('Create a new task to get started') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Stacked View (below 2xl) -->
        <div class="2xl:hidden border rounded-xl bg-white/50 backdrop-blur-sm dark:bg-gray-800/50 p-4"
             wire:key="today-tasks-stacked-{{ md5($statusFilter ?? 'all') }}">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
                @forelse($tasks as $task)
                    <x-task-card :task="$task" :showTimeFirst="true" :rounded="true" />
                @empty
                    <div class="col-span-full p-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">
                                {{ __('No tasks scheduled for today') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                {{ __('Create a new task to get started') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

    </x-table-card>

    <!-- Task Modal -->
    <livewire:tasks.task-modal />

    <!-- Task Preview -->
    <livewire:tasks.task-preview />
</div>
