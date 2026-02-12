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
        <div class="fixed inset-0 sm:inset-y-0 sm:right-0 sm:left-auto flex max-w-full pl-0 sm:pl-10 justify-end">
            <div x-show="open"
                 x-transition:enter="transform transition ease-in-out duration-500"
                 x-transition:enter-start="translate-y-full sm:translate-y-0 sm:translate-x-full"
                 x-transition:enter-end="translate-y-0 sm:translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500"
                 x-transition:leave-start="translate-y-0 sm:translate-x-0"
                 x-transition:leave-end="translate-y-full sm:translate-y-0 sm:translate-x-full"
                 class="w-full sm:w-screen sm:max-w-2xl bg-white/60 backdrop-blur-xl dark:bg-gray-800/60 sm:rounded-none rounded-t-2xl sm:rounded-t-none">

                <div class="flex h-full flex-col overflow-y-auto border-t sm:border-t-0 sm:border-l border-indigo-300/50 bg-white/60 shadow-xl shadow-indigo-200/40 backdrop-blur-xl dark:border-indigo-800/50 dark:bg-gray-800/60 dark:shadow-indigo-900/30">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-4 sm:-right-8 -top-4 sm:-top-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-indigo-400/20 to-purple-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-4 sm:-bottom-8 -left-4 sm:-left-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-purple-400/20 to-indigo-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-4 py-4 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="flex h-icon-sm w-icon-sm flex-shrink-0 items-center justify-center rounded-lg sm:rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg text-lg [&_svg]:size-[1em]">
                                    <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-lg font-bold text-gray-900 dark:text-white truncate">
                                        {{ $isEditing ? __('Edit Shipping Company') : __('Add New Shipping Company') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1">
                                        {{ $isEditing ? __('Update shipping company information') : __('Create a new shipping company') }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click="closeModal" type="button" class="flex-shrink-0 rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300 text-xl [&_svg]:size-[1em]">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="save" class="relative flex-1 overflow-y-auto">
                        <div class="space-y-4 p-4">
                            <!-- Line Name -->
                            <div>
                                <flux:input wire:model="line_name" label="{{ __('Shipping Company Name') }}" placeholder="{{ __('Enter shipping company name') }}" required />
                                @error('line_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <flux:select wire:model="status" label="{{ __('Status') }}">
                                    <option value="Active">{{ __('Active') }}</option>
                                    <option value="Inactive">{{ __('Inactive') }}</option>
                                </flux:select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-4 py-3 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2">
                                <flux:button type="button" wire:click="closeModal" variant="ghost" class="w-full sm:w-auto">
                                    {{ __('Cancel') }}
                                </flux:button>
                                <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">
                                    {{ $isEditing ? __('Update Shipping Company') : __('Create Shipping Company') }}
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
