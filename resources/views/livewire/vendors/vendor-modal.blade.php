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
                 class="w-screen max-w-2xl bg-white/60 backdrop-blur-xl dark:bg-gray-800/60">

                <div class="flex h-full flex-col overflow-y-auto border-l border-violet-300/50 bg-white/60 shadow-xl shadow-violet-200/40 backdrop-blur-xl dark:border-violet-800/50 dark:bg-gray-800/60 dark:shadow-violet-900/30">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-violet-400/20 to-purple-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-8 -left-8 h-64 w-64 rounded-full bg-gradient-to-br from-purple-400/20 to-violet-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-6 py-6 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $isEditing ? __('Edit Vendor') : __('Add New Vendor') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $isEditing ? __('Update vendor information') : __('Create a new vendor') }}
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
                            <!-- Vendor Name -->
                            <div>
                                <flux:input wire:model="name" label="{{ __('Vendor Name') }}" placeholder="{{ __('Enter vendor name') }}" required />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <flux:input type="email" wire:model="email" label="{{ __('Email') }}" placeholder="{{ __('Enter email address') }}" required />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <flux:input wire:model="phone" label="{{ __('Phone') }}" placeholder="{{ __('Enter phone number (optional)') }}" />
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Address -->
                            <div>
                                <flux:textarea wire:model="address" label="{{ __('Address') }}" placeholder="{{ __('Enter address (optional)') }}" rows="3" />
                                @error('address')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Website -->
                            <div>
                                <flux:input type="url" wire:model="website" label="{{ __('Website') }}" placeholder="{{ __('Enter website URL (optional)') }}" />
                                @error('website')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div>
                                <flux:select wire:model="status" label="{{ __('Status') }}" required>
                                    <option value="active">{{ __('Active') }}</option>
                                    <option value="inactive">{{ __('Inactive') }}</option>
                                </flux:select>
                                @error('status')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- External Vehicle Database Configuration Section -->
                            <div class="border-t border-gray-200 pt-6 dark:border-gray-700">
                                <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ __('External Vehicle Database Configuration') }}
                                </h3>
                                <p class="mb-4 text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Configure connection to external vehicle database and image storage for this vendor.') }}
                                </p>

                                <div class="space-y-4">
                                    <!-- Database Host -->
                                    <div>
                                        <flux:input wire:model="external_db_host" label="{{ __('Database Host') }}" placeholder="{{ __('e.g., senda.us') }}" required />
                                        @error('external_db_host')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Database Port -->
                                    <div>
                                        <flux:input wire:model="external_db_port" label="{{ __('Database Port') }}" placeholder="{{ __('e.g., 3306') }}" />
                                        @error('external_db_port')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Database Name -->
                                    <div>
                                        <flux:input wire:model="external_db_database" label="{{ __('Database Name') }}" placeholder="{{ __('e.g., avis_03oct') }}" required />
                                        @error('external_db_database')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Database Username -->
                                    <div>
                                        <flux:input wire:model="external_db_username" label="{{ __('Database Username') }}" placeholder="{{ __('Enter database username') }}" required />
                                        @error('external_db_username')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Database Password -->
                                    <div>
                                        <flux:input type="password" wire:model="external_db_password" label="{{ __('Database Password') }}" placeholder="{{ $isEditing ? __('Leave blank to keep current password') : __('Enter database password') }}" :required="!$isEditing" />
                                        @error('external_db_password')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                        @if($isEditing)
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Leave blank to keep the current password unchanged.') }}</p>
                                        @else
                                            <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Database password is required for new vendors.') }}</p>
                                        @endif
                                    </div>

                                    <!-- Image Path -->
                                    <div>
                                        <flux:input wire:model="external_image_path" label="{{ __('Image Path') }}" placeholder="{{ __('e.g., /home/kono/public_html/autocraft/avisnew/images/veh_images/') }}" required />
                                        @error('external_image_path')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Absolute path on the server where vehicle images are stored.') }}</p>
                                    </div>

                                    <!-- Image Base URL -->
                                    <div>
                                        <flux:input type="url" wire:model="external_image_base_url" label="{{ __('Image Base URL') }}" placeholder="{{ __('e.g., https://senda.us/autocraft/avisnew/images/veh_images/') }}" required />
                                        @error('external_image_base_url')
                                            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">{{ __('Base URL where vehicle images are publicly accessible.') }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-6 py-4 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                            <div class="flex items-center justify-end gap-3">
                                <flux:button type="button" wire:click="closeModal" variant="ghost">
                                    {{ __('Cancel') }}
                                </flux:button>
                                <flux:button type="submit" variant="primary" icon="check">
                                    {{ $isEditing ? __('Update Vendor') : __('Create Vendor') }}
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
