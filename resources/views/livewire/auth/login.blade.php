@php
    // Fetch all users for quick login (development/testing feature)
    $users = \App\Models\User::orderBy('name')->get();

    // Password mapping based on seeder (for development/testing only)
    $passwordMap = [
        'sulaiman@sendasnap.com' => 'password',
        'acj.shiroyama@gmail.com' => 'acjl7861',
        'zafar@kar-men.com' => '0898',
        'acj.document@gmail.com' => 'kasahara',
        'acjl.information@gmail.com' => 'password',
        'edo100@gmail.com' => 'password',
    ];

    // Default password for users not in the map
    $defaultPassword = 'password';
@endphp

<x-layouts.auth>
    <div class="flex flex-col gap-4">
        <!-- Admin Manual Link -->
        <div class="mb-2 flex justify-center">
            <flux:link :href="route('admin.manual')" wire:navigate class="text-sm text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100">
                <svg class="mr-1 inline h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>
                </svg>
                {{ __('Admin Manual') }}
            </flux:link>
        </div>

        <x-auth-header :title="__('Log in to your account')" :description="__('Enter your email and password below to log in')" />

        <!-- Session Status -->
        <x-auth-session-status class="text-center" :status="session('status')" />

        <form method="POST" action="{{ route('login.store') }}" id="login-form" class="flex flex-col gap-4">
            @csrf

            <!-- Email Address -->
            <flux:input
                id="email-input"
                name="email"
                :label="__('Email address')"
                type="email"
                required
                autofocus
                autocomplete="email"
                placeholder="email@example.com"
                value="{{ old('email') }}"
            />

            <!-- Password -->
            <div class="relative">
                <flux:input
                    id="password-input"
                    name="password"
                    :label="__('Password')"
                    type="password"
                    required
                    autocomplete="current-password"
                    :placeholder="__('Password')"
                    viewable
                />
            </div>

            <!-- Remember Me -->
            <flux:checkbox name="remember" :label="__('Remember me')" :checked="old('remember')" />

            <div class="flex items-center justify-end">
                <flux:button variant="primary" type="submit" class="w-full" data-test="login-button">
                    {{ __('Log in') }}
                </flux:button>
            </div>
        </form>

        <!-- Quick Login: User List (Development/Testing Feature) -->
        @if($users->count() > 0)
            <script>
                function fillLoginForm(email, password) {
                    // Use setTimeout to ensure DOM is ready
                    setTimeout(() => {
                        // Fill email field - try multiple selectors
                        let emailInput = document.querySelector('input[name="email"]') ||
                                        document.querySelector('#email-input input') ||
                                        document.querySelector('#email-input');

                        if (emailInput && emailInput.tagName === 'INPUT') {
                            emailInput.value = email;
                            emailInput.dispatchEvent(new Event('input', { bubbles: true }));
                            emailInput.dispatchEvent(new Event('change', { bubbles: true }));
                            emailInput.focus();
                        }

                        // Fill password field - try multiple selectors
                        let passwordInput = document.querySelector('input[name="password"]') ||
                                           document.querySelector('#password-input input[type="password"]') ||
                                           document.querySelector('#password-input');

                        if (passwordInput && passwordInput.tagName === 'INPUT') {
                            passwordInput.value = password;
                            passwordInput.dispatchEvent(new Event('input', { bubbles: true }));
                            passwordInput.dispatchEvent(new Event('change', { bubbles: true }));
                            passwordInput.focus();
                        }
                    }, 100);
                }
            </script>
            <div class="mt-6 w-full rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">
                <p class="mb-3 text-xs font-semibold text-gray-600 dark:text-gray-400">{{ __('Quick Login (Development)') }}</p>
                <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 lg:grid-cols-3">
                    @foreach($users as $user)
                        <button
                            type="button"
                            onclick="fillLoginForm('{{ $user->email }}', '{{ $passwordMap[$user->email] ?? $defaultPassword }}')"
                            class="group flex items-center justify-center rounded-md border border-gray-300 bg-white px-3 py-2 text-xs transition-all hover:border-emerald-500 hover:bg-emerald-50 dark:border-gray-600 dark:bg-gray-700 dark:hover:border-emerald-400 dark:hover:bg-emerald-900/20"
                            title="Click to fill {{ $user->email }}"
                        >
                            <span class="font-medium text-gray-700 group-hover:text-emerald-700 dark:text-gray-300 dark:group-hover:text-emerald-300">{{ $user->name }}</span>
                        </button>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-layouts.auth>
