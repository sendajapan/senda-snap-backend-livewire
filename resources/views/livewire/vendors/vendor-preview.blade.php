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
                 class="relative w-full max-w-4xl transform overflow-hidden rounded-2xl bg-gradient-to-br from-violet-50 via-white to-purple-50 shadow-2xl dark:from-violet-900/20 dark:via-gray-900 dark:to-purple-900/20"
                 @click.away="open = false">
                <!-- Decorative Elements -->
                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-violet-400/20 to-purple-400/20 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-purple-400/20 to-violet-400/20 blur-2xl"></div>

                <!-- Content -->
                <div class="relative max-h-[90vh] overflow-y-auto p-6 pb-20">
                    @if($vendor)
                        <!-- Vendor Preview Card -->
                        <div class="relative overflow-hidden rounded-xl border border-violet-200/50 bg-white/50 p-6 mb-3 backdrop-blur-sm dark:border-violet-800/50 dark:bg-gray-800/50">

                            <div class="relative">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-500 shadow-lg">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $vendor->name }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Created') }} {{ $vendor->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <flux:badge :color="$vendor->status === 'active' ? 'emerald' : 'gray'" size="sm" class="font-semibold">
                                            {{ ucfirst($vendor->status) }}
                                        </flux:badge>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <!-- Email -->
                                    @if($vendor->email)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Email') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $vendor->email }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Phone -->
                                    @if($vendor->phone)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Phone') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $vendor->phone }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Website -->
                                    @if($vendor->website)
                                        <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                            <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Website') }}</p>
                                                <a href="{{ $vendor->website }}" target="_blank" rel="noopener noreferrer" class="text-sm font-semibold text-violet-600 dark:text-violet-400 hover:text-violet-700 dark:hover:text-violet-300 hover:underline">
                                                    {{ $vendor->website }}
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Address -->
                                    @if($vendor->address)
                                        <div class="flex items-start gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50 sm:col-span-2">
                                            <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <div>
                                                <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Address') }}</p>
                                                <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $vendor->address }}</p>
                                            </div>
                                        </div>
                                    @endif

                                    <!-- Created At -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Created At') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $vendor->created_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $vendor->created_at->format('h:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Updated At -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Updated At') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $vendor->updated_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $vendor->updated_at->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- External Vehicle Database Configuration Section -->
                                @if($vendor->external_db_host || $vendor->external_db_database || $vendor->external_image_path)
                                    <div class="mt-4 rounded-xl border border-blue-200/50 bg-blue-50/50 p-4 backdrop-blur-sm dark:border-blue-800/50 dark:bg-blue-900/20">
                                        <div class="mb-3 flex items-center gap-2">
                                            <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                            </svg>
                                            <h5 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('External Vehicle Database Configuration') }}</h5>
                                        </div>

                                        <div class="grid grid-cols-1 gap-3 sm:grid-cols-2">
                                            <!-- Database Host -->
                                            @if($vendor->external_db_host)
                                                <div class="flex items-start gap-2 rounded-lg bg-white/50 p-2 backdrop-blur-sm dark:bg-gray-800/50">
                                                    <svg class="h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                                                    </svg>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Database Host') }}</p>
                                                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $vendor->external_db_host }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Database Port -->
                                            @if($vendor->external_db_port)
                                                <div class="flex items-start gap-2 rounded-lg bg-white/50 p-2 backdrop-blur-sm dark:bg-gray-800/50">
                                                    <svg class="h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 20l4-16m2 16l4-16M6 9h14M4 15h14" />
                                                    </svg>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Database Port') }}</p>
                                                        <p class="text-xs font-semibold text-gray-900 dark:text-white">{{ $vendor->external_db_port }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Database Name -->
                                            @if($vendor->external_db_database)
                                                <div class="flex items-start gap-2 rounded-lg bg-white/50 p-2 backdrop-blur-sm dark:bg-gray-800/50">
                                                    <svg class="h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.582 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.582 4 8 4s8-1.79 8-4M4 7c0-2.21 3.582-4 8-4s8 1.79 8 4m0 5c0 2.21-3.582 4-8 4s-8-1.79-8-4" />
                                                    </svg>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Database Name') }}</p>
                                                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $vendor->external_db_database }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Database Username -->
                                            @if($vendor->external_db_username)
                                                <div class="flex items-start gap-2 rounded-lg bg-white/50 p-2 backdrop-blur-sm dark:bg-gray-800/50">
                                                    <svg class="h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                    </svg>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Database Username') }}</p>
                                                        <p class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $vendor->external_db_username }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Image Path -->
                                            @if($vendor->external_image_path)
                                                <div class="flex items-start gap-2 rounded-lg bg-white/50 p-2 backdrop-blur-sm dark:bg-gray-800/50 sm:col-span-2">
                                                    <svg class="h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    </svg>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Image Path') }}</p>
                                                        <p class="text-xs font-semibold text-gray-900 dark:text-white break-all">{{ $vendor->external_image_path }}</p>
                                                    </div>
                                                </div>
                                            @endif

                                            <!-- Image Base URL -->
                                            @if($vendor->external_image_base_url)
                                                <div class="flex items-start gap-2 rounded-lg bg-white/50 p-2 backdrop-blur-sm dark:bg-gray-800/50 sm:col-span-2">
                                                    <svg class="h-4 w-4 flex-shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                                                    </svg>
                                                    <div class="min-w-0 flex-1">
                                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Image Base URL') }}</p>
                                                        <a href="{{ $vendor->external_image_base_url }}" target="_blank" rel="noopener noreferrer" class="text-xs font-semibold text-blue-600 dark:text-blue-400 hover:text-blue-700 dark:hover:text-blue-300 hover:underline break-all">
                                                            {{ $vendor->external_image_base_url }}
                                                        </a>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons (Delete/Edit centered, Close on right) -->
                <div class="absolute bottom-0 left-0 right-0 grid grid-cols-3 items-center gap-3 border-t border-violet-200/30 bg-white/60 px-4 py-3 backdrop-blur-md dark:border-violet-800/30 dark:bg-gray-900/60">
                    <!-- Empty left column -->
                    <div></div>

                    <!-- Delete and Edit Buttons (Centered) -->
                    <div class="flex items-center justify-center gap-2">
                        <!-- Delete Button (red, conditional) -->
                        @if($this->canDelete())
                            @php
                                $warnings = $this->getVendorWarnings();
                            @endphp
                            <button @click="window.confirmDelete({{ $vendor->id }}, '{{ addslashes($vendor->name) }}', @js($warnings)).then((result) => { if (result.isConfirmed) { $wire.deleteVendor() } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-500/70 bg-red-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-red-400 hover:bg-red-500/30 hover:shadow-lg hover:shadow-red-500/50">
                                <svg class="h-4 w-4 text-red-700 dark:text-red-200 transition-all duration-200 group-hover:text-red-900 dark:group-hover:text-red-100 group-hover:drop-shadow-[0_0_6px_rgba(239,68,68,0.9)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                <span class="ml-1.5 text-xs font-semibold text-red-700 dark:text-red-200 group-hover:text-red-900 dark:group-hover:text-red-100">{{ __('Delete') }}</span>
                            </button>
                        @endif

                        <!-- Edit Button (cyan) -->
                        <button wire:click="editVendor" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-500/70 bg-cyan-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/30 hover:shadow-lg hover:shadow-cyan-500/50">
                            <svg class="h-4 w-4 text-cyan-700 dark:text-cyan-200 transition-all duration-200 group-hover:text-cyan-900 dark:group-hover:text-cyan-100 group-hover:drop-shadow-[0_0_6px_rgba(6,182,212,0.9)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                            <span class="ml-1.5 text-xs font-semibold text-cyan-700 dark:text-cyan-200 group-hover:text-cyan-900 dark:group-hover:text-cyan-100">{{ __('Edit') }}</span>
                        </button>
                    </div>

                    <!-- Close Button (Right) -->
                    <div class="flex justify-end">
                        <button wire:click="closePreview" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-gray-500/60 bg-gray-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-gray-400 hover:bg-gray-500/30 hover:shadow-lg hover:shadow-gray-500/40">
                            <svg class="h-4 w-4 text-gray-700 dark:text-gray-200 transition-all duration-200 group-hover:text-gray-900 dark:group-hover:text-white group-hover:drop-shadow-[0_0_6px_rgba(156,163,175,0.9)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                            <span class="ml-1.5 text-xs font-semibold text-gray-700 dark:text-gray-200 group-hover:text-gray-900 dark:group-hover:text-white">{{ __('Close') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
