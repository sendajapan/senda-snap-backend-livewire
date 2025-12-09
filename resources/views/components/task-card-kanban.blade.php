@props(['task', 'status' => null])
@php
    use Carbon\Carbon;
    $status = $status ?? $task->status;
    
    // Define color classes based on status - gradients with 50% opacity
    $colors = [
        'pending' => [
            'border' => 'border-emerald-200 dark:border-emerald-900/50',
            'hoverBorder' => 'hover:border-emerald-300 dark:hover:border-emerald-800',
            'bg' => 'bg-gradient-to-br from-emerald-50/50 via-white/50 to-teal-50/50 dark:from-emerald-900/10 dark:via-gray-900/50 dark:to-teal-900/10',
            'attachmentBg' => 'bg-emerald-100 dark:bg-emerald-900/30',
            'attachmentText' => 'text-emerald-700 dark:text-emerald-300',
            'attachmentIcon' => 'text-emerald-600 dark:text-emerald-400',
            'avatarBg' => 'bg-emerald-400/20',
            'avatarText' => 'text-emerald-900 dark:text-emerald-200',
            'avatarPlus' => 'bg-emerald-500',
        ],
        'running' => [
            'border' => 'border-blue-200 dark:border-blue-900/50',
            'hoverBorder' => 'hover:border-blue-300 dark:hover:border-blue-800',
            'bg' => 'bg-gradient-to-br from-blue-50/50 via-white/50 to-cyan-50/50 dark:from-blue-900/10 dark:via-gray-900/50 dark:to-cyan-900/10',
            'attachmentBg' => 'bg-blue-100 dark:bg-blue-900/30',
            'attachmentText' => 'text-blue-700 dark:text-blue-300',
            'attachmentIcon' => 'text-blue-600 dark:text-blue-400',
            'avatarBg' => 'bg-blue-400/20',
            'avatarText' => 'text-blue-900 dark:text-blue-200',
            'avatarPlus' => 'bg-blue-500',
        ],
        'completed' => [
            'border' => 'border-green-200 dark:border-green-900/50',
            'hoverBorder' => 'hover:border-green-300 dark:hover:border-green-800',
            'bg' => 'bg-gradient-to-br from-green-50/50 via-white/50 to-emerald-50/50 dark:from-green-900/10 dark:via-gray-900/50 dark:to-emerald-900/10',
            'attachmentBg' => 'bg-green-100 dark:bg-green-900/30',
            'attachmentText' => 'text-green-700 dark:text-green-300',
            'attachmentIcon' => 'text-green-600 dark:text-green-400',
            'avatarBg' => 'bg-green-400/20',
            'avatarText' => 'text-green-900 dark:text-green-200',
            'avatarPlus' => 'bg-green-500',
        ],
        'cancelled' => [
            'border' => 'border-red-200 dark:border-red-900/50',
            'hoverBorder' => 'hover:border-red-300 dark:hover:border-red-800',
            'bg' => 'bg-gradient-to-br from-red-50/50 via-white/50 to-rose-50/50 dark:from-red-900/10 dark:via-gray-900/50 dark:to-rose-900/10',
            'attachmentBg' => 'bg-red-100 dark:bg-red-900/30',
            'attachmentText' => 'text-red-700 dark:text-red-300',
            'attachmentIcon' => 'text-red-600 dark:text-red-400',
            'avatarBg' => 'bg-red-400/20',
            'avatarText' => 'text-red-900 dark:text-red-200',
            'avatarPlus' => 'bg-red-500',
        ],
    ];
    
    $color = $colors[$status] ?? $colors['pending'];
@endphp

<div class="group relative w-full overflow-hidden rounded-lg border {{ $color['border'] }} {{ $color['bg'] }} p-3 shadow-md transition-all duration-200 {{ $color['hoverBorder'] }} hover:shadow-lg backdrop-blur-sm">
    <div class="flex flex-col gap-2">
        <!-- Header: Title + Priority -->
        <div class="flex items-start justify-between gap-2">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1.5 flex-wrap">
                    <h3 class="text-sm font-bold text-gray-900 dark:text-white truncate">{{ $task->title }}</h3>
                    @if($task->attachments && $task->attachments->count() > 0)
                        <div class="flex items-center gap-0.5 rounded {{ $color['attachmentBg'] }} px-1.5 py-0.5 flex-shrink-0" title="{{ $task->attachments->count() }} {{ __('attachment(s)') }}">
                            <svg class="h-3 w-3 {{ $color['attachmentIcon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.586a4 4 0 00-5.656-5.656l-6.415 6.585a6 6 0 108.486 8.486L20.5 13" />
                            </svg>
                            <span class="text-[10px] font-semibold {{ $color['attachmentText'] }}">{{ $task->attachments->count() }}</span>
                        </div>
                    @endif
                </div>
                @if($task->description)
                    <p class="mt-1 text-xs text-gray-600 dark:text-gray-400 line-clamp-2">{{ $task->description }}</p>
                @endif
            </div>
            <div class="flex-shrink-0">
                <flux:badge :color="match($task->priority) {
                    'urgent' => 'red',
                    'high' => 'orange',
                    'medium' => 'yellow',
                    default => 'gray',
                }" size="sm" class="font-semibold text-[10px]">
                    {{ ucfirst($task->priority) }}
                </flux:badge>
            </div>
        </div>

        <!-- Details: Assigned Users -->
        @if($task->assignedUsers && $task->assignedUsers->count() > 0)
            <div class="flex items-center gap-1.5">
                <div class="flex -space-x-1.5">
                    @foreach($task->assignedUsers->take(2) as $user)
                        <div class="relative h-5 w-5 flex-shrink-0" title="{{ $user->name }}">
                            @if($user->avatar && $user->avatar_url)
                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-5 w-5 rounded-lg object-cover ring-2 ring-white dark:ring-gray-900">
                            @else
                                <div class="flex h-5 w-5 items-center justify-center rounded-lg {{ $color['avatarBg'] }} ring-2 ring-white dark:ring-gray-900">
                                    <span class="text-[9px] font-bold {{ $color['avatarText'] }}">{{ $user->initials() }}</span>
                                </div>
                            @endif
                        </div>
                    @endforeach
                    @if($task->assignedUsers->count() > 2)
                        <div class="flex h-5 w-5 items-center justify-center rounded-lg {{ $color['avatarPlus'] }} ring-2 ring-white dark:ring-gray-900">
                            <span class="text-[9px] font-bold text-white">+{{ $task->assignedUsers->count() - 2 }}</span>
                        </div>
                    @endif
                </div>
                <span class="truncate text-xs text-gray-600 dark:text-gray-400">
                    {{ $task->assignedUsers->pluck('name')->take(1)->implode(', ') }}
                    @if($task->assignedUsers->count() > 1)
                        <span class="text-[10px]">+{{ $task->assignedUsers->count() - 1 }}</span>
                    @endif
                </span>
            </div>
        @endif

        <!-- Created At Time -->
        <div class="flex items-center gap-1 border-t border-gray-200/50 pt-2 dark:border-gray-700/50">
            <svg class="h-3 w-3 {{ $color['attachmentIcon'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-xs font-semibold {{ $color['attachmentText'] }}">{{ $task->created_at->format('M d, Y g:i A') }}</span>
        </div>

        <!-- Preview Button -->
        <div class="flex justify-end mt-2">
            <button @click.stop="openPreview({{ $task->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-emerald-700/60 bg-emerald-500/10 px-2 py-1.5 transition-all duration-200 hover:border-emerald-700 hover:bg-emerald-500/20 hover:shadow-lg hover:shadow-emerald-700/30" title="{{ __('Preview Task') }}">
                <svg class="h-3.5 w-3.5 text-emerald-700 transition-all duration-200 group-hover:text-emerald-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>
        </div>
    </div>
</div>

