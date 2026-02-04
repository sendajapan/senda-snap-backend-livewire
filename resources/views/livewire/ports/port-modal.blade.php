<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <!-- Background overlay -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 sm:inset-y-0 sm:right-0 flex max-w-full pl-0 sm:pl-10">
            <div x-show="open"
                 x-transition:enter="transform transition ease-in-out duration-500"
                 x-transition:enter-start="translate-y-full sm:translate-x-full"
                 x-transition:enter-end="translate-y-0 sm:translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500"
                 x-transition:leave-start="translate-y-0 sm:translate-x-0"
                 x-transition:leave-end="translate-y-full sm:translate-x-full"
                 class="w-full sm:w-screen sm:max-w-xl bg-white/60 backdrop-blur-xl dark:bg-gray-800/60 sm:rounded-none rounded-t-2xl sm:rounded-t-none">

                <div class="flex h-full flex-col overflow-y-auto border-t sm:border-t-0 sm:border-l border-blue-300/50 bg-white/60 shadow-xl shadow-blue-200/40 backdrop-blur-xl dark:border-blue-800/50 dark:bg-gray-800/60 dark:shadow-blue-900/30">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-4 sm:-right-8 -top-4 sm:-top-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-blue-400/20 to-cyan-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-4 sm:-bottom-8 -left-4 sm:-left-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-cyan-400/20 to-blue-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-ui-md py-ui-md backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                        <div class="flex items-center justify-between gap-ui-sm">
                            <div class="flex items-center gap-ui-sm min-w-0">
                                <div class="flex h-icon-sm w-icon-sm flex-shrink-0 items-center justify-center rounded-lg sm:rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg text-ui-lg [&_svg]:size-[1em]">
                                    <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-ui-lg font-bold text-gray-900 dark:text-white truncate">
                                        {{ $isEditing ? __('Edit Port') : __('Add New Port') }}
                                    </h2>
                                    <p class="text-ui-sm text-gray-600 dark:text-gray-400 line-clamp-1">
                                        {{ $isEditing ? __('Update port information') : __('Create a new port') }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click="closeModal" type="button" class="flex-shrink-0 rounded-lg p-ui-xs text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300 text-ui-xl [&_svg]:size-[1em]">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="save" class="relative flex-1 overflow-y-auto">
                        <div class="space-y-ui-md p-ui-md">
                            <!-- Port Name -->
                            <div>
                                <flux:input wire:model="port_name" label="{{ __('Port Name') }}" placeholder="{{ __('Enter port name') }}" required />
                                @error('port_name')
                                    <p class="mt-1 text-ui-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Port Type -->
                            <div>
                                <flux:select wire:model="port_type" label="{{ __('Port Type') }}" required>
                                    <option value="Auction">{{ __('Auction') }}</option>
                                    <option value="Yard">{{ __('Yard') }}</option>
                                    <option value="Local Port">{{ __('Local Port') }}</option>
                                    <option value="Overseas Port">{{ __('Overseas Port') }}</option>
                                </flux:select>
                                @error('port_type')
                                    <p class="mt-1 text-ui-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Port Address -->
                            <div>
                                <flux:textarea wire:model="port_address" label="{{ __('Port Address') }}" placeholder="{{ __('Enter port address') }}" rows="3" required />
                                @error('port_address')
                                    <p class="mt-1 text-ui-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-ui-md py-ui-sm backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-ui-xs">
                                <flux:button type="button" wire:click="closeModal" variant="ghost" class="w-full sm:w-auto">
                                    {{ __('Cancel') }}
                                </flux:button>
                                <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">
                                    {{ $isEditing ? __('Update Port') : __('Create Port') }}
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
