@props(['task', 'showWorkDate' => false, 'showTimeFirst' => false])

<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
    @if($showTimeFirst)
        <td class="whitespace-nowrap px-6 py-5">
            @if($task->work_time)
                <div class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-500 to-teal-600 px-4 py-2 shadow-md">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-base font-bold text-white">{{ \Carbon\Carbon::parse($task->work_time)->format('h:i A') }}</span>
                </div>
            @else
                <div class="inline-flex items-center gap-2 rounded-lg bg-gradient-to-r from-gray-400 to-gray-500 px-4 py-2 shadow-md">
                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-base font-bold text-white">{{ __('No Time') }}</span>
                </div>
            @endif
        </td>
    @endif

    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex flex-col">
            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $task->title }}</span>
            @if($task->description)
                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ $task->description }}</span>
            @endif
        </div>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        @if($task->assignedUsers && $task->assignedUsers->count() > 0)
            <div class="flex items-center gap-2">
                <div class="flex -space-x-2">
                    @foreach($task->assignedUsers->take(3) as $user)
                        <div class="relative h-8 w-8 flex-shrink-0" title="{{ $user->name }}">
                            @if($user->avatar)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-8 w-8 rounded-lg object-cover ring-2 ring-white dark:ring-gray-900">
                            @else
                                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-white dark:ring-gray-900">
                                    <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                        {{ $user->initials() }}
                                    </span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @if($task->assignedUsers->count() > 3)
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-500 ring-2 ring-white dark:ring-gray-900">
                            <span class="text-xs font-bold text-white">
                                +{{ $task->assignedUsers->count() - 3 }}
                            </span>
                        </div>
                    @endif
                </div>
                <div class="flex flex-col">
                    <span class="text-sm text-gray-900 dark:text-white">{{ $task->assignedUsers->pluck('name')->take(2)->implode(', ') }}</span>
                    @if($task->assignedUsers->count() > 2)
                        <span class="text-xs text-gray-500 dark:text-gray-400">+{{ $task->assignedUsers->count() - 2 }} {{ __('more') }}</span>
                    @endif
                </div>
            </div>
        @else
            <span class="text-sm text-gray-400 dark:text-gray-500">{{ __('Unassigned') }}</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        @if($task->creator)
            <div class="flex items-center gap-2">
                <div class="relative h-8 w-8 flex-shrink-0">
                    @if($task->creator->avatar)
                        <img src="{{ $task->creator->avatar_url }}" alt="{{ $task->creator->name }}" class="h-8 w-8 rounded-lg object-cover ring-2 ring-emerald-200 dark:ring-emerald-800">
                    @else
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-emerald-400/20 ring-2 ring-emerald-300 dark:ring-emerald-800">
                            <span class="text-xs font-bold text-emerald-900 dark:text-emerald-200">
                                {{ $task->creator->initials() }}
                            </span>
                        </div>
                    @endif
                </div>
                <span class="text-sm text-gray-900 dark:text-white">{{ $task->creator->name }}</span>
            </div>
        @else
            <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <flux:badge :color="match($task->priority) {
                'urgent' => 'red',
                'high' => 'orange',
                'medium' => 'yellow',
                default => 'gray',
            }" size="sm" class="font-semibold">
            {{ ucfirst($task->priority) }}
        </flux:badge>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <flux:badge :color="match($task->status) {
                'completed' => 'green',
                'running' => 'blue',
                'cancelled' => 'red',
                default => 'gray',
            }" size="sm" class="font-semibold">
            {{ ucfirst($task->status) }}
        </flux:badge>
    </td>
    @if(!$showTimeFirst)
        <td class="whitespace-nowrap px-6 py-5">
            @if($showWorkDate)
                @if($task->work_date)
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm text-gray-900 dark:text-white">{{ $task->work_date->format('M d, Y') }}</span>
                    </div>
                @else
                    <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                @endif
            @else
                @if($task->work_time)
                    <div class="flex items-center gap-2">
                        <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($task->work_time)->format('h:i A') }}</span>
                    </div>
                @else
                    <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
                @endif
            @endif
        </td>
    @endif
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="ghost" @click="openModal({{ $task->id }})" icon="pencil" class="opacity-50 transition-opacity group-hover:opacity-100">
                {{ __('Edit') }}
            </flux:button>
        </div>
    </td>
</tr>

