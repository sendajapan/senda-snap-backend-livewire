@props(['user'])
<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-teal-50/50 dark:hover:from-blue-900/10 dark:hover:to-teal-900/10">
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <div class="flex items-center">
            <div class="relative size-10 md:size-12 flex-shrink-0">
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="size-10 md:size-12 rounded-xl object-cover ring-2 ring-blue-200 dark:ring-blue-800">
                @else
                    <div class="flex size-10 md:size-12 items-center justify-center rounded-xl bg-blue-400/20 shadow-lg ring-2 ring-blue-300 dark:ring-blue-800">
                        <span class="text-sm md:text-base font-bold text-blue-900 dark:text-blue-200">
                            {{ $user->initials() }}
                        </span>
                    </div>
                @endif
                <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white bg-green-500 dark:border-gray-900"></div>
            </div>
            <div class="ml-2 md:ml-4">
                <div class="text-xs md:text-sm font-bold text-gray-900 dark:text-white">
                    {{ $user->name }}
                </div>
                <div class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400">
                    {{ __('Member since :date', ['date' => $user->created_at->format('M Y')]) }}
                </div>
            </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <div class="flex items-center gap-1.5 md:gap-2">
            <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="text-xs md:text-sm text-gray-900 dark:text-white truncate max-w-[150px] md:max-w-none">{{ $user->email }}</span>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <flux:badge :color="match($user->role) {
            'admin' => 'red',
            'manager' => 'blue',
            'employee' => 'green',
            default => 'gray',
        }" size="sm" class="font-semibold text-xs md:text-sm">
            {{ ucfirst($user->role) }}
        </flux:badge>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 hidden md:table-cell">
        @if($user->phone)
            <div class="flex items-center gap-1.5 md:gap-2">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span class="text-xs md:text-sm text-gray-900 dark:text-white">{{ $user->phone }}</span>
            </div>
        @else
            <span class="text-xs md:text-sm text-gray-400 dark:text-gray-500">-</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 hidden md:table-cell">
        <span class="text-xs md:text-sm text-gray-900 dark:text-gray-500">{{ $user->created_at->format('Y-m-d') }}</span>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <div class="flex items-center gap-1.5 md:gap-2">
            @php
                $currentUser = auth()->user();
                $canDelete = $currentUser && in_array($currentUser->role, ['admin', 'manager']) 
                    && !($currentUser->role === 'manager' && ($currentUser->id === $user->id || $user->role === 'admin'));
            @endphp

            <!-- View Button -->
            <button @click="openPreview({{ $user->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-blue-700/60 bg-blue-500/10 p-1.5 transition-all duration-200 hover:border-blue-700 hover:bg-blue-500/20 hover:shadow-lg hover:shadow-blue-700/30" title="{{ __('View User') }}">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-blue-700 transition-all duration-200 group-hover:text-blue-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>

            <!-- Edit Button -->
            <button @click="openModal({{ $user->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 transition-all duration-200 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-700/30" title="{{ __('Edit User') }}">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-cyan-700 transition-all duration-200 group-hover:text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </button>

            <!-- Delete Button -->
            @if($canDelete)
                <button @click="window.confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}').then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-user', { userId: {{ $user->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 transition-all duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30" title="{{ __('Delete User') }}">
                    <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            @endif
        </div>
    </td>
</tr>

