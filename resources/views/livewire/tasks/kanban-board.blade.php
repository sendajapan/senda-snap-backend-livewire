<div class="flex h-full w-full flex-1 flex-col gap-4 min-w-[1280px]" x-data="{
    openModal(taskId = null) {
        $wire.$dispatch('open-task-modal', { taskId: taskId })
    },
    openPreview(taskId = null) {
        $wire.$dispatch('open-task-preview', { taskId: taskId })
    },
    draggedTaskId: null,
    draggedFromStatus: null,
    handleDragStart(event, taskId, status) {
        this.draggedTaskId = taskId;
        this.draggedFromStatus = status;
        event.dataTransfer.effectAllowed = 'move';
        event.dataTransfer.setData('text/html', event.target);
        event.target.style.opacity = '0.5';
    },
    handleDragEnd(event) {
        event.target.style.opacity = '1';
        this.draggedTaskId = null;
        this.draggedFromStatus = null;
    },
    handleDragOver(event, status) {
        event.preventDefault();
        event.dataTransfer.dropEffect = 'move';
        event.currentTarget.classList.add('ring-2', 'ring-emerald-500', 'ring-opacity-50');
    },
    handleDragLeave(event) {
        event.currentTarget.classList.remove('ring-2', 'ring-emerald-500', 'ring-opacity-50');
    },
    async handleDrop(event, newStatus) {
        event.preventDefault();
        event.currentTarget.classList.remove('ring-2', 'ring-emerald-500', 'ring-opacity-50');
        
        if (this.draggedTaskId && this.draggedFromStatus !== newStatus) {
            // Update the task status - the refreshKey increment will automatically trigger a re-render
            await $wire.updateTaskStatus(this.draggedTaskId, newStatus);
        }
        
        this.draggedTaskId = null;
        this.draggedFromStatus = null;
    }
}">
    <!-- Header Section -->
    <x-page-header :title="__('Kanban Board')" :description="__('Drag and drop tasks to update their status')"
        variant="emerald">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2h-2a2 2 0 00-2 2" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Task') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Filters Card with Kanban Board -->
    <x-table-card variant="emerald" class="flex flex-col flex-1 min-h-0 min-w-[1280px]">
        <div class="mb-4 flex-shrink-0">
            <h3 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center gap-2">
                <svg class="h-5 w-5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor"
                    viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z" />
                </svg>
                {{ __('Filters') }}
            </h3>

            <!-- Filters -->
            <div class="flex flex-col md:flex-row flex-wrap gap-3 md:gap-4">
                <div class="flex-1 min-w-full md:min-w-64">
                    <flux:input wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search by title or description...') }}" icon="magnifying-glass" />
                </div>
                <div class="w-full md:w-44 flex-shrink-0">
                    <flux:input type="date" wire:model.live="fromDate" placeholder="{{ __('From Date') }}" />
                </div>
                <div class="w-full md:w-44 flex-shrink-0">
                    <flux:input type="date" wire:model.live="toDate" placeholder="{{ __('To Date') }}" />
                </div>
                <div class="w-full md:w-48 flex-shrink-0">
                    <flux:select wire:model.live="priorityFilter" placeholder="{{ __('All Priorities') }}">
                        <option value="">{{ __('All Priorities') }}</option>
                        <option value="low">{{ __('Low') }}</option>
                        <option value="medium">{{ __('Medium') }}</option>
                        <option value="high">{{ __('High') }}</option>
                        <option value="urgent">{{ __('Urgent') }}</option>
                    </flux:select>
                </div>
                <div class="w-full md:w-48 flex-shrink-0">
                    <flux:select wire:model.live="assignedToFilter" placeholder="{{ __('All Users') }}">
                        <option value="">{{ __('All Users') }}</option>
                        @foreach($users as $user)
                            <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
                    </flux:select>
                </div>

                <!-- Clear Filters Button -->
                @if($search || $priorityFilter || $assignedToFilter || $fromDate || $toDate)
                    <div class="flex items-center w-full md:w-auto">
                        <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark"
                            class="w-full md:w-auto">
                            {{ __('Clear Filters') }}
                        </flux:button>
                    </div>
                @endif
            </div>

            <!-- Active Filters Display -->
            @if($search || $priorityFilter || $assignedToFilter || $fromDate || $toDate)
                <div class="mt-3 flex flex-wrap gap-2">
                    <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>

                    @if($search)
                        <flux:badge color="violet" size="sm">
                            {{ __('Search:') }} "{{ $search }}"
                        </flux:badge>
                    @endif

                    @if($priorityFilter)
                        <flux:badge color="yellow" size="sm">
                            {{ __('Priority:') }} {{ ucfirst($priorityFilter) }}
                        </flux:badge>
                    @endif

                    @if($assignedToFilter)
                        @php
                            $assignedUser = $users->firstWhere('id', $assignedToFilter);
                        @endphp
                        @if($assignedUser)
                            <flux:badge color="blue" size="sm">
                                {{ __('Assigned to:') }} {{ $assignedUser->name }}
                            </flux:badge>
                        @endif
                    @endif

                    @if($fromDate)
                        <flux:badge color="gray" size="sm">
                            {{ __('From:') }} {{ $fromDate }}
                        </flux:badge>
                    @endif

                    @if($toDate)
                        <flux:badge color="gray" size="sm">
                            {{ __('To:') }} {{ $toDate }}
                        </flux:badge>
                    @endif
                </div>
            @endif
        </div>

        <flux:separator class="my-4" />

        <!-- Kanban Board -->
        <div class="flex-1 overflow-x-auto overflow-y-hidden min-h-0" wire:key="kanban-board-{{ $refreshKey }}-{{ md5(($priorityFilter ?? '') . '|' . ($assignedToFilter ?? '') . '|' . ($search ?? '')) }}">
            <div class="h-full w-full">
                <div class="grid grid-cols-4 gap-0 h-full">
                <!-- Pending Column -->
                <div class="flex flex-col border-r border-gray-200 dark:border-gray-700 pr-3 h-full overflow-hidden"
                @dragover.prevent="handleDragOver($event, 'pending')"
                @dragleave="handleDragLeave($event)"
                @drop.prevent="handleDrop($event, 'pending')">
                <div class="flex-shrink-0 mb-3 rounded-lg border border-emerald-200 bg-emerald-50 p-3 shadow-md dark:border-emerald-900/50 dark:bg-emerald-900/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500/20">
                                <svg class="h-4 w-4 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Pending') }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $tasksByStatus['pending']->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 flex-1 overflow-y-auto">
                    @forelse($tasksByStatus['pending'] as $task)
                        <div draggable="true"
                            @dragstart="handleDragStart($event, {{ $task->id }}, 'pending')"
                            @dragend="handleDragEnd($event)"
                            class="cursor-move w-full">
                            <x-task-card-kanban :task="$task" status="pending" />
                        </div>
                    @empty
                        <div class="flex items-center justify-center rounded-lg border-2 border-dashed border-emerald-200 bg-emerald-50/30 p-4 dark:border-emerald-900/50 dark:bg-emerald-900/10">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('No tasks') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Running Column -->
            <div class="flex flex-col border-r border-gray-200 dark:border-gray-700 px-3 h-full overflow-hidden"
                @dragover.prevent="handleDragOver($event, 'running')"
                @dragleave="handleDragLeave($event)"
                @drop.prevent="handleDrop($event, 'running')">
                <div class="flex-shrink-0 mb-3 rounded-lg border border-blue-200 bg-blue-50 p-3 shadow-md dark:border-blue-900/50 dark:bg-blue-900/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-blue-500/20">
                                <svg class="h-4 w-4 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Running') }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $tasksByStatus['running']->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 flex-1 overflow-y-auto">
                    @forelse($tasksByStatus['running'] as $task)
                        <div draggable="true"
                            @dragstart="handleDragStart($event, {{ $task->id }}, 'running')"
                            @dragend="handleDragEnd($event)"
                            class="cursor-move w-full">
                            <x-task-card-kanban :task="$task" status="running" />
                        </div>
                    @empty
                        <div class="flex items-center justify-center rounded-lg border-2 border-dashed border-blue-200 bg-blue-50/30 p-4 dark:border-blue-900/50 dark:bg-blue-900/10">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('No tasks') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Completed Column -->
            <div class="flex flex-col border-r border-gray-200 dark:border-gray-700 px-3 h-full overflow-hidden"
                @dragover.prevent="handleDragOver($event, 'completed')"
                @dragleave="handleDragLeave($event)"
                @drop.prevent="handleDrop($event, 'completed')">
                <div class="flex-shrink-0 mb-3 rounded-lg border border-green-200 bg-green-50 p-3 shadow-md dark:border-green-900/50 dark:bg-green-900/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-500/20">
                                <svg class="h-4 w-4 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Completed') }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $tasksByStatus['completed']->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 flex-1 overflow-y-auto">
                    @forelse($tasksByStatus['completed'] as $task)
                        <div draggable="true"
                            @dragstart="handleDragStart($event, {{ $task->id }}, 'completed')"
                            @dragend="handleDragEnd($event)"
                            class="cursor-move w-full">
                            <x-task-card-kanban :task="$task" status="completed" />
                        </div>
                    @empty
                        <div class="flex items-center justify-center rounded-lg border-2 border-dashed border-green-200 bg-green-50/30 p-4 dark:border-green-900/50 dark:bg-green-900/10">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('No tasks') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Cancelled Column -->
            <div class="flex flex-col pl-3 h-full overflow-hidden"
                @dragover.prevent="handleDragOver($event, 'cancelled')"
                @dragleave="handleDragLeave($event)"
                @drop.prevent="handleDrop($event, 'cancelled')">
                <div class="flex-shrink-0 mb-3 rounded-lg border border-red-200 bg-red-50 p-3 shadow-md dark:border-red-900/50 dark:bg-red-900/20">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center gap-2">
                            <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-red-500/20">
                                <svg class="h-4 w-4 text-red-600 dark:text-red-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Cancelled') }}</h3>
                                <p class="text-xs text-gray-600 dark:text-gray-400">{{ $tasksByStatus['cancelled']->count() }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="flex flex-col gap-2 flex-1 overflow-y-auto">
                    @forelse($tasksByStatus['cancelled'] as $task)
                        <div draggable="true"
                            @dragstart="handleDragStart($event, {{ $task->id }}, 'cancelled')"
                            @dragend="handleDragEnd($event)"
                            class="cursor-move w-full">
                            <x-task-card-kanban :task="$task" status="cancelled" />
                        </div>
                    @empty
                        <div class="flex items-center justify-center rounded-lg border-2 border-dashed border-red-200 bg-red-50/30 p-4 dark:border-red-900/50 dark:bg-red-900/10">
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('No tasks') }}</p>
                        </div>
                    @endforelse
                </div>
            </div>
            </div>
        </div>
    </x-table-card>

    <!-- Task Modal -->
    <livewire:tasks.task-modal />
    
    <!-- Task Preview -->
    <livewire:tasks.task-preview />
</div>
