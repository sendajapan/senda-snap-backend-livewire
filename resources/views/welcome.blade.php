<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>{{ config('app.name') }} - Vehicle Management & Task Scheduling</title>
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <!-- Top Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 border-b border-gray-200/50 bg-white/95 backdrop-blur-md dark:border-gray-800/50 dark:bg-gray-900/95 shadow-sm" x-data="{ mobileMenuOpen: false }">
            <div class="mx-auto max-w-7xl px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-8">
                        <a href="{{ route('home') }}" class="flex items-center group">
                            <div class="transition-transform group-hover:scale-105">
                                <x-app-logo />
                            </div>
                        </a>
                        <!-- Desktop Menu -->
                        <div class="hidden items-center gap-0 md:flex">
                            <a href="{{ route('admin.manual') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all">
                                {{ __('Admin Manual') }}
                            </a>
                            <span class="h-4 w-px bg-gray-300/50 dark:bg-gray-700/50"></span>
                            <a href="{{ route('android.app.manual') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all">
                                {{ __('Android Manual') }}
                            </a>
                            <span class="h-4 w-px bg-gray-300/50 dark:bg-gray-700/50"></span>
                            <a href="{{ route('api.docs') }}" class="rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all">
                                {{ __('API Docs') }}
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Mobile Menu Button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="rounded-lg p-2 text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 md:hidden" aria-label="Toggle menu">
                            <svg x-show="!mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <svg x-show="mobileMenuOpen" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="display: none;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                            </svg>
                        </button>
                        <!-- Desktop Auth Buttons -->
                        <div class="hidden md:flex items-center gap-3">
                            @auth
                                <a href="{{ route('dashboard') }}" class="rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 px-5 py-2.5 text-sm font-semibold text-white transition-all hover:from-violet-700 hover:to-purple-700 hover:shadow-lg hover:shadow-violet-500/50">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-lg border-2 border-gray-300 bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 transition-all hover:bg-gray-50 hover:border-gray-400 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600">
                                    {{ __('Log in') }}
                                </a>
                            @endauth
                        </div>
                    </div>
                </div>
                <!-- Mobile Menu -->
                <div x-show="mobileMenuOpen" 
                     x-transition:enter="transition ease-out duration-200"
                     x-transition:enter-start="opacity-0 -translate-y-2"
                     x-transition:enter-end="opacity-100 translate-y-0"
                     x-transition:leave="transition ease-in duration-150"
                     x-transition:leave-start="opacity-100 translate-y-0"
                     x-transition:leave-end="opacity-0 -translate-y-2"
                     class="mt-4 space-y-2 border-t border-gray-200/50 pt-4 dark:border-gray-700/50 md:hidden"
                     style="display: none;">
                    <a href="{{ route('admin.manual') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                        {{ __('Admin Manual') }}
                    </a>
                    <a href="{{ route('android.app.manual') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                        {{ __('Android Manual') }}
                    </a>
                    <a href="{{ route('api.docs') }}" class="block rounded-lg px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800">
                        {{ __('API Docs') }}
                    </a>
                    <div class="pt-2 border-t border-gray-200/50 dark:border-gray-700/50">
                        @auth
                            <a href="{{ route('dashboard') }}" class="block rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 px-4 py-2.5 text-sm font-semibold text-white text-center transition-all hover:from-violet-700 hover:to-purple-700">
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block rounded-lg border-2 border-gray-300 bg-white px-4 py-2.5 text-sm font-semibold text-gray-900 text-center transition-all hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                {{ __('Log in') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative min-h-screen pt-40 pb-20">
            <!-- Particle Background -->
            <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>

            <div class="mx-auto max-w-7xl px-6">
                <!-- Hero Content -->
                <div class="text-center mb-12">
                    <h1 class="mb-6 text-5xl font-bold text-gray-900 dark:text-white md:text-6xl lg:text-7xl">
                        {{ __('Manage Vehicles & Tasks') }}
                        <span class="block bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                            {{ __('Seamlessly') }}
                                </span>
                    </h1>
                    <p class="mx-auto max-w-2xl text-xl text-gray-600 dark:text-gray-400">
                        {{ __('Comprehensive web dashboard and Android app for vehicle management, task scheduling, and team collaboration.') }}
                    </p>
                </div>

                <!-- Features and Screenshots Side by Side -->
                <div class="grid gap-12 lg:grid-cols-2 lg:gap-16 items-center mb-20">
                    <!-- Features Section (Left) -->
                    <div class="space-y-6">
                        <!-- Web Features -->
                        <div class="rounded-2xl border border-violet-200 bg-gradient-to-br from-white via-violet-50/30 to-purple-50/30 p-6 shadow-xl dark:border-violet-900/50 dark:from-gray-900 dark:via-violet-900/20 dark:to-purple-900/20">
                            <div class="mb-4 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Web Dashboard') }}</h2>
                            </div>
                            <ul class="space-y-2.5 text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Comprehensive dashboard with real-time statistics and charts') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('User, task, and vehicle management with advanced filtering') }}</span>
                        </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Role-based access control and permissions') }}</span>
                        </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('File attachments and document management') }}</span>
                        </li>
                    </ul>
                </div>

                        <!-- Android Features -->
                        <div class="rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-6 shadow-xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20">
                            <div class="mb-4 flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                    <svg class="h-5 w-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-xl font-bold text-gray-900 dark:text-white">{{ __('Android App') }}</h2>
                            </div>
                            <ul class="space-y-2.5 text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Vehicle search and management on the go') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                                    <span>{{ __('Task and schedule management with notifications') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                                    <span>{{ __('Real-time team chat and communication') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-5 w-5 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                    </svg>
                                    <span>{{ __('Camera integration for vehicle documentation') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Screenshots Section (Right) -->
                    <div class="relative flex items-center justify-center">
                        <!-- Monitor Mockup -->
                        <div class="relative z-10 -mr-16 hidden lg:block">
                            <div class="monitor-mockup">
                                <div class="monitor-frame">
                                    <div class="monitor-screen">
                                        <img src="{{ asset('assets/manual/dashboard.png') }}"
                                             alt="{{ __('Dashboard') }}"
                                             class="monitor-image">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Mobile Mockup (Overlapping) -->
                        <div class="relative z-20">
                            <div class="phone-mockup">
                                <div class="phone-frame">
                                    <div class="phone-screen">
                                        <img src="{{ asset('assets/app-manual/task-list.jpg') }}"
                                             alt="{{ __('Task List') }}"
                                             class="phone-image">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <style>
            /* Microsoft Surface Monitor Mockup Styles */
            .monitor-mockup {
                display: inline-block;
                padding: 0;
                background: transparent;
                border-radius: 0;
            }

            .monitor-frame {
                width: 600px;
                max-width: 100%;
                background: #ffffff;
                border-radius: 12px;
                padding: 16px;
                box-shadow:
                    0 4px 20px rgba(0, 0, 0, 0.1),
                    0 0 0 1px rgba(0, 0, 0, 0.05),
                    inset 0 0 0 1px rgba(0, 0, 0, 0.05);
                position: relative;
            }

            .dark .monitor-frame {
                background: #f5f5f5;
                box-shadow:
                    0 4px 20px rgba(0, 0, 0, 0.3),
                    0 0 0 1px rgba(255, 255, 255, 0.1),
                    inset 0 0 0 1px rgba(255, 255, 255, 0.05);
            }

            .monitor-frame::before {
                content: '';
                position: absolute;
                bottom: -8px;
                left: 50%;
                transform: translateX(-50%);
                width: 120px;
                height: 8px;
                background: #ffffff;
                border-radius: 0 0 4px 4px;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            }

            .dark .monitor-frame::before {
                background: #f5f5f5;
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.3);
            }

            .monitor-frame::after {
                content: '';
                position: absolute;
                bottom: -20px;
                left: 50%;
                transform: translateX(-50%);
                width: 200px;
                height: 4px;
                background: #e0e0e0;
                border-radius: 2px;
            }

            .dark .monitor-frame::after {
                background: #d0d0d0;
            }

            .monitor-screen {
                width: 100%;
                background: #000;
                border-radius: 4px;
                overflow: hidden;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .monitor-image {
                width: 100%;
                height: auto;
                object-fit: contain;
                display: block;
            }

            /* Phone Mockup (reuse from android manual) */
            .phone-mockup {
                display: inline-block;
                padding: 12px;
                background: linear-gradient(135deg, #f5f5f5 0%, #e0e0e0 100%);
                border-radius: 40px;
                box-shadow:
                    0 10px 30px rgba(0, 0, 0, 0.2),
                    0 0 0 8px rgba(255, 255, 255, 0.1),
                    inset 0 0 20px rgba(0, 0, 0, 0.1);
            }

            .dark .phone-mockup {
                background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
                box-shadow:
                    0 10px 30px rgba(0, 0, 0, 0.5),
                    0 0 0 8px rgba(255, 255, 255, 0.05),
                    inset 0 0 20px rgba(0, 0, 0, 0.3);
            }

            .phone-frame {
                width: 280px;
                max-width: 100%;
                background: transparent;
                border-radius: 32px;
                padding: 0;
                box-shadow: none;
                position: relative;
            }

            .phone-frame::before {
                content: '';
                position: absolute;
                top: 12px;
                left: 50%;
                transform: translateX(-50%);
                width: 60px;
                height: 6px;
                background: rgba(255, 255, 255, 0.3);
                border-radius: 3px;
                z-index: 10;
            }

            .dark .phone-frame::before {
                background: rgba(255, 255, 255, 0.2);
            }

            .phone-screen {
                width: 100%;
                background: #000;
                border-radius: 32px;
                overflow: hidden;
                position: relative;
                display: flex;
                align-items: center;
                justify-content: center;
            }

            .phone-image {
                width: 100%;
                height: auto;
                object-fit: contain;
                display: block;
            }

            @media (max-width: 1024px) {
                .monitor-mockup {
                    display: none;
                }
                .phone-mockup {
                    margin: 0 auto;
                }
            }
        </style>

        <script>
            // Particle Canvas Animation
            document.addEventListener('DOMContentLoaded', function() {
                const canvas = document.getElementById('particle-canvas');
                if (!canvas) return;

                canvas.style.display = 'block';

                const ctx = canvas.getContext('2d');
                let particles = [];
                let animationId;

                function resizeCanvas() {
                    canvas.width = window.innerWidth;
                    canvas.height = window.innerHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);

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

                class Particle {
                    constructor() {
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 2 + 0.5;
                        this.speedX = (Math.random() - 0.5) * 0.5;
                        this.speedY = (Math.random() - 0.5) * 0.5;
                        this.opacity = Math.random() * 0.5 + 0.2;

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

                function initParticles() {
                    particles = [];
                    const particleCount = Math.floor((canvas.width * canvas.height) / 8000);
                    for (let i = 0; i < particleCount; i++) {
                        particles.push(new Particle());
                    }
                }

                function drawConnections() {
                    for (let i = 0; i < particles.length; i++) {
                        for (let j = i + 1; j < particles.length; j++) {
                            const dx = particles[i].x - particles[j].x;
                            const dy = particles[i].y - particles[j].y;
                            const distance = Math.sqrt(dx * dx + dy * dy);

                            if (distance < 120) {
                                ctx.beginPath();
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

                function animate() {
                    ctx.clearRect(0, 0, canvas.width, canvas.height);

                    particles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });

                    drawConnections();

                    animationId = requestAnimationFrame(animate);
                }

                initParticles();
                animate();

                window.addEventListener('beforeunload', () => {
                    if (animationId) {
                        cancelAnimationFrame(animationId);
                    }
                });
            });
        </script>
        @fluxScripts
    </body>
</html>
