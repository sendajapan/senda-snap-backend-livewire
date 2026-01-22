<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">

<head>
    @include('partials.head')
</head>
@php
    $showParticles = request()->routeIs(
        'home',
        'dashboard',
        'admin.manual',
        'android.app.manual',
        'api.docs',
    );
@endphp

<body class="min-h-screen bg-white dark:bg-zinc-800">
    @if ($showParticles)
        <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>
    @endif

    <!-- Mouse Spotlight Effect (Dark Mode Only) -->
    <div id="mouse-spotlight" class="fixed pointer-events-none" style="z-index: 9999;"></div>

    <flux:sidebar sticky stashable class="border-e border-zinc-200 bg-zinc-50 dark:border-zinc-700 dark:bg-zinc-900">
        <flux:sidebar.toggle class="lg:hidden" icon="x-mark" />

        <a href="{{ route('dashboard') }}" class="me-5 flex items-center space-x-2 rtl:space-x-reverse" wire:navigate>
            <x-app-logo />
        </a>

        <flux:navlist variant="outline">
            <flux:navlist.group :heading="__('Platform')" class="grid">
                <flux:navlist.item icon="home" :href="route('dashboard')" :current="request()->routeIs('dashboard')"
                    wire:navigate>{{ __('Dashboard') }}</flux:navlist.item>
            </flux:navlist.group>

            <flux:navlist.group :heading="__('Management')" class="grid">
                @if(auth()->user()?->role === 'admin')
                    <flux:navlist.item icon="building-office-2" :href="route('vendors.index')"
                        :current="request()->routeIs('vendors.*')" wire:navigate>{{ __('Vendors') }}</flux:navlist.item>
                @endif
                <flux:navlist.item icon="users" :href="route('users.index')" :current="request()->routeIs('users.*')"
                    wire:navigate>{{ __('Users') }}</flux:navlist.item>

                <!-- Tasks with Submenu -->
                <div x-data="{ open: true }">
                    <flux:navlist.item icon="clipboard" @click="open = !open" :current="request()->routeIs('tasks.*')"
                        class="cursor-pointer">
                        <div class="flex items-center justify-between w-full">
                            <span>{{ __('Tasks') }}</span>
                            <flux:icon.chevron-down x-show="open" class="h-4 w-4 transition-transform rotate-180" />
                            <flux:icon.chevron-down x-show="!open" class="h-4 w-4 transition-transform" />
                        </div>
                    </flux:navlist.item>

                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <flux:navlist.item :href="route('tasks.today')" :current="request()->routeIs('tasks.today')"
                            wire:navigate class="text-sm">
                            {{ __("Today's Tasks") }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('tasks.all')" :current="request()->routeIs('tasks.all')"
                            wire:navigate class="text-sm">
                            {{ __('All Tasks') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('tasks.kanban')" :current="request()->routeIs('tasks.kanban')"
                            wire:navigate class="text-sm">
                            {{ __('Kanban Board') }}
                        </flux:navlist.item>
                    </div>
                </div>

                <!-- Shipments with Submenu -->
                <div x-data="{ open: true }">
                    <flux:navlist.item icon="paper-airplane" @click="open = !open"
                        :current="request()->routeIs('shipping-companies.*') || request()->routeIs('shipment-schedule.*') || request()->routeIs('ports.*')"
                        class="cursor-pointer">
                        <div class="flex items-center justify-between w-full">
                            <span>{{ __('Shipments') }}</span>
                            <flux:icon.chevron-down x-show="open" class="h-4 w-4 transition-transform rotate-180" />
                            <flux:icon.chevron-down x-show="!open" class="h-4 w-4 transition-transform" />
                        </div>
                    </flux:navlist.item>

                    <div x-show="open" x-collapse class="ml-8 mt-1 space-y-1">
                        <flux:navlist.item :href="route('shipping-companies.index')"
                            :current="request()->routeIs('shipping-companies.*')" wire:navigate class="text-sm">
                            {{ __('Shipping Companies') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('ports.index')" :current="request()->routeIs('ports.*')"
                            wire:navigate class="text-sm">
                            {{ __('Ports') }}
                        </flux:navlist.item>
                        <flux:navlist.item :href="route('shipment-schedule.index')"
                            :current="request()->routeIs('shipment-schedule.index')" wire:navigate class="text-sm">
                            {{ __('Shipment Schedule') }}
                        </flux:navlist.item>
                    </div>
                </div>

                <flux:navlist.item icon="magnifying-glass" :href="route('vehicle-searches.index')"
                    :current="request()->routeIs('vehicle-searches.*')" wire:navigate>
                    {{ __('Vehicle Searches') }}
                </flux:navlist.item>
            </flux:navlist.group>

            @if(auth()->user()?->role === 'admin')
                <flux:navlist.group :heading="__('System')" class="grid">
                    <flux:navlist.item icon="megaphone" :href="route('notices.index')"
                        :current="request()->routeIs('notices.*')" wire:navigate>{{ __('Notices') }}</flux:navlist.item>
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
            <flux:profile :name="auth()->user()->name" :initials="auth()->user()->initials()"
                icon:trailing="chevrons-up-down" />

            <flux:menu class="w-[220px]">
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
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
            <flux:profile :initials="auth()->user()->initials()" icon-trailing="chevron-down" />

            <flux:menu>
                <flux:menu.radio.group>
                    <div class="p-0 text-sm font-normal">
                        <div class="flex items-center gap-2 px-1 py-1.5 text-start text-sm">
                            <span class="relative flex h-8 w-8 shrink-0 overflow-hidden rounded-lg">
                                <span
                                    class="flex h-full w-full items-center justify-center rounded-lg bg-neutral-200 text-black dark:bg-neutral-700 dark:text-white">
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
                    <flux:menu.item :href="route('profile.edit')" icon="cog" wire:navigate>{{ __('Settings') }}
                    </flux:menu.item>
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

    <!-- Prevent table and card flashing in dark mode -->
    <script>
        (function () {
            // Add class to body once page is loaded to allow transitions
            function addPageLoadedClass() {
                setTimeout(function () {
                    document.body.classList.add('page-loaded');
                }, 100);
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', addPageLoadedClass);
            } else {
                addPageLoadedClass();
            }

            // Handle Livewire navigation - disable transitions during navigation
            document.addEventListener('livewire:navigating', function () {
                document.body.classList.remove('page-loaded');
            });

            // Re-enable transitions after Livewire navigation completes
            document.addEventListener('livewire:navigated', function () {
                setTimeout(function () {
                    document.body.classList.add('page-loaded');
                }, 150);
            });
        })();
    </script>

    @if ($showParticles)
        <script>
            (function () {
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
    @endif
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        // Custom delete confirmation with SweetAlert2
        window.confirmDelete = function (itemId, itemTitle = null, warnings = null) {
            // Ensure warnings is an array
            if (warnings && !Array.isArray(warnings)) {
                warnings = null;
            }

            let htmlContent = '';

            if (itemTitle) {
                htmlContent += `<p class="mb-2 font-semibold text-gray-900 dark:text-white">${itemTitle}</p>`;
            }

            // Add warnings about child records if provided
            if (warnings && Array.isArray(warnings) && warnings.length > 0) {
                htmlContent += `<div class="mb-3 rounded-lg border-2 border-amber-300 bg-amber-50/50 p-3 dark:border-amber-700 dark:bg-amber-900/20">`;
                htmlContent += `<p class="mb-2 text-sm font-semibold text-amber-900 dark:text-amber-200">{{ __('Warning: This will also delete the following:') }}</p>`;
                htmlContent += `<ul class="list-disc list-inside space-y-1 text-xs text-amber-800 dark:text-amber-300">`;
                warnings.forEach(warning => {
                    htmlContent += `<li>${warning}</li>`;
                });
                htmlContent += `</ul>`;
                htmlContent += `</div>`;
            }

            // Always show the warning message
            if (!htmlContent) {
                htmlContent = `<p class="text-sm text-gray-600 dark:text-gray-400">{{ __('Are you sure you want to delete this item? This action cannot be undone!') }}</p>`;
            } else {
                htmlContent += `<p class="text-sm text-gray-600 dark:text-gray-400 mt-3">{{ __('This action cannot be undone!') }}</p>`;
            }

            return Swal.fire({
                title: '{{ __('Are you sure?') }}',
                html: htmlContent,
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
    <!-- Mouse Spotlight Script (Dark Mode Only) -->
    <script>
        (function () {
            const spotlight = document.getElementById('mouse-spotlight');
            if (!spotlight) return;

            let mouseX = 0;
            let mouseY = 0;
            let isDarkMode = false;
            let currentColor = null;

            // Color mappings for spotlight gradients (matching design system)
            const colorMappings = {
                'blue': {
                    primary: '96, 165, 250',    // blue-400
                    secondary: '34, 211, 238',  // cyan-400
                    opacity: 0.15
                },
                'emerald': {
                    primary: '52, 211, 153',    // emerald-400
                    secondary: '45, 212, 191',  // teal-400
                    opacity: 0.15
                },
                'amber': {
                    primary: '251, 191, 36',    // amber-400
                    secondary: '251, 146, 60',  // orange-400
                    opacity: 0.15
                },
                'violet': {
                    primary: '167, 139, 250',   // violet-400
                    secondary: '192, 132, 252', // purple-400
                    opacity: 0.15
                },
                'indigo': {
                    primary: '129, 140, 248',   // indigo-400
                    secondary: '167, 139, 250', // violet-400
                    opacity: 0.15
                },
                'red': {
                    primary: '248, 113, 113',   // red-400
                    secondary: '251, 113, 133', // rose-400
                    opacity: 0.15
                },
                'cyan': {
                    primary: '34, 211, 238',    // cyan-400
                    secondary: '96, 165, 250',  // blue-400
                    opacity: 0.15
                },
                'teal': {
                    primary: '45, 212, 191',    // teal-400
                    secondary: '52, 211, 153',  // emerald-400
                    opacity: 0.15
                },
                'purple': {
                    primary: '192, 132, 252',   // purple-400
                    secondary: '167, 139, 250', // violet-400
                    opacity: 0.15
                },
                'orange': {
                    primary: '251, 146, 60',    // orange-400
                    secondary: '251, 191, 36',  // amber-400
                    opacity: 0.15
                },
                'rose': {
                    primary: '251, 113, 133',   // rose-400
                    secondary: '248, 113, 113', // red-400
                    opacity: 0.15
                },
                'default': {
                    primary: '255, 255, 255',   // white
                    secondary: '255, 255, 255', // white
                    opacity: 0.1
                }
            };

            // Detect color from element classes
            function detectColor(element) {
                if (!element) return null;

                // Check element and its parents for color classes
                let current = element;
                let depth = 0;
                const maxDepth = 5; // Limit search depth

                while (current && depth < maxDepth) {
                    const classes = current.className || '';

                    // Check for border color classes (most common indicator)
                    const colorMatch = classes.match(/border-(blue|emerald|amber|violet|indigo|red|cyan|teal|purple|orange|rose)-\d+/);
                    if (colorMatch) {
                        return colorMatch[1];
                    }

                    // Check for background color classes
                    const bgMatch = classes.match(/bg-(blue|emerald|amber|violet|indigo|red|cyan|teal|purple|orange|rose)-\d+/);
                    if (bgMatch) {
                        return bgMatch[1];
                    }

                    // Check for text color classes
                    const textMatch = classes.match(/text-(blue|emerald|amber|violet|indigo|red|cyan|teal|purple|orange|rose)-\d+/);
                    if (textMatch) {
                        return textMatch[1];
                    }

                    // Check for shadow color classes
                    const shadowMatch = classes.match(/shadow-(blue|emerald|amber|violet|indigo|red|cyan|teal|purple|orange|rose)-\d+/);
                    if (shadowMatch) {
                        return shadowMatch[1];
                    }

                    current = current.parentElement;
                    depth++;
                }

                return null;
            }

            // Update spotlight color
            function updateSpotlightColor(color) {
                if (currentColor === color) return;
                currentColor = color;

                const colorConfig = colorMappings[color] || colorMappings['default'];
                const gradient = `radial-gradient(circle, rgba(${colorConfig.primary}, ${colorConfig.opacity}) 0%, rgba(${colorConfig.secondary}, ${colorConfig.opacity * 0.6}) 30%, transparent 70%)`;
                spotlight.style.background = gradient;
            }

            // Check if dark mode is active
            function checkDarkMode() {
                isDarkMode = document.documentElement.classList.contains('dark');
                if (!isDarkMode) {
                    spotlight.style.opacity = '0';
                } else {
                    spotlight.style.opacity = '1';
                }
            }

            // Update spotlight position and color
            function updateSpotlight(e) {
                if (!isDarkMode) return;

                mouseX = e.clientX;
                mouseY = e.clientY;

                spotlight.style.left = mouseX + 'px';
                spotlight.style.top = mouseY + 'px';

                // Detect color from element under cursor
                const elementUnderCursor = document.elementFromPoint(mouseX, mouseY);
                const detectedColor = detectColor(elementUnderCursor);
                updateSpotlightColor(detectedColor);
            }

            // Hide spotlight when mouse leaves window
            function hideSpotlight() {
                if (spotlight) {
                    spotlight.style.opacity = '0';
                    currentColor = null;
                }
            }

            // Show spotlight when mouse enters window
            function showSpotlight() {
                if (spotlight && isDarkMode) {
                    spotlight.style.opacity = '1';
                }
            }

            // Initialize with default color
            updateSpotlightColor(null);

            // Initialize
            checkDarkMode();

            // Listen for mouse movement
            document.addEventListener('mousemove', updateSpotlight);
            document.addEventListener('mouseenter', showSpotlight);
            document.addEventListener('mouseleave', hideSpotlight);

            // Watch for dark mode changes
            const observer = new MutationObserver(checkDarkMode);
            observer.observe(document.documentElement, {
                attributes: true,
                attributeFilter: ['class']
            });
        })();
    </script>
    @stack('scripts')
</body>

</html>