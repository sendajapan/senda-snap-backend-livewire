@props(['task', 'showWorkDate' => false, 'showTimeFirst' => false, 'rounded' => true])
@php use Carbon\Carbon; @endphp

<div class="group relative overflow-hidden {{ $rounded ? 'rounded-xl' : '' }} border border-emerald-200 bg-white/50 p-4 backdrop-blur-sm transition-all duration-200 hover:border-emerald-300 hover:shadow-lg dark:border-emerald-900/50 dark:bg-gray-800/50 dark:hover:border-emerald-800">
    <div class="flex flex-col gap-4">
        <!-- Header: Title + Priority + Status -->
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <h3 class="text-base font-bold text-gray-900 dark:text-white whitespace-nowrap truncate">{{ $task->title }}</h3>
                    @if($task->attachments && $task->attachments->count() > 0)
                        <div class="flex items-center gap-1 rounded-md bg-emerald-100 px-2 py-0.5 dark:bg-emerald-900/30 flex-shrink-0" title="{{ $task->attachments->count() }} {{ __('attachment(s)') }}">
                            <svg class="h-3.5 w-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="text-xs font-semibold text-emerald-700 dark:text-emerald-300">{{ $task->attachments->count() }}</span>
                        </div>
                    @endif
                </div>
                @if($task->description)
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400 line-clamp-2">{{ $task->description }}</p>
                @endif
            </div>
            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                <flux:badge :color="match($task->priority) {
                    'urgent' => 'red',
                    'high' => 'orange',
                    'medium' => 'yellow',
                    default => 'gray',
                }" size="sm" class="font-semibold">
                    {{ ucfirst($task->priority) }}
                </flux:badge>
                <flux:badge :color="match($task->status) {
                    'completed' => 'green',
                    'running' => 'blue',
                    'cancelled' => 'red',
                    default => 'gray',
                }" size="sm" class="font-semibold">
                    {{ ucfirst($task->status) }}
                </flux:badge>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
            @if($showTimeFirst && $task->work_time)
                <!-- Work Time -->
                <div class="flex items-center gap-2">
                    <div class="inline-flex items-center gap-1.5 rounded-sm bg-accent/90 px-2 py-1 shadow-sm">
                        <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm font-semibold text-white">{{ Carbon::parse($task->work_time)->format('h:i A') }}</span>
                    </div>
                </div>
            @endif

            @if($showWorkDate && $task->work_date)
                <!-- Work Date -->
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="text-sm text-gray-900 dark:text-white whitespace-nowrap">
                        {{ $task->work_date->format('M d, Y') }}
                    </span>
                </div>
            @endif

            @if(!$showTimeFirst && !$showWorkDate && $task->work_time)
                <!-- Work Time (when not showing work date) -->
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm text-gray-900 dark:text-white whitespace-nowrap">
                        {{ Carbon::parse($task->work_time)->format('h:i A') }}
                    </span>
                </div>
            @endif

            <!-- Assigned To -->
            @if($task->assignedUsers && $task->assignedUsers->count() > 0)
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <div class="flex items-center gap-2 flex-1 min-w-0">
                        <div class="flex -space-x-2">
                            @foreach($task->assignedUsers->take(3) as $user)
                                <div class="relative h-6 w-6 flex-shrink-0" title="{{ $user->name }}">
                                    @if($user->avatar && $user->avatar_url)
                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-6 w-6 rounded-lg object-cover ring-2 ring-white dark:ring-gray-900">
                                    @else
                                        <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-white dark:ring-gray-900">
                                            <span class="text-[10px] font-bold text-emerald-900 dark:text-emerald-200">{{ $user->initials() }}</span>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                            @if($task->assignedUsers->count() > 3)
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-500 ring-2 ring-white dark:ring-gray-900">
                                    <span class="text-[10px] font-bold text-white">+{{ $task->assignedUsers->count() - 3 }}</span>
                                </div>
                            @endif
                        </div>
                        <span class="truncate text-sm text-gray-900 dark:text-white whitespace-nowrap">
                            {{ $task->assignedUsers->pluck('name')->take(2)->implode(', ') }}
                            @if($task->assignedUsers->count() > 2)
                                <span class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">+{{ $task->assignedUsers->count() - 2 }} {{ __('more') }}</span>
                            @endif
                        </span>
                    </div>
                </div>
            @else
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span class="text-sm text-gray-400 dark:text-gray-500 whitespace-nowrap">{{ __('Unassigned') }}</span>
                </div>
            @endif

            <!-- Assigned By -->
            @if($task->creator)
                <div class="flex items-center gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    <div class="flex items-center gap-2 flex-1 min-w-0">
                        <div class="relative h-6 w-6 flex-shrink-0">
                            @if($task->creator->avatar && $task->creator->avatar_url)
                                <img src="{{ $task->creator->avatar_url }}" alt="{{ $task->creator->name }}" class="h-6 w-6 rounded-lg object-cover ring-2 ring-emerald-200 dark:ring-emerald-800">
                            @else
                                <div class="flex h-6 w-6 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-emerald-300 dark:ring-emerald-800">
                                    <span class="text-[10px] font-bold text-emerald-900 dark:text-emerald-200">{{ $task->creator->initials() }}</span>
                                </div>
                            @endif
                        </div>
                        <span class="truncate text-sm text-gray-900 dark:text-white whitespace-nowrap">{{ $task->creator->name }}</span>
                    </div>
                </div>
            @endif
        </div>

        <!-- Actions -->
        <div class="flex items-center justify-end gap-2 border-t border-gray-200/50 pt-3 dark:border-gray-700/50">
            <!-- View Button -->
            <button @click="openPreview({{ $task->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-emerald-700/60 bg-emerald-500/10 p-2 transition-all duration-200 hover:border-emerald-700 hover:bg-emerald-500/20 hover:shadow-lg hover:shadow-emerald-700/30 opacity-50 group-hover:opacity-100" title="{{ __('View Task') }}">
                <svg class="h-4 w-4 text-emerald-700 transition-all duration-200 group-hover:text-emerald-600 group-hover:drop-shadow-[0_0_8px_rgba(4,120,87,0.8)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <span class="ml-1.5 text-xs font-semibold text-emerald-700 whitespace-nowrap">{{ __('View') }}</span>
            </button>

            <!-- Edit Button -->
            <button @click="openModal({{ $task->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-2 transition-all duration-200 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-700/30 opacity-50 group-hover:opacity-100" title="{{ __('Edit Task') }}">
                <svg class="h-4 w-4 text-cyan-700 transition-all duration-200 group-hover:text-cyan-600 group-hover:drop-shadow-[0_0_8px_rgba(8,145,178,0.8)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
                <span class="ml-1.5 text-xs font-semibold text-cyan-700 whitespace-nowrap">{{ __('Edit') }}</span>
            </button>

            <!-- Delete Button -->
            @php
                $currentUser = auth()->user();
                $canDeleteTask = $currentUser && in_array($currentUser->role, ['admin', 'manager']);
            @endphp
            @if($canDeleteTask)
                <button @click="window.confirmDelete({{ $task->id }}, '{{ addslashes($task->title) }}').then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-task', { taskId: {{ $task->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-2 transition-all duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30" title="{{ __('Delete Task') }}">
                    <svg class="h-4 w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            @endif
        </div>
    </div>
</div>

