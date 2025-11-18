<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="dark">
    <head>
        @include('partials.head')
    </head>
    <body class="min-h-screen bg-white antialiased dark:bg-linear-to-b dark:from-neutral-950 dark:to-neutral-900">
        <!-- Particle Background Canvas -->
        <canvas id="particle-canvas" class="fixed inset-0 -z-10 pointer-events-none"></canvas>
        
        <div class="bg-background flex min-h-svh flex-col gap-4 p-6 md:p-10 relative">
            <!-- Back Arrow Navigation -->
            <div class="flex items-center">
                <a href="{{ route('home') }}" class="flex items-center gap-2 text-gray-600 hover:text-gray-900 dark:text-gray-400 dark:hover:text-gray-100 transition-colors" wire:navigate>
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    <span class="sr-only">{{ __('Back') }}</span>
                </a>
            </div>

            <!-- Main Content -->
            <div class="flex w-full max-w-7xl mx-auto flex-col gap-4">
                {{ $slot }}
            </div>
        </div>
        @fluxScripts
        
        @stack('scripts')
    </body>
</html>

