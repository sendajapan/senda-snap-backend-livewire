<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
        <title>{{ config('app.name') }} - Vehicle Management & Task Scheduling</title>
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <!-- Top Navigation -->
        <nav class="fixed top-0 left-0 right-0 z-50 border-b border-gray-200/50 bg-white/95 backdrop-blur-md dark:border-gray-800/50 dark:bg-gray-900/95 shadow-sm" x-data="{ mobileMenuOpen: false }">
            <div class="mx-auto max-w-7xl px-6 py-2">
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
                                <a href="{{ route('login') }}" class="rounded-lg border-1 border-gray-500 bg-white px-5 py-2.5 text-sm font-semibold text-gray-900 transition-all hover:bg-gray-50 hover:border-gray-700 dark:border-gray-700 dark:bg-gray-800 dark:text-white dark:hover:bg-gray-700 dark:hover:border-gray-600">
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
        <div class="relative h-screen max-h-[1080px] pt-24 pb-12">
            <!-- Particle Background -->
            <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>

            <div class="mx-auto max-w-7xl h-full px-4 sm:px-6 lg:px-8">
                <!-- Hero Content -->
                <div class="text-center mb-4 sm:mb-6 mt-8 sm:mt-12">
                    <h1 class="mb-2 sm:mb-3 text-2xl sm:text-3xl font-bold text-gray-900 dark:text-white lg:text-4xl">
                        {{ __('Manage Vehicles & Tasks') }}
                        <span class="block bg-gradient-to-r from-violet-600 to-purple-600 bg-clip-text text-transparent">
                            {{ __('Seamlessly') }}
                        </span>
                    </h1>
                    <p class="mx-auto max-w-2xl text-sm sm:text-base lg:text-lg text-gray-600 dark:text-gray-400">
                        {{ __('Comprehensive web dashboard and Android app for vehicle management, task scheduling, and team collaboration.') }}
                    </p>
                </div>

                <!-- Features and Screenshots Side by Side -->
                <div class="relative grid gap-6 sm:gap-8 lg:grid-cols-2 lg:gap-20 items-start lg:items-center h-[calc(100%-180px)] sm:h-[calc(100%-200px)]">
                    <!-- Features Section (Left) -->
                    <div class="relative z-20 space-y-4 sm:space-y-5 lg:space-y-6">
                        <!-- Web Features -->
                        <div class="rounded-2xl border border-violet-200 bg-gradient-to-br from-white via-violet-50/30 to-purple-50/30 p-4 sm:p-5 lg:p-6 shadow-xl dark:border-violet-900/50 dark:from-gray-900 dark:via-violet-900/20 dark:to-purple-900/20">
                            <div class="mb-3 flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Web Dashboard') }}</h2>
                            </div>
                            <ul class="space-y-1.5 text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Comprehensive dashboard with real-time statistics and charts') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('User, task, and vehicle management with advanced filtering') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Role-based access control and permissions') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('File attachments and document management') }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Android Features -->
                        <div class="rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-4 sm:p-5 lg:p-6 shadow-xl dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20">
                            <div class="mb-3 flex items-center gap-3">
                                <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                    <svg class="h-4 w-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                </div>
                                <h2 class="text-lg font-bold text-gray-900 dark:text-white">{{ __('Android App') }}</h2>
                            </div>
                            <ul class="space-y-1.5 text-sm text-gray-700 dark:text-gray-300">
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Vehicle search and management on the go') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Task and schedule management with notifications') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Real-time team chat and communication') }}</span>
                                </li>
                                <li class="flex items-start gap-2">
                                    <svg class="h-4 w-4 flex-shrink-0 mt-0.5 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                    </svg>
                                    <span>{{ __('Camera integration for vehicle documentation') }}</span>
                                </li>
                            </ul>
                        </div>

                        <!-- Play Store Download Section -->
                        <a href="https://play.google.com/store/apps/details?id=com.sendajapan.sendasnap" 
                           target="_blank"
                           rel="noopener noreferrer"
                           class="group block rounded-2xl border border-emerald-200 bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 p-4 sm:p-6 lg:p-8 shadow-xl transition-all hover:scale-[1.02] hover:shadow-2xl hover:shadow-emerald-500/20 dark:border-emerald-900/50 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20 dark:hover:shadow-emerald-500/10">
                            <div class="flex flex-col items-center text-center">
                                <!-- App Icon -->
                                <div class="mb-4 sm:mb-5 lg:mb-6 flex h-20 w-20 sm:h-24 sm:w-24 lg:h-28 lg:w-28 items-center justify-center transition-transform group-hover:scale-110 relative">
                                    <img src="https://play-lh.googleusercontent.com/WXLRHhKAqge_MSE5lTZewLN53eVVwQGwS-3mT6eb0rzAeVz2Pp5mrw_3sDk1dxUPZkOopFGW1qEfTz5e5WRT=w480-h960-rw" 
                                         alt="{{ __('Senda Snap App Icon') }}"
                                         class="h-full w-full rounded-3xl object-cover app-icon-fade">
                                </div>
                                
                                <!-- App Information -->
                                <h3 class="mb-1 sm:mb-2 text-lg sm:text-xl lg:text-2xl font-bold text-gray-900 dark:text-white">{{ __('Senda Snap') }}</h3>
                                <p class="mb-3 sm:mb-4 text-xs sm:text-sm text-gray-600 dark:text-gray-400">
                                    {{ __('Your Complete Vehicle Image Management & Team Collaboration Solution') }}
                                </p>
                                
                                <!-- App Details -->
                                <div class="mb-4 sm:mb-5 lg:mb-6 flex flex-wrap items-center justify-center gap-3 sm:gap-4 text-xs text-gray-500 dark:text-gray-400">
                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M12,4C16.41,4 20,7.59 20,12C20,16.41 16.41,20 12,20C7.59,20 4,16.41 4,12C4,7.59 7.59,4 12,4M12,6A6,6 0 0,0 6,12A6,6 0 0,0 12,18A6,6 0 0,0 18,12A6,6 0 0,0 12,6M12,8A4,4 0 0,1 16,12A4,4 0 0,1 12,16A4,4 0 0,1 8,12A4,4 0 0,1 12,8Z" />
                                        </svg>
                                        <span>{{ __('10+ Downloads') }}</span>
                                    </div>
                                    <div class="flex items-center gap-1">
                                        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12,17.27L18.18,21L16.54,13.97L22,9.24L14.81,8.62L12,2L9.19,8.62L2,9.24L7.46,13.97L5.82,21L12,17.27Z" />
                                        </svg>
                                        <span>{{ __('Everyone') }}</span>
                                    </div>
                                </div>
                                
                                <!-- Official Google Play Store Badge -->
                                <div class="flex items-center justify-center">
                                    <img src="https://play.google.com/intl/en_us/badges/static/images/badges/en_badge_web_generic.png" 
                                         alt="{{ __('Get it on Google Play') }}"
                                         class="h-10 sm:h-12 lg:h-14 transition-transform group-hover:scale-105"
                                         onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                                    <div class="hidden items-center gap-2 rounded-lg bg-gradient-to-r from-emerald-600 to-teal-600 px-6 py-3 text-sm font-semibold text-white shadow-md transition-all group-hover:from-emerald-700 group-hover:to-teal-700 group-hover:shadow-lg">
                                        <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor">
                                            <path d="M3,20.5V3.5C3,2.91 3.34,2.39 3.84,2.15L13.69,12L3.84,21.85C3.34,21.6 3,21.09 3,20.5M16.81,15.12L6.05,21.34L14.54,12.85L16.81,15.12M20.16,10.81C20.5,11.08 20.75,11.5 20.75,12C20.75,12.5 20.5,12.92 20.16,13.19L17.19,15.53L15.12,13.46L17.47,12L15.12,10.54L17.19,8.47L20.16,10.81M6.05,2.66L16.81,8.88L14.54,11.15L6.05,2.66Z" />
                                        </svg>
                                        <span>{{ __('Get it on Google Play') }}</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Screenshots Section (Right) -->
                    <div class="relative flex items-center justify-center lg:justify-end">
                        <!-- Monitor Mockup -->
                        <div class="relative z-0 -mr-12 hidden lg:block">
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
                        <div class="relative z-10">
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
                width: 540px;
                max-width: 100%;
                background: #ffffff;
                border-radius: 12px;
                padding: 14px;
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
                width: 250px;
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
                    width: 220px;
                }
            }

            @media (max-width: 768px) {
                .phone-frame {
                    width: 200px;
                }
            }

            @media (max-width: 640px) {
                .phone-frame {
                    width: 180px;
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
