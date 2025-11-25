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

        <!-- Split Screen Layout -->
        <div class="relative min-h-screen pt-24">
            <div class="grid min-h-[calc(100vh-6rem)] lg:grid-cols-2">
                <!-- Web Dashboard Section (Left) -->
                <div class="flex flex-col justify-center bg-gradient-to-br from-violet-50 via-white to-purple-50 p-12 dark:from-violet-900/20 dark:via-gray-900 dark:to-purple-900/20">
                    <div class="mx-auto max-w-lg">
                        <div class="mb-8 flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-violet-500 to-purple-600 shadow-lg">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Web Dashboard') }}</h2>
                        </div>
                        
                        <ul class="mb-8 space-y-4 text-gray-700 dark:text-gray-300">
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('Real-time dashboard with statistics and charts') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('Advanced user, task, and vehicle management') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('Role-based permissions and access control') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('File attachments and document management') }}</span>
                            </li>
                        </ul>

                        <!-- Monitor Mockup -->
                        <div class="flex justify-center">
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
                    </div>
                </div>

                <!-- Android App Section (Right) -->
                <div class="flex flex-col justify-center bg-gradient-to-br from-emerald-50 via-white to-teal-50 p-12 dark:from-emerald-900/20 dark:via-gray-900 dark:to-teal-900/20">
                    <div class="mx-auto max-w-lg">
                        <div class="mb-8 flex items-center gap-3">
                            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h2 class="text-3xl font-bold text-gray-900 dark:text-white">{{ __('Android App') }}</h2>
                        </div>
                        
                        <ul class="mb-8 space-y-4 text-gray-700 dark:text-gray-300">
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('Vehicle search and management on mobile') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('Task scheduling with push notifications') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('Real-time team chat and messaging') }}</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <svg class="h-6 w-6 flex-shrink-0 text-emerald-600 dark:text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                </svg>
                                <span>{{ __('Camera integration for documentation') }}</span>
                            </li>
                        </ul>

                        <!-- Mobile Mockup -->
                        <div class="flex justify-center">
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

            <!-- Design Switcher -->
            <div class="absolute bottom-8 left-1/2 -translate-x-1/2 flex gap-2">
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
                width: 500px;
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

        @fluxScripts
    </body>
</html>

