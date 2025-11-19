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
                    @if($user)
                        <!-- User Preview Card -->
                        <div class="relative overflow-hidden rounded-xl border border-blue-200 bg-gradient-to-br from-blue-50 via-white to-cyan-50 p-6 shadow-xl dark:border-blue-900/50 dark:from-blue-900/20 dark:via-gray-900 dark:to-cyan-900/20">
                            <!-- Decorative Elements -->
                            <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-blue-400/20 to-cyan-400/20 blur-2xl"></div>
                            <div class="pointer-events-none absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-cyan-400/20 to-blue-400/20 blur-2xl"></div>

                            <div class="relative">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="relative flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 shadow-lg">
                                            @if($user->avatar && $user->avatar_url)
                                                <img src="{{ $user->avatar_url }}" alt="{{ $user->name }}" class="h-12 w-12 rounded-xl object-cover ring-2 ring-blue-200 dark:ring-blue-800">
                                            @else
                                                <span class="text-lg font-bold text-white">{{ $user->initials() }}</span>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $user->name }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Member since') }} {{ $user->created_at->format('M Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <flux:badge :color="match($user->role) {
                                            'admin' => 'red',
                                            'manager' => 'blue',
                                            'employee' => 'green',
                                            default => 'gray',
                                        }" size="sm" class="font-semibold">
                                            {{ ucfirst($user->role) }}
                                        </flux:badge>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <!-- Email -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Email') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->email }}</p>
                                        </div>
                                    </div>

                                    <!-- Phone -->
                                    @if($user->phone)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Phone') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->phone }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Created At -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Created At') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>

                                    <!-- Updated At -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Updated At') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $user->updated_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="rounded-xl border border-gray-200 bg-white p-12 text-center dark:border-gray-700 dark:bg-gray-800">
                            <div class="flex flex-col items-center gap-3">
                                <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                    <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No user selected') }}</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Click the view icon on a user to preview them') }}</p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons (Center Bottom) -->
                @if($user)
                    <div class="absolute bottom-0 left-0 right-0 flex items-center justify-center gap-3 border-t border-gray-200/50 bg-white/95 p-4 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/95">
                        <!-- Edit Button -->
                        <button wire:click="editUser" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-600/50 bg-cyan-500/10 p-3 transition-all duration-200 hover:border-cyan-600 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-600/30">
                            <svg class="h-5 w-5 text-cyan-600 transition-all duration-200 group-hover:text-cyan-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span class="ml-2 text-sm font-semibold text-cyan-600">{{ __('Edit') }}</span>
                        </button>

                        <!-- Close Button -->
                        <button wire:click="closePreview" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-gray-400/50 bg-gray-500/10 p-3 transition-all duration-200 hover:border-gray-400 hover:bg-gray-500/20 hover:shadow-lg hover:shadow-gray-500/30">
                            <svg class="h-5 w-5 text-gray-400 transition-all duration-200 group-hover:text-gray-300" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="ml-2 text-sm font-semibold text-gray-400">{{ __('Close') }}</span>
                        </button>

                        <!-- Delete Button -->
                        @if($this->canDelete())
                            <button @click="window.confirmDelete({{ $user->id }}, '{{ addslashes($user->name) }}').then((result) => { if (result.isConfirmed) { $wire.deleteUser() } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-600/50 bg-red-500/10 p-3 transition-all duration-200 hover:border-red-600 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-600/30">
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
