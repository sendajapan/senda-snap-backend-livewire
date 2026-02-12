<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>{{ config('app.name') }} - Vehicle Management & Task Scheduling</title>
    </head>
    <body class="landing-page min-h-screen bg-white antialiased dark:bg-zinc-800 pb-[env(safe-area-inset-bottom)]">
        <!-- Mouse Spotlight Effect (Dark Mode Only) -->
        <div id="mouse-spotlight" class="fixed pointer-events-none" style="z-index: 9999;"></div>

        <!-- Vintage Dark Corners Overlay (Dark Mode Only) -->
        <div id="vintage-corners" class="fixed inset-0 pointer-events-none z-10 opacity-0 dark:opacity-100 transition-opacity duration-300"></div>

        <!-- Top Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 border-b border-gray-200/50 bg-white/95 backdrop-blur-md dark:border-zinc-700/50 dark:bg-zinc-900/95 shadow-sm" x-data="{ mobileMenuOpen: false }">
            <div class="mx-auto w-full max-w-7xl px-4 py-2.5 sm:px-6 sm:py-3 md:px-8 lg:px-10 pl-[max(1rem,env(safe-area-inset-left))] pr-[max(1rem,env(safe-area-inset-right))]">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-6">
                        <a href="{{ route('home') }}" class="flex items-center group">
                            <div class="transition-transform group-hover:scale-105">
                                <x-app-logo />
                            </div>
                        </a>
                        <!-- Desktop Menu -->
                        <div class="hidden items-center gap-1 md:flex">
                            <a href="{{ route('admin.manual') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all min-h-[2.5rem] inline-flex items-center">
                                {{ __('Admin Manual') }}
                            </a>
                            <span class="h-4 w-px bg-gray-300/50 dark:bg-gray-700/50" aria-hidden="true"></span>
                            <a href="{{ route('android.app.manual') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all min-h-[2.5rem] inline-flex items-center">
                                {{ __('Android Manual') }}
                            </a>
                            <span class="h-4 w-px bg-gray-300/50 dark:bg-gray-700/50" aria-hidden="true"></span>
                            <a href="{{ route('api.docs') }}" class="rounded-lg px-3 py-2 text-sm font-medium text-gray-700 hover:text-gray-900 hover:bg-gray-100 dark:text-gray-300 dark:hover:text-white dark:hover:bg-gray-800 transition-all min-h-[2.5rem] inline-flex items-center">
                                {{ __('API Docs') }}
                            </a>
                        </div>
                    </div>
                    <div class="flex items-center gap-3">
                        <!-- Mobile Menu Button -->
                        <button @click="mobileMenuOpen = !mobileMenuOpen" class="rounded-lg p-2 min-h-[2.5rem] min-w-[2.5rem] flex items-center justify-center text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-800 md:hidden" aria-label="Toggle menu" aria-expanded="false">
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
                                <a href="{{ route('dashboard') }}" class="rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 px-4 py-2 text-sm font-semibold text-white transition-all hover:from-violet-700 hover:to-purple-700 hover:shadow-lg hover:shadow-violet-500/50">
                                    {{ __('Dashboard') }}
                                </a>
                            @else
                                <a href="{{ route('login') }}" class="rounded-lg border-1 border-gray-500 bg-white px-4 py-2 text-sm font-semibold text-gray-900 transition-all hover:bg-gray-50 hover:border-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600">
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
                     class="mt-3 space-y-0.5 border-t border-gray-200/50 pt-3 pb-1.5 dark:border-gray-700/50 md:hidden"
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
                            <a href="{{ route('dashboard') }}" class="block rounded-lg bg-gradient-to-r from-violet-600 to-purple-600 px-4 py-2 text-sm font-semibold text-white text-center transition-all hover:from-violet-700 hover:to-purple-700">
                                {{ __('Dashboard') }}
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block rounded-lg border-2 border-gray-300 bg-white px-4 py-2 text-sm font-semibold text-gray-900 text-center transition-all hover:bg-gray-50 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700">
                                {{ __('Log in') }}
                            </a>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative min-h-screen w-full landing-hero pt-[4.5rem] sm:pt-20 pb-8 sm:pb-10 md:pb-12 lg:pb-16 overflow-hidden">
            <!-- Particle Background -->
            <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>
            <!-- Dark smoke particles canvas -->
            <canvas id="smoke-canvas" class="fixed inset-0 -z-5 pointer-events-none"></canvas>

            <div class="mx-auto w-full max-w-7xl h-full px-4 sm:px-6 md:px-8 lg:px-10 relative z-20 pl-[max(1rem,env(safe-area-inset-left))] pr-[max(1rem,env(safe-area-inset-right))]">
                <!-- Hero Content -->
                <div class="text-center landing-hero-content mt-6 sm:mt-8 md:mt-10 lg:mt-12 mb-6 sm:mb-8 md:mb-10">
                    <h1 class="mb-3 sm:mb-4 landing-title text-2xl sm:text-3xl md:text-4xl lg:text-5xl font-bold text-gray-900 dark:text-white leading-tight tracking-tight">
                        {{ __('Manage Vehicles, Shipments & Tasks') }}
                        <span class="block mt-0.5 sm:mt-1 bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                            {{ __('Seamlessly') }}
                        </span>
                    </h1>
                    <p class="mx-auto max-w-2xl landing-subtitle text-sm sm:text-base md:text-lg text-gray-600 dark:text-gray-400 leading-relaxed px-2 sm:px-0">
                        {{ __('Comprehensive web dashboard and Android app for vehicle management, task scheduling, and team collaboration.') }}
                    </p>
                </div>

                <!-- Features and Screenshots Side by Side -->
                <div class="relative grid gap-6 sm:gap-8 lg:gap-10 landing-grid lg:grid-cols-2 items-start lg:items-center justify-items-center">
                    <!-- Features Section (Left) -->
                    <div class="relative z-20 max-w-xl lg:max-w-lg landing-features space-y-4 sm:space-y-5 w-full flex flex-col">
                        <!-- Web Features -->
                        <div class="rounded-2xl border border-violet-200 bg-gradient-to-br from-white via-violet-50/30 to-purple-50/30 p-4 sm:p-5 shadow-xl dark:border-violet-900/50 dark:from-gray-900 dark:via-violet-900/20 dark:to-purple-900/20 landing-feature-card">
                            <div class="mb-3 flex items-center gap-2.5">
                                <div class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">{{ __('Web Dashboard') }}</h2>
                            </div>
                            <ul class="space-y-2 text-xs sm:text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('Comprehensive dashboard with real-time statistics and charts') }}</span>
                                </li>
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('User, task, and vehicle management with advanced filtering') }}</span>
                                </li>
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('Role-based access control and permissions') }}</span>
                                </li>
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('File attachments and document management') }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Android Features -->
                        <div class="rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-4 sm:p-5 shadow-xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20 landing-feature-card">
                            <div class="mb-3 flex items-center gap-2.5">
                                <div class="flex h-7 w-7 sm:h-8 sm:w-8 items-center justify-center rounded-lg bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white">{{ __('Android App') }}</h2>
                            </div>
                            <ul class="space-y-2 text-xs sm:text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('Vehicle search and management on the go') }}</span>
                                </li>
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('Task and schedule management with notifications') }}</span>
                                </li>
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('Real-time team chat and communication') }}</span>
                                </li>
                                <li class="flex items-start gap-1">
                                    <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span class="leading-relaxed">{{ __('Camera integration for vehicle documentation') }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Play Store Download Section -->
                        <a href="https://play.google.com/store/apps/details?id=com.sendajapan.sendasnap"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group block rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-4 sm:p-5 shadow-xl transition-all hover:scale-[1.02] hover:shadow-2xl hover:shadow-emerald-500/20 dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20 dark:hover:shadow-emerald-500/10 landing-feature-card">
                            <div class="flex flex-col items-center text-center">
                                <!-- App Icon -->
                                <div class="mb-4 sm:mb-5 flex h-20 w-20 sm:h-24 sm:w-24 lg:h-28 lg:w-28 items-center justify-center transition-transform group-hover:scale-110 relative">
                                    <!-- Faded white smoke background -->
                                    <div class="absolute inset-0 rounded-3xl bg-gradient-to-br from-white/40 via-white/30 to-white/20 dark:from-white/50 dark:via-white/40 dark:to-white/30 backdrop-blur-sm shadow-lg"></div>
                                    <img src="https://play-lh.googleusercontent.com/WXLRHhKAqge_MSE5lTZewLN53eVVwQGwS-3mT6eb0rzAeVz2Pp5mrw_3sDk1dxUPZkOopFGW1qEfTz5e5WRT=w480-h960-rw"
                                         alt="{{ __('Senda Snap App Icon') }}"
                                         class="relative h-full w-full rounded-3xl object-cover app-icon-fade dark:brightness-125 dark:contrast-110 z-10">
                                </div>

                                <!-- App Information -->
                                <h3 class="mb-1.5 sm:mb-2 text-lg sm:text-xl font-bold text-gray-900 dark:text-white">{{ __('Senda Snap') }}</h3>
                                <p class="mb-3 sm:mb-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400 px-2 max-w-sm mx-auto">
                                    {{ __('Your Complete Vehicle Image Management & Team Collaboration Solution') }}
                                </p>

                                <!-- App Details -->
                                <div class="mb-4 sm:mb-5 flex flex-wrap items-center justify-center gap-3 sm:gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z" />
                                        </svg>
                                        <span>{{ __('10+ Downloads') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4 sm:h-5 sm:w-5" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.46,13.97L5.82,21L12,17.27Z" />
                                        </svg>
                                        <span>{{ __('Everyone') }}</span>
                                    </div>
                                </div>

                                <!-- Official Google Play Store Badge -->
                                <div class="flex items-center justify-center">
                                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png"
                                         alt="{{ __('Get it on Google Play') }}"
                                         class="h-9 sm:h-10 lg:h-12 transition-transform group-hover:scale-105"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="hidden items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 px-3 sm:px-5 py-1.5 sm:py-2 text-xs sm:text-sm font-semibold text-white shadow-md transition-all group-hover:from-emerald-700 group-hover:to-teal-700 group-hover:shadow-lg">
                                        <svg class="h-5 w-5 sm:h-6 sm:w-6" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.19,15.53L15.12,13.46L17.47,12L15.12,10.54L17.19,8.47L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z" />
                                        </svg>
                                        <span>{{ __('Get it on Google Play') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Screenshots Section (Right) -->
                    <div class="relative flex items-center justify-center w-full z-30 mt-4 lg:mt-0">
                        <!-- Monitor Mockup -->
                        <div class="relative z-30 -mr-8 xl:-mr-12 hidden lg:block">
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
                        <div class="relative z-40">
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
                width: min(420px, 85vw);
                max-width: 100%;
                background: #ffffff;
                border-radius: 10px;
                padding: 10px;
                box-shadow:
                    0 4px 20px rgba(0, 0, 0, 0.1),
                    0 0 0 1px rgba(0, 0, 0, 0.05),
                    inset 0 0 0 1px rgba(0, 0, 0, 0.05);
                position: relative;
            }

            /* FHD: Compact sizing */
            @media (min-width: 1920px) and (max-width: 2559px) {
                .monitor-frame {
                    width: 450px;
                    padding: 10px;
                }
            }

            /* 2K and 4K: Larger sizing */
            @media (min-width: 2560px) {
                .monitor-frame {
                    width: 600px;
                    padding: 16px;
                }
            }

            @media (min-width: 3840px) {
                .monitor-frame {
                    width: 700px;
                    padding: 18px;
                }
            }

            .dark .monitor-frame {
                background: rgba(245, 245, 245, 0.95);
                backdrop-filter: blur(10px);
                box-shadow:
                    0 4px 20px rgba(0, 0, 0, 0.3),
                    0 0 0 1px rgba(255, 255, 255, 0.2),
                    inset 0 0 0 1px rgba(255, 255, 255, 0.1);
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
                padding: 10px;
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
                width: min(200px, 50vw);
                max-width: 100%;
                background: transparent;
                border-radius: 32px;
                padding: 0;
                box-shadow: none;
                position: relative;
            }

            /* FHD: Compact sizing */
            @media (min-width: 1920px) and (max-width: 2559px) {
                .phone-frame {
                    width: 190px;
                }
            }

            /* 2K and 4K: Larger sizing */
            @media (min-width: 2560px) {
                .phone-frame {
                    width: 280px;
                }
            }

            @media (min-width: 3840px) {
                .phone-frame {
                    width: 320px;
                }
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

            /* App Icon Fade Effect */
            .app-icon-fade {
                mask-image: radial-gradient(ellipse 85% 85% at center, black 70%, transparent 100%);
                -webkit-mask-image: radial-gradient(ellipse 85% 85% at center, black 70%, transparent 100%);
            }

            @media (max-width: 1024px) {
                .monitor-mockup {
                    display: none;
                }
                .phone-mockup {
                    margin: 0 auto;
                }
                .phone-frame {
                    width: min(200px, 50vw);
                }
            }

            @media (max-width: 768px) {
                .phone-frame {
                    width: min(180px, 48vw);
                }
            }

            @media (max-width: 640px) {
                .phone-frame {
                    width: min(160px, 45vw);
                }
            }

            /* Custom breakpoints for 2K and 4K */
            @media (min-width: 2560px) {
                .phone-mockup {
                    padding: 16px;
                }
            }

            @media (min-width: 3840px) {
                .phone-mockup {
                    padding: 20px;
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

                // Mouse position tracking
                let mouseX = canvas.width / 2;
                let mouseY = canvas.height / 2;
                let isMouseMoving = false;

                document.addEventListener('mousemove', (e) => {
                    mouseX = e.clientX;
                    mouseY = e.clientY;
                    isMouseMoving = true;
                    setTimeout(() => { isMouseMoving = false; }, 2000);
                });

                class Particle {
                    constructor() {
                        this.x = Math.random() * canvas.width;
                        this.y = Math.random() * canvas.height;
                        this.size = Math.random() * 2 + 0.5;
                        this.speedX = (Math.random() - 0.5) * 1.0;
                        this.speedY = (Math.random() - 0.5) * 1.0;
                        this.opacity = Math.random() * 0.5 + 0.2;
                        this.baseX = this.x;
                        this.baseY = this.y;

                        const isDark = document.documentElement.classList.contains('dark');
                        const palette = isDark ? colorPalettes.dark : colorPalettes.light;
                        const colors = Object.values(palette);
                        this.color = colors[Math.floor(Math.random() * colors.length)];
                    }

                    update() {
                        // Mouse interaction - particles move away from mouse
                        const dx = this.x - mouseX;
                        const dy = this.y - mouseY;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        const maxDistance = 150;
                        const repulsionStrength = 0.3;

                        if (distance < maxDistance && isMouseMoving) {
                            const force = (maxDistance - distance) / maxDistance;
                            const angle = Math.atan2(dy, dx);
                            this.speedX += Math.cos(angle) * force * repulsionStrength;
                            this.speedY += Math.sin(angle) * force * repulsionStrength;
                        }

                        // Continuous automatic movement - apply speed with minimal damping
                        this.x += this.speedX;
                        this.y += this.speedY;
                        this.speedX *= 0.99;
                        this.speedY *= 0.99;

                        // If speed gets too low, add some random movement
                        if (Math.abs(this.speedX) < 0.1 && Math.abs(this.speedY) < 0.1) {
                            this.speedX += (Math.random() - 0.5) * 0.2;
                            this.speedY += (Math.random() - 0.5) * 0.2;
                        }

                        // Wrap around edges
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

                            if (distance < 150) {
                                ctx.beginPath();
                                const gradient = ctx.createLinearGradient(
                                    particles[i].x, particles[i].y,
                                    particles[j].x, particles[j].y
                                );
                                const opacity = 0.4 * (1 - distance / 150);
                                gradient.addColorStop(0, `rgba(${particles[i].color}, ${opacity})`);
                                gradient.addColorStop(1, `rgba(${particles[j].color}, ${opacity})`);
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

                    // Draw connections first so particles appear on top
                    drawConnections();

                    particles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });

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

            // Dark Smoke Particles Animation (React to Mouse)
            document.addEventListener('DOMContentLoaded', function() {
                const smokeCanvas = document.getElementById('smoke-canvas');
                if (!smokeCanvas) return;

                const ctx = smokeCanvas.getContext('2d');
                let smokeParticles = [];
                let animationId;
                let mouseX = window.innerWidth / 2;
                let mouseY = window.innerHeight / 2;

                function resizeCanvas() {
                    smokeCanvas.width = window.innerWidth;
                    smokeCanvas.height = window.innerHeight;
                }
                resizeCanvas();
                window.addEventListener('resize', resizeCanvas);

                // Track mouse position
                document.addEventListener('mousemove', (e) => {
                    mouseX = e.clientX;
                    mouseY = e.clientY;
                });

                class SmokeParticle {
                    constructor() {
                        this.x = Math.random() * smokeCanvas.width;
                        this.y = Math.random() * smokeCanvas.height;
                        this.size = Math.random() * 80 + 40;
                        this.speedX = (Math.random() - 0.5) * 0.3;
                        this.speedY = (Math.random() - 0.5) * 0.3;
                        this.opacity = Math.random() * 0.08 + 0.02;
                        this.baseX = this.x;
                        this.baseY = this.y;
                    }

                    update() {
                        // Mouse interaction - smoke moves away from mouse
                        const dx = this.x - mouseX;
                        const dy = this.y - mouseY;
                        const distance = Math.sqrt(dx * dx + dy * dy);
                        const maxDistance = 200;
                        const repulsionStrength = 0.5;

                        if (distance < maxDistance) {
                            const force = (maxDistance - distance) / maxDistance;
                            const angle = Math.atan2(dy, dx);
                            this.speedX += Math.cos(angle) * force * repulsionStrength;
                            this.speedY += Math.sin(angle) * force * repulsionStrength;
                        }

                        // Apply speed with damping
                        this.x += this.speedX;
                        this.y += this.speedY;
                        this.speedX *= 0.95;
                        this.speedY *= 0.95;

                        // Wrap around edges
                        if (this.x > smokeCanvas.width + this.size) this.x = -this.size;
                        if (this.x < -this.size) this.x = smokeCanvas.width + this.size;
                        if (this.y > smokeCanvas.height + this.size) this.y = -this.size;
                        if (this.y < -this.size) this.y = smokeCanvas.height + this.size;
                    }

                    draw() {
                        ctx.beginPath();
                        ctx.arc(this.x, this.y, this.size, 0, Math.PI * 2);
                        const gradient = ctx.createRadialGradient(
                            this.x, this.y, 0,
                            this.x, this.y, this.size
                        );
                        gradient.addColorStop(0, `rgba(0, 0, 0, ${this.opacity * 0.5})`);
                        gradient.addColorStop(0.5, `rgba(0, 0, 0, ${this.opacity * 0.25})`);
                        gradient.addColorStop(1, `rgba(0, 0, 0, 0)`);
                        ctx.fillStyle = gradient;
                        ctx.fill();
                    }
                }

                function initSmokeParticles() {
                    smokeParticles = [];
                    const particleCount = Math.floor((smokeCanvas.width * smokeCanvas.height) / 20000);
                    for (let i = 0; i < particleCount; i++) {
                        smokeParticles.push(new SmokeParticle());
                    }
                }

                function animate() {
                    ctx.clearRect(0, 0, smokeCanvas.width, smokeCanvas.height);

                    smokeParticles.forEach(particle => {
                        particle.update();
                        particle.draw();
                    });

                    animationId = requestAnimationFrame(animate);
                }

                // Only show smoke in dark mode
                function checkDarkMode() {
                    const isDark = document.documentElement.classList.contains('dark');
                    smokeCanvas.style.opacity = isDark ? '1' : '0';
                }

                checkDarkMode();
                const observer = new MutationObserver(checkDarkMode);
                observer.observe(document.documentElement, {
                    attributes: true,
                    attributeFilter: ['class']
                });

                initSmokeParticles();
                animate();

                window.addEventListener('beforeunload', () => {
                    if (animationId) {
                        cancelAnimationFrame(animationId);
                    }
                });
            });

            // Mouse Spotlight Script (Dark Mode Only) for Landing Page
            (function() {
                const spotlight = document.getElementById('mouse-spotlight');
                if (!spotlight) return;

                let mouseX = 0;
                let mouseY = 0;
                let isDarkMode = false;
                let currentColor = null;

                // Color mappings for spotlight gradients (matching design system)
                const colorMappings = {
                    'blue': {
                        primary: '96, 165, 250',
                        secondary: '34, 211, 238',
                        opacity: 0.2
                    },
                    'emerald': {
                        primary: '52, 211, 153',
                        secondary: '45, 212, 191',
                        opacity: 0.2
                    },
                    'amber': {
                        primary: '251, 191, 36',
                        secondary: '251, 146, 60',
                        opacity: 0.2
                    },
                    'violet': {
                        primary: '167, 139, 250',
                        secondary: '192, 132, 252',
                        opacity: 0.2
                    },
                    'indigo': {
                        primary: '129, 140, 248',
                        secondary: '167, 139, 250',
                        opacity: 0.2
                    },
                    'red': {
                        primary: '248, 113, 113',
                        secondary: '251, 113, 133',
                        opacity: 0.2
                    },
                    'cyan': {
                        primary: '34, 211, 238',
                        secondary: '96, 165, 250',
                        opacity: 0.2
                    },
                    'teal': {
                        primary: '45, 212, 191',
                        secondary: '52, 211, 153',
                        opacity: 0.2
                    },
                    'purple': {
                        primary: '192, 132, 252',
                        secondary: '167, 139, 250',
                        opacity: 0.2
                    },
                    'orange': {
                        primary: '251, 146, 60',
                        secondary: '251, 191, 36',
                        opacity: 0.2
                    },
                    'rose': {
                        primary: '251, 113, 133',
                        secondary: '248, 113, 113',
                        opacity: 0.2
                    },
                    'default': {
                        primary: '255, 255, 255',
                        secondary: '255, 255, 255',
                        opacity: 0.15
                    }
                };

                // Detect color from element classes
                function detectColor(element) {
                    if (!element) return null;

                    let current = element;
                    let depth = 0;
                    const maxDepth = 5;

                    while (current && depth < maxDepth) {
                        const classes = current.className || '';

                        const colorMatch = classes.match(/border-(blue|emerald|amber|violet|indigo|red|cyan|teal|purple|orange|rose)-\d+/);
                        if (colorMatch) {
                            return colorMatch[1];
                        }

                        const bgMatch = classes.match(/bg-(blue|emerald|amber|violet|indigo|red|cyan|teal|purple|orange|rose)-\d+/);
                        if (bgMatch) {
                            return bgMatch[1];
                        }

                        const textMatch = classes.match(/text-(blue|emerald|amber|violet|indigo|red|cyan|teal|purple|orange|rose)-\d+/);
                        if (textMatch) {
                            return textMatch[1];
                        }

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
        @fluxScripts
    </body>
</html>
