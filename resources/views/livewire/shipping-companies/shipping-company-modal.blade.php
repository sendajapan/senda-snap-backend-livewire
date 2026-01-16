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
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div x-show="open"
                 x-transition:enter="transform transition ease-in-out duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-2xl bg-white/90">

                <div class="flex h-full flex-col overflow-y-auto border-l border-indigo-200 bg-gradient-to-br from-white via-indigo-50/30 to-purple-50/30 shadow-2xl dark:border-indigo-900/50 dark:from-gray-900 dark:via-indigo-900/20 dark:to-purple-900/20">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-indigo-400/20 to-purple-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-8 -left-8 h-64 w-64 rounded-full bg-gradient-to-br from-purple-400/20 to-indigo-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-6 py-6 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9l9-6 9 6v9a2 2 0 0 1-2 2h-4a2 2 0 0 1-2-2V9" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $isEditing ? __('Edit Shipping Company') : __('Add New Shipping Company') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $isEditing ? __('Update shipping company information') : __('Create a new shipping company') }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click="closeModal" type="button" class="rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="save" class="relative flex-1 overflow-y-auto">
                        <div class="space-y-6 p-6">
                            <!-- Company Name -->
                            <div>
                                <flux:input wire:model="company_name" label="{{ __('Company Name') }}" placeholder="{{ __('Enter company name') }}" required />
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Name JP -->
                            <div>
                                <flux:input wire:model="company_name_jp" label="{{ __('Company Name (Japanese)') }}" placeholder="{{ __('Enter company name in Japanese (optional)') }}" />
                                @error('company_name_jp')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Type -->
                            <div>
                                <flux:select wire:model="company_type" label="{{ __('Company Type') }}" required>
                                    <option value="Transporter">{{ __('Transporter') }}</option>
                                    <option value="Shipping Line">{{ __('Shipping Line') }}</option>
                                    <option value="Workshop">{{ __('Workshop') }}</option>
                                    <option value="PROVIDER">{{ __('PROVIDER') }}</option>
                                    <option value="EXPENSE">{{ __('EXPENSE') }}</option>
                                    <option value="COURIER">{{ __('COURIER') }}</option>
                                </flux:select>
                                @error('company_type')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Status -->
                            <div>
                                <flux:select wire:model="company_status" label="{{ __('Company Status') }}">
                                    <option value="Active">{{ __('Active') }}</option>
                                    <option value="Inactive">{{ __('Inactive') }}</option>
                                </flux:select>
                                @error('company_status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Pricing -->
                            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                <div>
                                    <flux:input type="number" wire:model="per_m3" label="{{ __('Per m³') }}" placeholder="{{ __('Enter price per m³') }}" min="0" />
                                    @error('per_m3')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <flux:input type="number" wire:model="per_container" label="{{ __('Per Container') }}" placeholder="{{ __('Enter price per container') }}" min="0" />
                                    @error('per_container')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Address Fields -->
                            <div class="space-y-4">
                                <h3 class="text-sm font-semibold text-gray-700 dark:text-gray-300">{{ __('Address Information') }}</h3>
                                
                                <div>
                                    <flux:input wire:model="address" label="{{ __('Address') }}" placeholder="{{ __('Enter street address') }}" />
                                    @error('address')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <flux:input wire:model="city" label="{{ __('City') }}" placeholder="{{ __('Enter city') }}" />
                                        @error('city')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <flux:input wire:model="state" label="{{ __('State/Province') }}" placeholder="{{ __('Enter state or province') }}" />
                                        @error('state')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>

                                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                                    <div>
                                        <flux:input wire:model="zip" label="{{ __('ZIP/Postal Code') }}" placeholder="{{ __('Enter ZIP or postal code') }}" />
                                        @error('zip')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                    <div>
                                        <flux:input wire:model="country_name" label="{{ __('Country') }}" placeholder="{{ __('Enter country name') }}" />
                                        @error('country_name')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-6 py-4 backdrop-blur-sm dark:border-gray-700/50">
                            <div class="flex items-center justify-end gap-3">
                                <flux:button type="button" wire:click="closeModal" variant="ghost">
                                    {{ __('Cancel') }}
                                </flux:button>
                                <flux:button type="submit" variant="primary" icon="check">
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
