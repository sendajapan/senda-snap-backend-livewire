@props(['task'])

<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-violet-50/50 hover:to-purple-50/50 dark:hover:from-violet-900/10 dark:hover:to-purple-900/10">
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex flex-col">
            <span class="text-sm font-bold text-gray-900 dark:text-white">{{ $task->title }}</span>
            @if($task->description)
                <span class="mt-1 text-xs text-gray-500 dark:text-gray-400 line-clamp-1">{{ $task->description }}</span>
            @endif
        </div>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        @if($task->vehicle)
            <div class="flex items-center gap-2">
                <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-100 dark:bg-violet-900/30">
                    <svg class="h-4 w-4 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                    </svg>
                </div>
                <div class="flex flex-col">
                    <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $task->vehicle->serial_number }}</span>
                    <span class="text-xs text-gray-500 dark:text-gray-400">{{ $task->vehicle->brand }}</span>
                </div>
            </div>
        @else
            <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        @if($task->assignedUser)
            <div class="flex items-center gap-2">
                <div class="relative h-8 w-8 flex-shrink-0">
                    @if($task->assignedUser->avatar)
                        <img src="{{ $task->assignedUser->avatar_url }}" alt="{{ $task->assignedUser->name }}" class="h-8 w-8 rounded-lg object-cover ring-2 ring-violet-200 dark:ring-violet-800">
                    @else
                        <div class="flex h-8 w-8 items-center justify-center rounded-lg bg-violet-400/20 ring-2 ring-violet-300 dark:ring-violet-800">
                            <span class="text-xs font-bold text-violet-900">
                                {{ $task->assignedUser->initials() }}
                            </span>
                        </div>
                    @endif
                </div>
                <span class="text-sm text-gray-900 dark:text-white">{{ $task->assignedUser->name }}</span>
            </div>
        @else
            <span class="text-sm text-gray-400 dark:text-gray-500">{{ __('Unassigned') }}</span>
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
    <td class="whitespace-nowrap px-6 py-5">
        @if($task->due_date)
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="text-sm text-gray-900 dark:text-white">{{ $task->due_date->format('M d, Y') }}</span>
            </div>
        @else
            <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <span class="text-sm text-gray-900 dark:text-gray-500">{{ $task->created_at->format('Y-m-d') }}</span>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <span class="text-sm text-gray-900 dark:text-gray-500">{{ $task->updated_at->format('Y-m-d') }}</span>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="ghost" @click="openModal({{ $task->id }})" icon="pencil" class="opacity-50 transition-opacity group-hover:opacity-100">
                {{ __('Edit') }}
            </flux:button>
        </div>
    </td>
</tr>

