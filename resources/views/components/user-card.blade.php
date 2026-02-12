@props(['user', 'rounded' => true])

<div class="group relative overflow-hidden border border-blue-200 bg-white/50 p-4 transition-shadow duration-200 hover:border-blue-300 hover:shadow-sm dark:border-blue-900/50 dark:bg-gray-800/50 dark:hover:border-blue-800">
    <!-- Top Section: Avatar+Name+Role Centered, Buttons Top Right -->
    <div class="relative flex flex-col items-center gap-0.5 border-b border-gray-200/50 pb-4 dark:border-gray-700/50">
        <!-- Avatar -->
        <div class="relative h-9 w-9 flex-shrink-0">
            @if($user->avatar)
                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-9 w-9 rounded-full object-cover ring-2 ring-blue-200 dark:ring-blue-800">
            @else
                <div class="flex h-9 w-9 items-center justify-center rounded-full bg-blue-400/20 ring-2 ring-blue-300 dark:ring-blue-800">
                    <span class="text-xsfont-bold text-blue-900 dark:text-blue-200">
                        {{ $user->initials() }}
                    </span>
                </div>
            @endif
            <div class="absolute -bottom-0.5 -right-0.5 h-2.5 w-2.5 rounded-full border-2 border-white bg-emerald-500 dark:border-gray-900"></div>
        </div>

        <!-- Name -->
        <div class="text-smfont-semibold text-gray-900 dark:text-white">
            {{ $user->name }}
        </div>

        <!-- Role Badge -->
        <flux:badge :color="match($user->role) {
            'admin' => 'red',
            'manager' => 'blue',
            'employee' => 'emerald',
            default => 'gray',
        }" size="sm" class="font-semibold text-xs">
            {{ ucfirst($user->role) }}
        </flux:badge>

        <!-- Action Buttons (Absolute Top Right) -->
        <div class="absolute top-0 right-0 flex items-center gap-1">
            @php
                $currentUser = auth()->user();
                $canDelete = $currentUser && in_array($currentUser->role, ['admin', 'manager'])
                    && !($currentUser->role === 'manager' && ($currentUser->id === $user->id || $user->role === 'admin'));
            @endphp

            <!-- View Button -->
            <button @click="openPreview({{ $user->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-blue-700/60 bg-blue-500/10 p-1.5 transition-shadow duration-200 hover:border-blue-700 hover:bg-blue-500/20 hover:shadow-sm" title="{{ __('View User') }}">
                <svg class="h-3.5 w-3.5 text-blue-700 transition-colors duration-200 group-hover:text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>

            <!-- Edit Button -->
            <button @click="openModal({{ $user->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 transition-shadow duration-200 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-sm" title="{{ __('Edit User') }}">
                <svg class="h-3.5 w-3.5 text-cyan-700 transition-colors duration-200 group-hover:text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </button>

            <!-- Delete Button -->
            @if($canDelete)
                <button @click="window.confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}', []).then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-user', { userId: {{ $user->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 transition-shadow duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-sm" title="{{ __('Delete User') }}">
                    <svg class="h-3.5 w-3.5 text-red-700 transition-colors duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            @endif
        </div>
    </div>

    <!-- Bottom Section: Split Left/Right -->
    <div class="grid grid-cols-2 gap-4 pt-4">
        <!-- Left Side: Company & Address -->
        <div class="flex flex-col gap-1">
            @if($user->vendor)
                <div class="text-xsfont-medium text-gray-900 dark:text-white leading-tight">
                    {{ $user->vendor->name }}
                </div>
                @if($user->vendor->address)
                    <div class="text-xs text-gray-500 dark:text-gray-400 leading-tight line-clamp-3">
                        {{ $user->vendor->address }}
                    </div>
                @endif
            @else
                <div class="text-xs text-gray-400 dark:text-gray-500">-</div>
            @endif
        </div>

        <!-- Right Side: Email, Phone, Created -->
        <div class="flex flex-col gap-1.5 text-right">
            <!-- Email -->
            <div class="text-xs text-gray-900 dark:text-white truncate leading-tight" title="{{ $user->email }}">
                {{ $user->email }}
            </div>

            <!-- Phone -->
            <div class="text-xstext-gray-600 dark:text-gray-400 leading-tight">
                {{ $user->phone ?: '00-0000-0000' }}
            </div>

            <!-- Created At -->
            <div class="text-xs text-gray-400 dark:text-gray-500 leading-tight">
                {{ $user->created_at->format('M d, Y') }}
            </div>
        </div>
    </div>
</div>
