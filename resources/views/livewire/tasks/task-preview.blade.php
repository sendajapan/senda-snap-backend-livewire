@php use Carbon\Carbon; @endphp

<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-y-auto"
         style="display: none;">

        <!-- Background overlay -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-200"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="fixed inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <!-- Modal Container -->
        <div class="flex min-h-full items-center justify-center p-4">
            <div x-show="open"
                 x-transition:enter="transition ease-out duration-300"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-200"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 class="relative w-full max-w-4xl transform overflow-hidden rounded-2xl bg-white shadow-2xl dark:bg-gray-900"
                 @click.away="open = false">

                <!-- Content -->
                <div class="max-h-[90vh] overflow-y-auto p-6 pb-20">
                    @if($task)
                        <!-- Task Preview Card -->
                        <div class="relative overflow-hidden rounded-xl border border-emerald-200 bg-gradient-to-br from-emerald-50 via-white to-teal-50 p-6 shadow-xl dark:border-emerald-900/50 dark:from-emerald-900/20 dark:via-gray-900 dark:to-teal-900/20">
                            <!-- Decorative Elements -->
                            <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-emerald-400/20 to-teal-400/20 blur-2xl"></div>
                            <div class="pointer-events-none absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-teal-400/20 to-emerald-400/20 blur-2xl"></div>

                            <div class="relative">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-500 shadow-lg">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $task->title }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Created') }} {{ $task->created_at->diffForHumans() }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
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

                                @if($task->description)
                                    <div class="mb-4 rounded-lg bg-white/50 p-4 backdrop-blur-sm dark:bg-gray-800/50">
                                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ $task->description }}</p>
                                    </div>
                                @endif

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    @if($task->work_date)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Work Date') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $task->work_date->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($task->work_time)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Work Time') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ Carbon::parse($task->work_time)->format('h:i A') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($task->due_date)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Due Date') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $task->due_date->format('M d, Y') }}</p>
                                            </div>
                                        </div>
                                    @endif
                                    @if($task->creator)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Created By') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $task->creator->name }}</p>
                                            </div>
                                        </div>
                                    @endif
                                </div>

                                @if($task->assignedUsers && $task->assignedUsers->count() > 0)
                                    <div class="mt-4 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <p class="mb-2 text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Assigned To') }}</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($task->assignedUsers as $user)
                                                <div class="flex items-center gap-2 rounded-lg bg-emerald-100 px-3 py-1.5 dark:bg-emerald-900/30">
                                                    @if($user->avatar && $user->avatar_url)
                                                        <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-5 w-5 rounded-full object-cover">
                                                    @else
                                                        <div class="flex h-5 w-5 items-center justify-center rounded-full bg-emerald-500 text-white">
                                                            <span class="text-[10px] font-bold">{{ $user->initials() }}</span>
                                                        </div>
                                                    @endif
                                                    <span class="text-xs font-medium text-emerald-900 dark:text-emerald-200">{{ $user->name }}</span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                @if($task->attachments && $task->attachments->count() > 0)
                                    <div class="mt-4 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <p class="mb-2 text-xs font-medium text-gray-500 dark:text-gray-400">{{ __('Attachments') }} ({{ $task->attachments->count() }})</p>
                                        <div class="flex flex-wrap gap-2">
                                            @foreach($task->attachments as $attachment)
                                                <a href="{{ Storage::disk('public')->url($attachment->file_path) }}" target="_blank" class="flex items-center gap-2 rounded-lg bg-emerald-100 px-3 py-1.5 text-xs font-medium text-emerald-900 transition-colors hover:bg-emerald-200 dark:bg-emerald-900/30 dark:text-emerald-200 dark:hover:bg-emerald-900/50">
                                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                    </svg>
                                                    <span class="truncate max-w-[200px]">{{ $attachment->file_name }}</span>
                                                </a>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <div class="rounded-xl border border-gray-200 bg-white p-12 text-center dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No task selected') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Click the view icon on a task to preview it') }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons (Center Bottom) -->
                @if($task)
                    <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center gap-3 border-t border-gray-200/50 bg-white/95 p-4 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/95">
                        <!-- Edit Button -->
                        <button wire:click="editTask" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-600/50 bg-cyan-500/10 p-3 transition-all duration-200 hover:border-cyan-600 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-600/30">
                            <svg class="h-5 w-5 text-cyan-600 transition-all duration-200 group-hover:text-cyan-500 group-hover:drop-shadow-[0_0_8px_rgba(6,182,212,0.8)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span class="ml-2 text-sm font-semibold text-cyan-600">{{ __('Edit') }}</span>
                        </button>

                        <!-- Close Button -->
                        <button wire:click="closePreview" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-gray-400/50 bg-gray-500/10 p-3 transition-all duration-200 hover:border-gray-400 hover:bg-gray-500/20 hover:shadow-lg hover:shadow-gray-500/30">
                            <svg class="h-5 w-5 text-gray-400 transition-all duration-200 group-hover:text-gray-300 group-hover:drop-shadow-[0_0_8px_rgba(156,163,175,0.8)]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="ml-2 text-sm font-semibold text-gray-400">{{ __('Close') }}</span>
                        </button>

                        <!-- Delete Button -->
                        @if($this->canDelete())
                            <button @click="window.confirmDelete({{ $task->id }}, '{{ addslashes($task->title) }}').then((result) => { if (result.isConfirmed) { $wire.deleteTask() } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-600/50 bg-red-500/10 p-3 transition-all duration-200 hover:border-red-600 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-600/30">
                                <svg class="h-5 w-5 text-red-600 transition-all duration-200 group-hover:text-red-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                <span class="ml-2 text-sm font-semibold text-red-600">{{ __('Delete') }}</span>
                            </button>
                        @endif
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
