<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Particle Background Canvas (only for API Documentation) -->
        <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none" style="display: none;"></canvas>
        
        <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
            <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

            <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
                <x-app-logo />
            </a>

            <flux:navlist variant="outline">
                <flux:navlist.group :heading="__('Platform')" class="grid">
                    <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')" wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
                </flux:navlist.group>

                <flux:navlist.group :heading="__('Management')" class="grid">
                    <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>{{ __('Users') }}</flux:navlist.item>

                    <!-- Tasks with Submenu -->
                    <div x-data="{ open: {{ request()->routeIs('tasks.*') ? 'true' : 'false' }} }">
                        <flux:navlist.item
                            icon="clipboard"
                            @click="open = !open"
                            :current="request()->routeIs('tasks.*')"
                            class="cursor-pointer">
                            <div class="flex items-center justify-between w-full">
                                <span>{{ __('Tasks') }}</span>
                                <svg x-show="!open" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="open" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                                </svg>
                            </div>
                        </flux:navlist.item>

                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <flux:navlist.item
                                :href="route('tasks.today')"
                                :current="request()->routeIs('tasks.today')"
                                wire:navigate
                                class="text-sm">
                                {{ __("Today's Tasks") }}
                            </flux:navlist.item>
                            <flux:navlist.item
                                :href="route('tasks.all')"
                                :current="request()->routeIs('tasks.all')"
                                wire:navigate
                                class="text-sm">
                                {{ __('All Tasks') }}
                            </flux:navlist.item>
                            <flux:navlist.item
                                disabled
                                class="text-sm opacity-50 cursor-not-allowed">
                                {{ __('Kanban Board') }} <span class="text-xs">({{ __('Coming Soon') }})</span>
                            </flux:navlist.item>
                        </div>
                    </div>

                    <flux:navlist.item
                        icon="view-columns"
                        disabled
                        class="opacity-50 cursor-not-allowed">
                        {{ __('Vehicles') }} <span class="text-xs">({{ __('Coming Soon') }})</span>
                    </flux:navlist.item>
                </flux:navlist.group>
            </flux:navlist>

            <flux:spacer />

            <flux:navlist variant="outline">
                <flux:navlist.item icon="book-open-text" :href="route('admin.manual')" wire:navigate>
                    {{ __('Admin Manual') }}
                </flux:navlist.item>
                <flux:navlist.item icon="folder-git-2" :href="route('api.docs')" wire:navigate>
                    {{ __('API Documentation') }}
                </flux:navlist.item>
            </flux:navlist>

            <!-- Desktop User Menu -->
            <flux:dropdown class="hidden lg:block" position="bottom" align="start">
                <flux:profile
                    :name="auth()->user()->name"
                    :initials="auth()->user()->initials()"
                    icon:trailing="chevrons-up-down"
                />

                <flux:menu class="w-[220px]">
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:sidebar>

        <!-- Mobile User Menu -->
        <flux:header class="lg:hidden">
            <flux:sidebar.toggle class="lg:hidden" icon="bars-2" inset="left" />

            <flux:spacer />

            <flux:dropdown position="top" align="end">
                <flux:profile
                    :initials="auth()->user()->initials()"
                    icon-trailing="chevron-down"
                />

                <flux:menu>
                    <flux:menu.radio.group>
                        <div class="p-0 text-sm font-normal">
                            <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                                <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                    <span
                                        class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white"
                                    >
                                        {{ auth()->user()->initials() }}
                                    </span>
                                </span>

                                <div class="grid flex-1 text-start text-sm leading-tight">
                                    <span class="truncate font-semibold">{{ auth()->user()->name }}</span>
                                    <span class="truncate text-xs">{{ auth()->user()->email }}</span>
                                </div>
                            </div>
                        </div>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <flux:menu.radio.group>
                        <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}</flux:menu.item>
                    </flux:menu.radio.group>

                    <flux:menu.separator />

                    <form method="POST" action="{{ route('logout') }}" class="w-full">
                        @csrf
                        <flux:menu.item as="button" type="submit" icon="arrow-right-start-on-rectangle" class="w-full">
                            {{ __('Log Out') }}
                        </flux:menu.item>
                    </form>
                </flux:menu>
            </flux:dropdown>
        </flux:header>

        {{ $slot }}

        <!-- Toast Notifications -->
        <x-toast-notification />

        @fluxScripts
        <!-- SweetAlert2 -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            // Custom delete confirmation with SweetAlert2
            window.confirmDelete = function(taskId, taskTitle = null) {
                return Swal.fire({
                    title: '{{ __('Are you sure?') }}',
                    html: taskTitle 
                        ? `<p class="mb-2 font-semibold">${taskTitle}</p><p class="text-sm text-gray-600 dark:text-gray-400">{{ __('This action cannot be undone!') }}</p>`
                        : '{{ __('Are you sure you want to delete this task? This action cannot be undone!') }}',
                    iconHtml: '<div class="flex items-center justify-center p-4"><svg class="h-12 w-12 text-red-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg></div>',
                    showCancelButton: true,
                    confirmButtonColor: '#dc2626',
                    cancelButtonColor: '#6b7280',
                    confirmButtonText: '<svg class="inline-block h-4 w-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" /></svg>{{ __('Delete') }}',
                    cancelButtonText: '{{ __('Cancel') }}',
                    buttonsStyling: true,
                    customClass: {
                        popup: 'rounded-2xl border-2 border-red-200 dark:border-red-800 bg-white dark:bg-gray-900 p-6',
                        confirmButton: 'rounded-lg border-2 border-red-700/60 bg-red-500/10 px-4 py-2 text-red-700 hover:border-red-700 hover:bg-red-500/20 transition-all duration-200 font-semibold',
                        cancelButton: 'rounded-lg border-2 border-gray-400/50 bg-gray-500/10 px-4 py-2 text-gray-400 hover:border-gray-400 hover:bg-gray-500/20 transition-all duration-200 font-semibold',
                        icon: '!hidden'
                    },
                    reverseButtons: true
                });
            };
        </script>
        @stack('scripts')
    </body>
</html>
