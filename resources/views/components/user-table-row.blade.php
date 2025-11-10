@props(['user'])

<tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-emerald-50/50 hover:to-teal-50/50 dark:hover:from-emerald-900/10 dark:hover:to-teal-900/10">
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center">
            <div class="relative size-12 flex-shrink-0">
                @if($user->avatar)
                    <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="size-12 rounded-xl object-cover ring-2 ring-emerald-200 dark:ring-emerald-800">
                @else
                    <div class="flex size-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg ring-2 ring-emerald-200 dark:ring-emerald-800">
                        <span class="text-base font-bold text-white">
                            {{ $user->initials() }}
                        </span>
                    </div>
                @endif
                <div class="absolute -bottom-1 -right-1 h-4 w-4 rounded-full border-2 border-white bg-green-500 dark:border-gray-900"></div>
            </div>
            <div class="ml-4">
                <div class="text-sm font-bold text-gray-900 dark:text-white">
                    {{ $user->name }}
                </div>
                <div class="text-xs text-gray-500 dark:text-gray-400">
                    {{ __('Member since :date', ['date' => $user->created_at->format('M Y')]) }}
                </div>
            </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
            </svg>
            <span class="text-sm text-gray-900 dark:text-white">{{ $user->email }}</span>
        </div>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <flux:badge :color="match($user->role) {
            'admin' => 'red',
            'manager' => 'blue',
            'employee' => 'green',
            default => 'gray',
        }" size="sm" class="font-semibold">
            {{ ucfirst($user->role) }}
        </flux:badge>
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        @if($user->phone)
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                </svg>
                <span class="text-sm text-gray-900 dark:text-white">{{ $user->phone }}</span>
            </div>
        @else
            <span class="text-sm text-gray-400 dark:text-gray-500">-</span>
        @endif
    </td>
    <td class="whitespace-nowrap px-6 py-5">
        <div class="flex items-center gap-2">
            <flux:button size="sm" variant="ghost" @click="openModal({{ $user->id }})" icon="pencil" class="opacity-0 transition-opacity group-hover:opacity-100">
                {{ __('Edit') }}
            </flux:button>
        </div>
    </td>
</tr>

