<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-transition:enter="transition ease-out duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition ease-in duration-200"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <!-- Background overlay -->
        <div class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-y-0 right-0 flex max-w-full pl-10">
            <div x-show="open"
                 x-transition:enter="transform transition ease-in-out duration-500"
                 x-transition:enter-start="translate-x-full"
                 x-transition:enter-end="translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500"
                 x-transition:leave-start="translate-x-0"
                 x-transition:leave-end="translate-x-full"
                 class="w-screen max-w-xl bg-white/90">

                <div class="flex h-full flex-col overflow-y-auto border-l border-blue-200 bg-gradient-to-br from-white via-blue-50/30 to-cyan-50/30 shadow-2xl dark:border-blue-900/50 dark:from-gray-900 dark:via-blue-900/20 dark:to-cyan-900/20">
                    <!-- Decorative Elements -->
                    <div class="pointer-events-none absolute -right-8 -top-8 h-64 w-64 rounded-full bg-gradient-to-br from-blue-400/20 to-cyan-400/20 blur-3xl"></div>
                    <div class="pointer-events-none absolute -bottom-8 -left-8 h-64 w-64 rounded-full bg-gradient-to-br from-cyan-400/20 to-blue-400/20 blur-3xl"></div>

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-6 py-6 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/50">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 shadow-lg">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <h2 class="text-xl font-bold text-gray-900 dark:text-white">
                                        {{ $isEditing ? __('Edit User') : __('Add New User') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">
                                        {{ $isEditing ? __('Update user information') : __('Create a new user account') }}
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
                            <!-- Avatar Upload -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                                    {{ __('Profile Picture') }}
                                </label>
                                <div class="mt-2 flex items-center gap-4">
                                    <div class="relative">
                                        @if ($avatar)
                                            <img src="{{ $avatar->temporaryUrl() }}" alt="Avatar preview" class="h-24 w-24 rounded-xl object-cover ring-4 ring-blue-200 dark:ring-blue-800">
                                        @elseif ($existing_avatar)
                                            <img src="{{ Storage::url($existing_avatar) }}" alt="Current avatar" class="h-24 w-24 rounded-xl object-cover ring-4 ring-blue-200 dark:ring-blue-800">
                                        @else
                                            <div class="flex h-24 w-24 items-center justify-center rounded-xl bg-gradient-to-br from-blue-500 to-cyan-600 ring-4 ring-blue-200 dark:ring-blue-800">
                                                <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex flex-col gap-2">
                                        <label for="avatar" class="cursor-pointer rounded-lg border-2 border-dashed border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 transition-colors hover:border-blue-500 hover:bg-blue-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-300 dark:hover:border-blue-500 dark:hover:bg-blue-900/20">
                                            {{ __('Choose Image') }}
                                        </label>
                                        <input type="file" id="avatar" wire:model="avatar" accept="image/*" class="hidden">
                                        @if ($avatar || $existing_avatar)
                                            <button type="button" wire:click="removeAvatar" class="rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">
                                                {{ __('Remove') }}
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('JPG, PNG or GIF. Max size 2MB.') }}</p>
                                @error('avatar')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                                <div wire:loading wire:target="avatar" class="mt-2 text-sm text-blue-600">
                                    {{ __('Uploading...') }}
                                </div>
                            </div>

                            <!-- Name -->
                            <div>
                                <flux:input wire:model="name" label="{{ __('Full Name') }}" placeholder="{{ __('Enter full name') }}" required />
                                @error('name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div>
                                <flux:input type="email" wire:model="email" label="{{ __('Email Address') }}" placeholder="{{ __('Enter email address') }}" required />
                                @error('email')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div>
                                <flux:input type="password" wire:model="password" label="{{ $isEditing ? __('New Password (leave empty to keep current)') : __('Password') }}" placeholder="{{ __('Enter password') }}" :required="!$isEditing" />
                                @error('password')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div>
                                <flux:input type="password" wire:model="password_confirmation" label="{{ __('Confirm Password') }}" placeholder="{{ __('Confirm password') }}" :required="!$isEditing" />
                                @error('password_confirmation')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Role -->
                            <div>
                                <flux:select wire:model="role" label="{{ __('Role') }}" required>
                                    <option value="client">{{ __('Client') }}</option>
                                    <option value="employee">{{ __('Employee') }}</option>
                                    <option value="manager">{{ __('Manager') }}</option>
                                    <option value="admin">{{ __('Admin') }}</option>
                                </flux:select>
                                @error('role')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Phone -->
                            <div>
                                <flux:input type="tel" wire:model="phone" label="{{ __('Phone Number') }}" placeholder="{{ __('Enter phone number') }}" />
                                @error('phone')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Avis ID -->
                            <div>
                                <flux:input wire:model="avis_id" label="{{ __('Avis ID') }}" placeholder="{{ __('Enter Avis ID (optional)') }}" />
                                @error('avis_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-6 py-4 backdrop-blur-sm dark:border-gray-700/50">
                            <div class="flex items-center justify-end gap-3">
                                <flux:button type="button" wire:click="closeModal" variant="ghost">
                                    {{ __('Cancel') }}
                                </flux:button>
                                <flux:button type="submit" variant="primary" icon="check">
                                    {{ $isEditing ? __('Update User') : __('Create User') }}
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

