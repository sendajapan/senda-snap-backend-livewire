<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <style>
            /* Compact Glass with Gradient Stroke for Selected Sidebar Items */
            /* Target Flux UI current/active states with multiple selectors */
            [data-flux-navlist-item][data-current="true"],
            [data-flux-navlist-item][aria-current="page"],
            [data-flux-navlist-item].current,
            .flux-navlist-item[data-current="true"],
            .flux-navlist-item[aria-current="page"],
            flux\\:navlist\\.item[data-current="true"],
            [data-current="true"][class*="navlist"],
            a[data-current="true"],
            button[data-current="true"] {
                background: linear-gradient(to right, rgba(59, 130, 246, 0.1), rgba(99, 102, 241, 0.05), rgba(255, 255, 255, 0.4)) !important;
                border: 1px solid rgba(59, 130, 246, 0.5) !important;
                border-radius: 0.75rem !important;
                box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -2px rgba(59, 130, 246, 0.1) !important;
                backdrop-filter: blur(16px) !important;
                -webkit-backdrop-filter: blur(16px) !important;
                position: relative;
                overflow: hidden;
                margin: 2px 0;
            }
            
            /* Left glow effect - matching status labels */
            [data-flux-navlist-item][data-current="true"]::before,
            [data-flux-navlist-item][aria-current="page"]::before,
            [data-flux-navlist-item].current::before,
            a[data-current="true"]::before,
            button[data-current="true"]::before {
                content: '';
                position: absolute;
                left: -0.75rem;
                top: 50%;
                transform: translateY(-50%);
                width: 3rem;
                height: 3rem;
                background: rgba(59, 130, 246, 0.2);
                border-radius: 50%;
                filter: blur(1rem);
                pointer-events: none;
                z-index: 0;
            }
            
            [data-flux-navlist-item][data-current="true"]:hover,
            [data-flux-navlist-item][aria-current="page"]:hover,
            [data-flux-navlist-item].current:hover,
            a[data-current="true"]:hover,
            button[data-current="true"]:hover {
                background: linear-gradient(to right, rgba(59, 130, 246, 0.15), rgba(99, 102, 241, 0.08), rgba(255, 255, 255, 0.5)) !important;
                border-color: rgba(59, 130, 246, 0.6) !important;
                box-shadow: 0 10px 15px -3px rgba(59, 130, 246, 0.15), 0 4px 6px -4px rgba(59, 130, 246, 0.1) !important;
                transform: scale(1.02);
            }
            
            [data-flux-navlist-item][data-current="true"]:hover::before,
            [data-flux-navlist-item][aria-current="page"]:hover::before,
            [data-flux-navlist-item].current:hover::before,
            a[data-current="true"]:hover::before,
            button[data-current="true"]:hover::before {
                background: rgba(59, 130, 246, 0.4);
            }
            
            /* Dark mode adjustments */
            .dark [data-flux-navlist-item][data-current="true"],
            .dark [data-flux-navlist-item][aria-current="page"],
            .dark [data-flux-navlist-item].current,
            .dark a[data-current="true"],
            .dark button[data-current="true"] {
                background: linear-gradient(to right, rgba(59, 130, 246, 0.2), rgba(99, 102, 241, 0.1), rgba(17, 24, 39, 0.4)) !important;
                border-color: rgba(59, 130, 246, 0.3) !important;
                box-shadow: 0 4px 6px -1px rgba(59, 130, 246, 0.1), 0 2px 4px -2px rgba(59, 130, 246, 0.05) !important;
            }
            
            .dark [data-flux-navlist-item][data-current="true"]::before,
            .dark [data-flux-navlist-item][aria-current="page"]::before,
            .dark [data-flux-navlist-item].current::before,
            .dark a[data-current="true"]::before,
            .dark button[data-current="true"]::before {
                background: rgba(59, 130, 246, 0.35);
            }
            
            .dark [data-flux-navlist-item][data-current="true"]:hover,
            .dark [data-flux-navlist-item][aria-current="page"]:hover,
            .dark [data-flux-navlist-item].current:hover,
            .dark a[data-current="true"]:hover,
            .dark button[data-current="true"]:hover {
                background: linear-gradient(to right, rgba(59, 130, 246, 0.25), rgba(99, 102, 241, 0.15), rgba(17, 24, 39, 0.5)) !important;
                border-color: rgba(59, 130, 246, 0.5) !important;
            }
            
            /* Smooth transition for all sidebar items */
            [data-flux-navlist-item],
            .flux-navlist-item,
            [class*="navlist-item"] {
                transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1) !important;
            }
            
            /* Non-active items hover effect */
            [data-flux-navlist-item]:not([data-current="true"]):hover,
            a:not([data-current="true"]):hover[class*="navlist"] {
                background: rgba(59, 130, 246, 0.05) !important;
                border-radius: 0.75rem;
            }
            
            .dark [data-flux-navlist-item]:not([data-current="true"]):hover {
                background: rgba(59, 130, 246, 0.1) !important;
            }
        </style>
    </head>
    <body class="min-h-screen bg-white dark:bg-zinc-800">
        <!-- Particle Background Canvas (enabled for all pages) -->
        <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>
        
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
                    @if(auth()->user()?->role === 'admin')
                        <flux:navlist.item icon="building-office" :href="route('vendors.index')" :current="request()->routeIs('vendors.*')" wire:navigate>{{ __('Vendors') }}</flux:navlist.item>
                    @endif
                    <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')" wire:navigate>{{ __('Users') }}</flux:navlist.item>

                    <!-- Tasks with Submenu -->
                    <div x-data="{ open: true }">
                        <flux:navlist.item
                            icon="clipboard"
                            @click="open = !open"
                            :current="request()->routeIs('tasks.*')"
                            class="cursor-pointer">
                            <div class="flex items-center justify-between w-full">
                                <span>{{ __('Tasks') }}</span>
                                <svg x-show="open" class="h-4 w-4 transition-transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="!open" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
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
                                :href="route('tasks.kanban')"
                                :current="request()->routeIs('tasks.kanban')"
                                wire:navigate
                                class="text-sm">
                                {{ __('Kanban Board') }}
                            </flux:navlist.item>
                        </div>
                    </div>

                    <!-- Shipments with Submenu -->
                    <div x-data="{ open: true }">
                        <flux:navlist.item
                            icon="layout-grid"
                            @click="open = !open"
                            :current="request()->routeIs('shipping-companies.*') || request()->routeIs('shipment-schedule.*') || request()->routeIs('ports.*')"
                            class="cursor-pointer">
                            <div class="flex items-center justify-between w-full">
                                <span>{{ __('Shipments') }}</span>
                                <svg x-show="open" class="h-4 w-4 transition-transform rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                                <svg x-show="!open" class="h-4 w-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>
                            </div>
                        </flux:navlist.item>

                        <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                            <flux:navlist.item
                                :href="route('shipping-companies.index')"
                                :current="request()->routeIs('shipping-companies.*')"
                                wire:navigate
                                class="text-sm">
                                {{ __('Shipping Companies') }}
                            </flux:navlist.item>
                            <flux:navlist.item
                                :href="route('ports.index')"
                                :current="request()->routeIs('ports.*')"
                                wire:navigate
                                class="text-sm">
                                {{ __('Ports') }}
                            </flux:navlist.item>
                            <flux:navlist.item
                                :href="route('shipment-schedule.index')"
                                :current="request()->routeIs('shipment-schedule.index')"
                                wire:navigate
                                class="text-sm">
                                {{ __('Shipment Schedule') }}
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

                @if(auth()->user()?->role === 'admin')
                    <flux:navlist.group :heading="__('System')" class="grid">
                        <flux:navlist.item icon="megaphone" :href="route('notices.index')" :current="request()->routeIs('notices.*')" wire:navigate>{{ __('Notices') }}</flux:navlist.item>
                    </flux:navlist.group>
                @endif
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

        <!-- Top Bar with Date, Time, Temperature, and Notices -->
        <livewire:top-bar />

        {{ $slot }}

        <!-- Toast Notifications -->
        <x-toast-notification />

        @fluxScripts
        <!-- Particle Background Script (enabled for all pages) -->
        <script>
            (function() {
                const canvas = document.getElementById('particle-canvas');
                if (!canvas) return;

                const ctx = canvas.getContext('2d');
                let particles = [];
                let animationId;

                // Set canvas size
                function resizeCanvas() {
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);

                // Color palette matching design system
                const colorPalettes = {
                    light: {
                        violet: '124, 58, 237',
                        blue: '59, 130, 246',
                        emerald: '16, 185, 129',
                        amber: '245, 158, 11',
                        purple: '168, 85, 247',
                        cyan: '6, 182, 212',
                        teal: '20, 184, 166',
                        orange: '249, 115, 22'
                    },
                    dark: {
                        violet: '139, 92, 246',
                        blue: '96, 165, 250',
                        emerald: '52, 211, 153',
                        amber: '251, 191, 36',
                        purple: '192, 132, 252',
                        cyan: '34, 211, 238',
                        teal: '45, 212, 191',
                        orange: '251, 146, 60'
                    }
                };

                // Particle class
                class Particle {
                    constructor() {
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 2 + 0.5;
                        this.speedX = (Math.random() - 0.5) * 0.5;
                        this.speedY = (Math.random() - 0.5) * 0.5;
                        this.opacity = Math.random() * 0.5 + 0.2;

                        // Randomly assign a color from the palette
                        const isDark = document.documentElement.classList.contains('dark');
                        const palette = isDark ? colorPalettes.dark : colorPalettes.light;
                        const colors = Object.values(palette);
                        this.color = colors[Math.floor(Math.random() * colors.length)];
                    }

                    update() {
                        this.x += this.speedX;
                        this.y += this.speedY;

                        if (this.x > canvas.width) this.x = 0;
                        if (this.x < 0) this.x = canvas.width;
                        if (this.y > canvas.height) this.y = 0;
                        if (this.y < 0) this.y = canvas.height;
                    }

                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                        ctx.fillStyle = `rgba(${this.color}, ${this.opacity})`;
                        ctx.fill();
                    }
                }

                // Create particles
                function initParticles() {
                    particles = [];
                    const particleCount = Math.floor((canvas.width * canvas.height) / 15000);
                    for (let i = 0; i < particleCount; i++) {
                        particles.push(new Particle());
                    }
                }

                // Draw connections
                function drawConnections() {
                    for (let i = 0; i < particles.length; i++) {
                        for (let j = i + 1; j < particles.length; j++) {
                            const dx = particles[i].x - particles[j].x;
                            const dy = particles[i].y - particles[j].y;
                            const distance = Math.sqrt(dx * dx + dy * dy);

                            if (distance < 120) {
                                ctx.beginPath();
                                // Use gradient between two particle colors - darker opacity
                                const gradient = ctx.createLinearGradient(
                                    particles[i].x, particles[i].y,
                                    particles[j].x, particles[j].y
                                );
                                gradient.addColorStop(0, `rgba(${particles[i].color}, ${0.3 * (1 - distance / 120)})`);
                                gradient.addColorStop(1, `rgba(${particles[j].color}, ${0.3 * (1 - distance / 120)})`);
                                ctx.strokeStyle = gradient;
                                ctx.lineWidth = 0.5;
                                ctx.moveTo(particles[i].x, particles[i].y);
                                ctx.lineTo(particles[j].x, particles[j].y);
                                ctx.stroke();
                            }
                        }
                    }
                }

                // Animation loop
                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    particles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });

                    drawConnections();

                    animationId = requestAnimationFrame(animate);
                }

                // Initialize and start
                initParticles();
                animate();

                // Cleanup on page unload
                window.addEventListener('beforeunload', () => {
                    if (animationId) {
                        cancelAnimationFrame(animationId);
                    }
                });
            })();
        </script>
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
