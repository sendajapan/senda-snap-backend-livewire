<section class="w-full">
    @include('partials.settings-heading')

    <x-settings.layout :heading="__('Profile')" :subheading="__('Update your profile information, password, and profile picture')">
        <div class="my-6 w-full space-y-8">
            <!-- Profile Picture Section -->
            <div class="space-y-4">
                <flux:heading size="sm">{{ __('Profile Picture') }}</flux:heading>
                
                <div class="flex items-start gap-6">
                    <div class="flex-shrink-0">
                        <div class="relative size-24 overflow-hidden rounded-xl ring-2 ring-blue-200 dark:ring-blue-800">
                            @if (auth()->user()->avatar && auth()->user()->avatar_url)
                                <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="size-24 object-cover">
                            @else
                                <div class="flex size-24 items-center justify-center bg-gradient-to-br from-blue-400 to-cyan-500">
                                    <span class="text-2xl font-bold text-white">{{ auth()->user()->initials() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                    
                    <div class="flex flex-1 flex-col gap-3">
                        <div class="flex items-center gap-3">
                            <label for="avatar-upload" class="cursor-pointer rounded-lg border-2 border-dashed border-blue-300 bg-blue-50/50 px-4 py-2 text-sm font-medium text-blue-700 transition-colors hover:border-blue-500 hover:bg-blue-100 dark:border-blue-700 dark:bg-blue-900/20 dark:text-blue-400 dark:hover:bg-blue-900/30">
                                {{ __('Choose Image') }}
                            </label>
                            <input type="file" id="avatar-upload" wire:model="avatar" accept="image/*" class="hidden">
                            
                            @if (auth()->user()->avatar || $avatar)
                                <button type="button" wire:click="removeAvatar" class="rounded-lg border border-red-300 bg-white px-4 py-2 text-sm font-medium text-red-600 transition-colors hover:bg-red-50 dark:border-red-800 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20">
                                    {{ __('Remove') }}
                                </button>
                            @endif
                        </div>
                        
                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('JPG, PNG or GIF. Max size 2MB.') }}</p>
                        
                        @error('avatar')
                            <p class="text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                        @enderror
                        
                        <div wire:loading wire:target="avatar" class="text-sm text-blue-600 dark:text-blue-400">
                            {{ __('Uploading...') }}
                        </div>
                        
                        @if ($avatar)
                            <div class="mt-2">
                                <flux:text class="text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('New image selected: :filename', ['filename' => $avatar->getClientOriginalName()]) }}
                                </flux:text>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <flux:separator />

            <!-- Profile Information Form -->
            <form wire:submit="updateProfileInformation" class="space-y-6">
                <flux:heading size="sm">{{ __('Profile Information') }}</flux:heading>
                
                <flux:input wire:model="name" :label="__('Name')" type="text" required autofocus autocomplete="name" />

                <div>
                    <flux:input wire:model="email" :label="__('Email')" type="email" required autocomplete="email" />

                    @if (auth()->user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !auth()->user()->hasVerifiedEmail())
                        <div>
                            <flux:text class="mt-4">
                                {{ __('Your email address is unverified.') }}

                                <flux:link class="text-sm cursor-pointer" wire:click.prevent="resendVerificationNotification">
                                    {{ __('Click here to re-send the verification email.') }}
                                </flux:link>
                            </flux:text>

                            @if (session('status') === 'verification-link-sent')
                                <flux:text class="mt-2 font-medium !dark:text-emerald-400 !text-emerald-600">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </flux:text>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Save Profile') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="profile-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>

            <flux:separator />

            <!-- Password Update Form -->
            <form wire:submit="updatePassword" class="space-y-6">
                <flux:heading size="sm">{{ __('Update Password') }}</flux:heading>
                
                <flux:input
                    wire:model="current_password"
                    :label="__('Current password')"
                    type="password"
                    required
                    autocomplete="current-password"
                />
                
                <flux:input
                    wire:model="password"
                    :label="__('New password')"
                    type="password"
                    required
                    autocomplete="new-password"
                />
                
                <flux:input
                    wire:model="password_confirmation"
                    :label="__('Confirm Password')"
                    type="password"
                    required
                    autocomplete="new-password"
                />

                <div class="flex items-center gap-4">
                    <div class="flex items-center justify-end">
                        <flux:button variant="primary" type="submit" class="w-full">{{ __('Update Password') }}</flux:button>
                    </div>

                    <x-action-message class="me-3" on="password-updated">
                        {{ __('Saved.') }}
                    </x-action-message>
                </div>
            </form>
        </div>
    </x-settings.layout>
</section>
