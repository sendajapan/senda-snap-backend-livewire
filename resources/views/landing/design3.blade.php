<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>{{ config('app.name') }} - Vehicle Management & Task Scheduling</title>
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <!-- Top Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 border-b border-gray-200/50 bg-white/80 backdrop-blur-sm dark:border-gray-800/50 dark:bg-gray-900/80">
            <div class="mx-auto max-w-7xl px-6 py-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('home') }}" class="flex items-center gap-2">
                            <img class="h-8" src="{{ asset('/assets/logo_white_bg_transparent.png') }}" alt="Senda Snap">
                            <span class="text-lg font-bold text-gray-900 dark:text-white">{{ config('app.name') }}</span>
                        </a>
                        <div class="hidden items-center gap-4 md:flex">
                            <a href="{{ route('admin.manual') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                                {{ __('Admin Manual') }}
                            </a>
                            <a href="{{ route('android.app.manual') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                                {{ __('Android Manual') }}
                            </a>
                            <a href="{{ route('api.docs') }}" class="text-sm font-medium text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors">
                                {{ __('API Docs') }}
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        @auth
                            <a href="{{ route('dashboard') }}" class="rounded-lg bg-violet-600 px-4 py-2 text-sm font-semibold text-white transition-all hover:bg-violet-700 hover:shadow-lg">
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="rounded-lg border border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-900 transition-all hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                {{ __('Log in') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Centered Showcase -->
        <div class="relative min-h-screen pt-24 pb-20">
            <!-- Particle Background -->
            <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>

            <div class="mx-auto max-w-7xl px-6">
                <!-- Hero Content -->
                <div class="mb-16 text-center">
                    <h1 class="mb-6 text-5xl font-bold text-gray-900 dark:text-white md:text-6xl lg:text-7xl">
                        {{ __('Senda Snap') }}
                    </h1>
                    <p class="mx-auto max-w-2xl text-xl text-gray-600 dark:text-gray-400">
                        {{ __('Complete vehicle management and task scheduling solution for web and mobile.') }}
                    </p>
                </div>

                <!-- Floating Devices -->
                <div class="relative mb-20 flex items-center justify-center">
                    <!-- Monitor Mockup (Rotated Left) -->
                    <div class="absolute left-1/4 top-0 z-10 hidden lg:block -translate-x-1/2 -rotate-12">
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

                    <!-- Mobile Mockup (Center, Rotated Right) -->
                    <div class="relative z-20 rotate-12">
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

                <!-- Features Grid -->
                <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <!-- Web Features -->
                    <div class="rounded-xl border border-violet-200 bg-violet-50/30 p-6 dark:border-violet-900/50 dark:bg-violet-900/20">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-violet-500">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Web Dashboard') }}</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ __('Full-featured web interface with advanced management tools') }}</p>
                    </div>

                    <!-- Android Features -->
                    <div class="rounded-xl border border-emerald-200 bg-emerald-50/30 p-6 dark:border-emerald-900/50 dark:bg-emerald-900/20">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-emerald-500">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Mobile App') }}</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ __('Android app for on-the-go vehicle and task management') }}</p>
                    </div>

                    <!-- Benefits -->
                    <div class="rounded-xl border border-blue-200 bg-blue-50/30 p-6 dark:border-blue-900/50 dark:bg-blue-900/20">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-blue-500">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Real-time Sync') }}</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ __('Instant synchronization between web and mobile platforms') }}</p>
                    </div>

                    <!-- Get Started -->
                    <div class="rounded-xl border border-amber-200 bg-amber-50/30 p-6 dark:border-amber-900/50 dark:bg-amber-900/20">
                        <div class="mb-4 flex h-12 w-12 items-center justify-center rounded-lg bg-amber-500">
                            <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                            </svg>
                        </div>
                        <h3 class="mb-2 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Get Started') }}</h3>
                        <p class="text-sm text-gray-700 dark:text-gray-300">{{ __('Start managing your fleet and tasks today') }}</p>
                    </div>
                </div>

                <!-- Design Switcher -->
                <div class="mt-16 flex justify-center gap-2">
                    <a href="{{ route('home') }}" class="rounded-lg px-3 py-1.5 text-xs font-medium {{ request()->routeIs('home') ? 'bg-violet-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                        Design 1
                    </a>
                    <a href="{{ route('landing.1') }}" class="rounded-lg px-3 py-1.5 text-xs font-medium {{ request()->routeIs('landing.1') ? 'bg-violet-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                        Design 2
                    </a>
                    <a href="{{ route('landing.2') }}" class="rounded-lg px-3 py-1.5 text-xs font-medium {{ request()->routeIs('landing.2') ? 'bg-violet-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                        Design 3
                    </a>
                    <a href="{{ route('landing.3') }}" class="rounded-lg px-3 py-1.5 text-xs font-medium {{ request()->routeIs('landing.3') ? 'bg-violet-600 text-white' : 'bg-gray-200 text-gray-700 dark:bg-gray-800 dark:text-gray-300' }}">
                        Design 4
                    </a>
                </div>
            </div>
        </div>

        <style>
            /* Monitor Mockup Styles */
            .monitor-mockup {
                display: inline-block;
                padding: 20px;
                background: linear-gradient(135deg, #2a2a2a 0%, #1a1a1a 100%);
                border-radius: 12px;
                box-shadow: 
                    0 20px 40px rgba(0, 0, 0, 0.3),
                    inset 0 0 20px rgba(0, 0, 0, 0.5);
            }

            .monitor-frame {
                width: 450px;
                max-width: 100%;
                background: #000;
                border-radius: 8px;
                padding: 12px;
                box-shadow: 
                    inset 0 0 0 2px rgba(255, 255, 255, 0.1),
                    inset 0 0 30px rgba(0, 0, 0, 0.8);
                position: relative;
            }

            .monitor-frame::before {
                content: '';
                position: absolute;
                bottom: -30px;
                left: 50%;
                transform: translateX(-50%);
                width: 200px;
                height: 20px;
                background: #1a1a1a;
                border-radius: 4px;
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.5);
            }

            .monitor-frame::after {
                content: '';
                position: absolute;
                bottom: -50px;
                left: 50%;
                transform: translateX(-50%);
                width: 300px;
                height: 8px;
                background: #0a0a0a;
                border-radius: 4px;
            }

            .monitor-screen {
                width: 100%;
                background: #000;
                border-radius: 4px;
                overflow: hidden;
                aspect-ratio: 16 / 10;
                position: relative;
            }

            .monitor-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }

            /* Phone Mockup */
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
                background: #000;
                border-radius: 32px;
                padding: 8px;
                box-shadow: 
                    inset 0 0 0 2px rgba(255, 255, 255, 0.1),
                    inset 0 0 20px rgba(0, 0, 0, 0.5);
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
                background: #1a1a1a;
                border-radius: 3px;
                z-index: 10;
            }

            .phone-screen {
                width: 100%;
                background: #000;
                border-radius: 24px;
                overflow: hidden;
                aspect-ratio: 9 / 19.5;
                position: relative;
            }

            .phone-image {
                width: 100%;
                height: 100%;
                object-fit: cover;
                display: block;
            }
        </style>

        @push('scripts')
            <script>
                // Particle Canvas Animation
                (function () {
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
                        const particleCount = Math.floor((canvas.width * canvas.height) / 15000);
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
                })();
            </script>
        @endpush
        @fluxScripts
    </body>
</html>

