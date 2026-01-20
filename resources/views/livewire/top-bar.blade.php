<div class="hidden sm:block w-full min-h-[2.5rem] sm:h-10 border-b border-zinc-200/50 bg-gradient-to-r from-zinc-50/95 via-white/95 to-zinc-50/95 backdrop-blur-md dark:border-zinc-700/50 dark:from-zinc-900/95 dark:via-zinc-800/95 dark:to-zinc-900/95"
    x-data="{ time: '{{ $currentTime }}', date: '{{ $currentDate }}' }"
    x-init="setInterval(() => { const now = new Date(new Date().toLocaleString('en-US', {timeZone: 'Asia/Tokyo'})); time = now.toLocaleTimeString('en-US', {hour12: false, hour: '2-digit', minute: '2-digit', second: '2-digit'}); date = now.toLocaleDateString('en-US', {month: 'short', day: 'numeric', year: 'numeric'}); }, 1000)">
    <div
        class="flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-1 sm:gap-2 px-2 sm:px-4 py-1 sm:py-0 text-xs sm:text-sm h-full min-h-[2.5rem]">
        <!-- Left: Date, Time, Temperature -->
        <div class="flex items-center gap-1.5 sm:gap-2 md:gap-4 flex-shrink-0">
            <!-- Date & Time -->
            <div class="flex items-center gap-1 sm:gap-2">
                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-zinc-600 dark:text-zinc-400 flex-shrink-0" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <span class="font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap" x-text="date"></span>
                <span class="text-zinc-500 dark:text-zinc-400 hidden sm:inline">•</span>
                <span class="font-mono font-semibold text-zinc-900 dark:text-zinc-100 whitespace-nowrap"
                    x-text="time"></span>
            </div>

            <!-- Tokyo Temperature -->
            <div class="flex items-center gap-1 sm:gap-2 whitespace-nowrap">
                <svg class="h-3.5 w-3.5 sm:h-4 sm:w-4 text-zinc-600 dark:text-zinc-400 flex-shrink-0" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z" />
                </svg>
                <span class="font-semibold text-zinc-900 dark:text-zinc-100">
                    <span class="text-zinc-600 dark:text-zinc-400 hidden md:inline">Tokyo:</span>
                    @if($tokyoTemperature)
                        <span class="text-zinc-900 dark:text-zinc-100">{{ $tokyoTemperature }}°C</span>
                    @else
                        <span class="text-zinc-500 dark:text-zinc-400">--°C</span>
                    @endif
                </span>
            </div>
        </div>

        <!-- Center: Notice Marquee -->
        <div class="flex-1 overflow-hidden min-w-0 relative order-first sm:order-none">
            @if($notices->isNotEmpty())
                <!-- Left fade gradient -->
                <div
                    class="absolute left-0 top-0 bottom-0 w-6 sm:w-8 bg-gradient-to-r from-zinc-50/95 via-zinc-50/95 to-transparent dark:from-zinc-900/95 dark:via-zinc-900/95 pointer-events-none z-10">
                </div>
                <!-- Right fade gradient -->
                <div
                    class="absolute right-0 top-0 bottom-0 w-6 sm:w-8 bg-gradient-to-l from-zinc-50/95 via-zinc-50/95 to-transparent dark:from-zinc-900/95 dark:via-zinc-900/95 pointer-events-none z-10">
                </div>

                <div class="marquee-container relative flex items-center h-full overflow-hidden">
                    <div class="marquee-content flex items-center gap-3 sm:gap-4 md:gap-8 whitespace-nowrap"
                        style="animation: marquee {{ max($notices->count() * 15, 30) }}s linear infinite; will-change: transform;">
                        @foreach($notices as $notice)
                            <span
                                class="inline-flex items-center gap-1.5 sm:gap-2 rounded-full bg-violet-100/80 px-2 sm:px-3 md:px-4 py-0.5 sm:py-1 md:py-1.5 text-xs font-semibold text-violet-700 backdrop-blur-sm dark:bg-violet-900/30 dark:text-violet-300 flex-shrink-0">
                                <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="truncate max-w-[200px] sm:max-w-none">{{ $notice->message }}</span>
                            </span>
                        @endforeach
                        <!-- Duplicate for seamless loop - only visible during animation -->
                        @foreach($notices as $notice)
                            <span
                                class="inline-flex items-center gap-1.5 sm:gap-2 rounded-full bg-violet-100/80 px-2 sm:px-3 md:px-4 py-0.5 sm:py-1 md:py-1.5 text-xs font-semibold text-violet-700 backdrop-blur-sm dark:bg-violet-900/30 dark:text-violet-300 flex-shrink-0"
                                aria-hidden="true">
                                <svg class="h-3 w-3 sm:h-3.5 sm:w-3.5 flex-shrink-0" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="truncate max-w-[200px] sm:max-w-none">{{ $notice->message }}</span>
                            </span>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="flex items-center justify-center h-full">
                    <span class="text-xs text-zinc-400 dark:text-zinc-500 italic">{{ __('No active notices') }}</span>
                </div>
            @endif
        </div>
    </div>

    <style>
        @keyframes marquee {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(calc(-50% - 0.75rem));
            }
        }

        .marquee-container {
            mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
            -webkit-mask-image: linear-gradient(to right, transparent 0%, black 8%, black 92%, transparent 100%);
        }

        .marquee-content {
            display: inline-flex;
            width: max-content;
        }

        @media (prefers-reduced-motion: reduce) {
            .marquee-content {
                animation: none;
            }
        }
    </style>
</div>