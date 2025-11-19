@php use Carbon\Carbon; @endphp
@props(['task', 'showWorkDate' => false, 'showTimeFirst' => false])

<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
    @if($showTimeFirst)
        <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
            @if($task->work_time)
                <div class="inline-flex items-center gap-1 md:gap-2 rounded-sm bg-accent/90 px-1.5 md:px-2 py-1 shadow-sm">
                    <svg class="h-4 w-4 md:h-5 md:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs md:text-sm font-semibold text-white">{{ Carbon::parse($task->work_time)->format('h:i A') }}</span>
                </div>
            @else
                <div class="inline-flex items-center gap-1 md:gap-2 rounded-sm bg-zinc-400 px-1.5 md:px-2 py-1 shadow-sm">
                    <svg class="h-4 w-4 md:h-5 md:w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <span class="text-xs md:text-sm font-semibold text-white">{{ __('No Time') }}</span>
                </div>
            @endif
        </td>
    @endif

    <td class="w-1/4 whitespace-normal px-3 md:px-6 py-3 md:py-5">
        <div class="flex flex-col">
            <div class="flex items-center gap-1.5 md:gap-2 flex-wrap">
                <span class="text-xs font-bold text-gray-900 dark:text-white break-words">{{ $task->title }}</span>
                @if($task->attachments && $task->attachments->count() > 0)
                    <div class="flex items-center gap-0.5 md:gap-1 rounded-md bg-emerald-100 px-1.5 md:px-2 py-0.5 dark:bg-emerald-900/30 flex-shrink-0" title="{{ $task->attachments->count() }} {{ __('attachment(s)') }}">
                        <svg class="h-3 w-3 md:h-3.5 md:w-3.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                        </svg>
                        <span class="text-[10px] md:text-xs font-semibold text-emerald-700 dark:text-emerald-300">{{ $task->attachments->count() }}</span>
                    </div>
                @endif
            </div>
            @if($task->description)
                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-2 md:line-clamp-3">{{ $task->description }}</span>
            @endif
        </div>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 hidden lg:table-cell">
        @if($task->assignedUsers && $task->assignedUsers->count() > 0)
            <div class="flex items-center gap-1.5 md:gap-2">
                <div class="flex -space-x-1.5 md:-space-x-2">
                    @foreach($task->assignedUsers->take(3) as $user)
                        <div class="relative h-6 w-6 md:h-8 md:w-8 flex-shrink-0" title="{{ $user->name }}">
                            @if($user->avatar && $user->avatar_url)
                                <img src="{{ $user->avatar_url }}"
                                     alt="{{ $user->name }}"
                                     class="h-6 w-6 md:h-8 md:w-8 rounded-lg object-cover ring-2 ring-white dark:ring-gray-900"
                                     onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                <div
                                    class="hidden h-6 w-6 md:h-8 md:w-8 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-white dark:ring-gray-900">
                                    <span class="text-[10px] md:text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                        {{ $user->initials() }}
                                    </span>
                                </div>
                            @else
                                <div
                                    class="flex h-6 w-6 md:h-8 md:w-8 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-white dark:ring-gray-900">
                                    <span class="text-[10px] md:text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                        {{ $user->initials() }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @if($task->assignedUsers->count() > 3)
                        <div
                            class="flex h-6 w-6 md:h-8 md:w-8 items-center justify-center rounded-lg bg-emerald-500 ring-2 ring-white dark:ring-gray-900">
                            <span class="text-[10px] md:text-xs font-bold text-white">
                                +{{ $task->assignedUsers->count() - 3 }}
                            </span>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-xs text-gray-900 dark:text-white">{{ $task->assignedUsers->pluck('name')->take(2)->implode(', ') }}</span>
                    @if($task->assignedUsers->count() > 2)
                        <span
                            class="text-[10px] text-gray-500 dark:text-gray-400">+{{ $task->assignedUsers->count() - 2 }} {{ __('more') }}</span>
                    @endif
                </div>
            </div>
        @else
            <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Unassigned') }}</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 hidden xl:table-cell">
        @if($task->creator)
            <div class="flex items-center gap-1.5 md:gap-2">
                <div class="relative h-6 w-6 md:h-8 md:w-8 flex-shrink-0">
                    @if($task->creator->avatar && $task->creator->avatar_url)
                        <img src="{{ $task->creator->avatar_url }}"
                             alt="{{ $task->creator->name }}"
                             class="h-6 w-6 md:h-8 md:w-8 rounded-lg object-cover ring-2 ring-emerald-200 dark:ring-emerald-800"
                             onerror="this.onerror=null; this.style.display='none'; this.nextElementSibling.style.display='flex';">
                        <div
                            class="hidden h-6 w-6 md:h-8 md:w-8 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-emerald-300 dark:ring-emerald-800">
                            <span class="text-[10px] md:text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                {{ $task->creator->initials() }}
                            </span>
                        </div>
                    @else
                        <div
                            class="flex h-6 w-6 md:h-8 md:w-8 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-emerald-300 dark:ring-emerald-800">
                            <span class="text-[10px] md:text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                {{ $task->creator->initials() }}
                            </span>
                        </div>
                    @endif
                </div>
                <span class="text-xs text-gray-900 dark:text-white">{{ $task->creator->name }}</span>
            </div>
        @else
            <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <flux:badge :color="match($task->priority) {
                'urgent' => 'red',
                'high' => 'orange',
                'medium' => 'yellow',
                default => 'gray',
            }" size="sm" class="font-semibold text-xs">
            {{ ucfirst($task->priority) }}
        </flux:badge>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <flux:badge :color="match($task->status) {
                'completed' => 'green',
                'running' => 'blue',
                'cancelled' => 'red',
                default => 'gray',
            }" size="sm" class="font-semibold text-xs">
            {{ ucfirst($task->status) }}
        </flux:badge>
    </td>
    @if(!$showTimeFirst)
        <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 hidden md:table-cell">
            @if($showWorkDate)
                @if($task->work_date)
                    <div class="flex flex-col gap-1">
                        <div class="flex items-center gap-1.5">
                            <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                            <span class="text-xs text-gray-900 dark:text-white">{{ $task->work_date->format('M d, Y') }}</span>
                        </div>
                        @if($task->work_time)
                            <div class="flex items-center gap-1.5">
                                <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                          d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                <span class="text-xs text-gray-900 dark:text-white">{{ Carbon::parse($task->work_time)->format('h:i A') }}</span>
                            </div>
                        @endif
                    </div>
                @else
                    <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                @endif
            @else
                @if($task->work_time)
                    <div class="flex items-center gap-1.5">
                        <svg class="h-3.5 w-3.5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span class="text-xs text-gray-900 dark:text-white">{{ Carbon::parse($task->work_time)->format('h:i A') }}</span>
                    </div>
                @else
                    <span class="text-xs text-gray-400 dark:text-gray-500">-</span>
                @endif
            @endif
        </td>
    @endif
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <div class="flex items-center gap-1.5 md:gap-2">
            <!-- View Button -->
            <button @click="openPreview({{ $task->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-emerald-700/60 bg-emerald-500/10 p-1.5 transition-all duration-200 hover:border-emerald-700 hover:bg-emerald-500/20 hover:shadow-lg hover:shadow-emerald-700/30" title="{{ __('View Task') }}">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-emerald-700 transition-all duration-200 group-hover:text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>

            <!-- Edit Button -->
            <button @click="openModal({{ $task->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 transition-all duration-200 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-700/30" title="{{ __('Edit Task') }}">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-cyan-700 transition-all duration-200 group-hover:text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </button>

            <!-- Delete Button -->
            @php
                $currentUser = auth()->user();
                $canDeleteTask = $currentUser && in_array($currentUser->role, ['admin', 'manager']);
            @endphp
            @if($canDeleteTask)
                <button @click="window.confirmDelete({{ $task->id }}, '{{ addslashes($task->title) }}').then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-task', { taskId: {{ $task->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 transition-all duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30" title="{{ __('Delete Task') }}">
                    <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            @endif
        </div>
    </td>
</tr>

