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
                 class="relative w-full max-w-4xl transform overflow-hidden rounded-2xl bg-gradient-to-br from-blue-50 via-white to-cyan-50 shadow-2xl dark:from-blue-900/20 dark:via-gray-900 dark:to-cyan-900/20"
                 @click.away="open = false">
                <!-- Decorative Elements -->
                <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full bg-gradient-to-br from-blue-400/20 to-cyan-400/20 blur-2xl"></div>
                <div class="pointer-events-none absolute -bottom-8 -left-8 h-32 w-32 rounded-full bg-gradient-to-br from-cyan-400/20 to-blue-400/20 blur-2xl"></div>

                <!-- Content -->
                <div class="relative max-h-[90vh] overflow-y-auto p-6 pb-20">
                    @if($port)
                        <!-- Port Preview Card -->
                        <div class="relative overflow-hidden rounded-xl border border-blue-200/50 bg-white/50 p-6 mb-3 backdrop-blur-sm dark:border-blue-800/50 dark:bg-gray-800/50">

                            <div class="relative">
                                <div class="mb-4 flex items-center justify-between">
                                    <div class="flex items-center gap-3">
                                        <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-500 shadow-lg">
                                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                        </div>
                                        <div>
                                            <h4 class="text-xl font-bold text-gray-900 dark:text-white">{{ $port->port_name }}</h4>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Created') }} {{ $port->created_at->format('M d, Y') }}</p>
                                        </div>
                                    </div>
                                    <div class="flex flex-col items-end gap-2">
                                        <flux:badge color="blue" size="sm" class="font-semibold">
                                            {{ $port->port_type }}
                                        </flux:badge>
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <!-- Port Type -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Port Type') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $port->port_type }}</p>
                                        </div>
                                    </div>

                                    <!-- Port Address -->
                                    <div class="flex items-start gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50 sm:col-span-2">
                                        <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Port Address') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $port->port_address }}</p>
                                        </div>
                                    </div>

                                    <!-- Created At -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Created At') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $port->created_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $port->created_at->format('h:i A') }}</p>
                                        </div>
                                    </div>

                                    <!-- Updated At -->
                                    <div class="flex items-center gap-2 rounded-lg bg-white/50 p-3 backdrop-blur-sm dark:bg-gray-800/50">
                                        <svg class="h-5 w-5 flex-shrink-0 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                                        </svg>
                                        <div>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Updated At') }}</p>
                                            <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ $port->updated_at->format('M d, Y') }}</p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ $port->updated_at->format('h:i A') }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Action Buttons (Delete/Edit centered, Close on right) -->
                <div class="absolute bottom-0 left-0 right-0 grid grid-cols-3 items-center gap-3 border-t border-blue-200/30 bg-white/60 px-4 py-3 backdrop-blur-md dark:border-blue-800/30 dark:bg-gray-900/60">
                    <!-- Empty left column -->
                    <div></div>

                    <!-- Delete and Edit Buttons (Centered) -->
                    <div class="flex items-center justify-center gap-2">
                        <!-- Delete Button (red, conditional) -->
                        @if($this->canDelete())
                            @php
                                $scheduleCount = \App\Models\Schedule::where('start_port_id', $port->id)
                                    ->orWhere('end_port_id', $port->id)
                                    ->count();
                                $stopoverCount = \App\Models\ScheduleStopover::where('port_id', $port->id)->count();
                                $warnings = [];
                                if ($scheduleCount > 0) {
                                    $warnings[] = __(':count schedule(s)', ['count' => $scheduleCount]);
                                }
                                if ($stopoverCount > 0) {
                                    $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
                                }
                            @endphp
                            <button @click="window.confirmDelete({{ $port->id }}, '{{ addslashes($port->port_name) }}', @js($warnings)).then((result) => { if (result.isConfirmed) { $wire.deletePort() } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-500/70 bg-red-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-red-400 hover:bg-red-500/30 hover:shadow-lg hover:shadow-red-500/50">
                                <svg class="h-4 w-4 text-red-700 dark:text-red-200 transition-all duration-200 group-hover:text-red-900 dark:group-hover:text-red-100 group-hover:drop-shadow-[0_0_6px_rgba(239,68,68,0.9)]" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                                <span class="ml-1.5 text-xs font-semibold text-red-700 dark:text-red-200 group-hover:text-red-900 dark:group-hover:text-red-100">{{ __('Delete') }}</span>
                            </button>
                        @endif

                        <!-- Edit Button (cyan) -->
                        <button wire:click="editPort" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-500/70 bg-cyan-600/20 backdrop-blur-sm px-3 py-2 transition-all duration-200 hover:border-cyan-400 hover:bg-cyan-500/30 hover:shadow-lg hover:shadow-cyan-500/50">
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
