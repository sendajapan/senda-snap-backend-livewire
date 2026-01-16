@props([
    'title',
    'count',
    'description',
    'variant' => 'blue',
    'icon',
])

@php
    $variants = [
        'blue' => [
            'gradient' => 'from-blue-500 to-cyan-500',
            'border' => 'border-blue-300/50 hover:border-blue-400/60',
            'shadow' => 'shadow-md shadow-blue-200/20 hover:shadow-lg hover:shadow-blue-300/25',
            'blur1' => 'bg-blue-400/30',
            'blur2' => 'bg-cyan-400/30',
            'text' => 'text-blue-900 dark:text-blue-100',
            'subtext' => 'text-blue-600 dark:text-blue-400',
            'darkBorder' => 'dark:border-blue-700/50 dark:hover:border-blue-600',
            'darkShadow' => 'dark:shadow-blue-900/15 dark:hover:shadow-blue-800/20',
        ],
        'emerald' => [
            'gradient' => 'from-emerald-500 to-teal-500',
            'border' => 'border-emerald-300/50 hover:border-emerald-400/60',
            'shadow' => 'shadow-md shadow-emerald-200/20 hover:shadow-lg hover:shadow-emerald-300/25',
            'blur1' => 'bg-emerald-400/30',
            'blur2' => 'bg-teal-400/30',
            'text' => 'text-emerald-900 dark:text-emerald-100',
            'subtext' => 'text-emerald-600 dark:text-emerald-400',
            'darkBorder' => 'dark:border-emerald-700/50 dark:hover:border-emerald-600',
            'darkShadow' => 'dark:shadow-emerald-900/15 dark:hover:shadow-emerald-800/20',
        ],
        'amber' => [
            'gradient' => 'from-amber-500 to-orange-500',
            'border' => 'border-amber-300/50 hover:border-amber-400/60',
            'shadow' => 'shadow-md shadow-amber-200/20 hover:shadow-lg hover:shadow-amber-300/25',
            'blur1' => 'bg-amber-400/30',
            'blur2' => 'bg-orange-400/30',
            'text' => 'text-amber-900 dark:text-amber-100',
            'subtext' => 'text-amber-600 dark:text-amber-400',
            'darkBorder' => 'dark:border-amber-700/50 dark:hover:border-amber-600',
            'darkShadow' => 'dark:shadow-amber-900/15 dark:hover:shadow-amber-800/20',
        ],
        'violet' => [
            'gradient' => 'from-violet-500 to-purple-500',
            'border' => 'border-violet-300/50 hover:border-violet-400/60',
            'shadow' => 'shadow-md shadow-violet-200/20 hover:shadow-lg hover:shadow-violet-300/25',
            'blur1' => 'bg-violet-400/30',
            'blur2' => 'bg-purple-400/30',
            'text' => 'text-violet-900 dark:text-violet-100',
            'subtext' => 'text-violet-600 dark:text-violet-400',
            'darkBorder' => 'dark:border-violet-700/50 dark:hover:border-violet-600',
            'darkShadow' => 'dark:shadow-violet-900/15 dark:hover:shadow-violet-800/20',
        ],
        'red' => [
            'gradient' => 'from-red-500 to-rose-500',
            'border' => 'border-red-300/50 hover:border-red-400/60',
            'shadow' => 'shadow-md shadow-red-200/20 hover:shadow-lg hover:shadow-red-300/25',
            'blur1' => 'bg-red-400/30',
            'blur2' => 'bg-rose-400/30',
            'text' => 'text-red-900 dark:text-red-100',
            'subtext' => 'text-red-600 dark:text-red-400',
            'darkBorder' => 'dark:border-red-700/50 dark:hover:border-red-600',
            'darkShadow' => 'dark:shadow-red-900/15 dark:hover:shadow-red-800/20',
        ],
    ];
    $v = $variants[$variant] ?? $variants['blue'];
@endphp

<div class="group relative overflow-hidden rounded-2xl border {{ $v['border'] }} bg-white/60 p-6 {{ $v['shadow'] }} backdrop-blur-xl transition-all duration-300 {{ $v['darkBorder'] }} dark:bg-gray-800/60 {{ $v['darkShadow'] }}">
    <style>
        @keyframes bubble-float {
            0%, 100% { transform: translateY(0) translateX(0) scale(1); opacity: 0.6; }
            25% { transform: translateY(-15px) translateX(10px) scale(1.1); opacity: 0.8; }
            50% { transform: translateY(-25px) translateX(-5px) scale(0.9); opacity: 0.7; }
            75% { transform: translateY(-10px) translateX(15px) scale(1.05); opacity: 0.75; }
        }
        .bubble-animate-1 { animation: bubble-float 6s ease-in-out infinite; }
        .bubble-animate-2 { animation: bubble-float 8s ease-in-out infinite 1s; }
        .bubble-animate-3 { animation: bubble-float 7s ease-in-out infinite 2s; }
        .bubble-animate-4 { animation: bubble-float 9s ease-in-out infinite 0.5s; }
        .bubble-animate-5 { animation: bubble-float 6.5s ease-in-out infinite 1.5s; }
    </style>
    
    <!-- Decorative blur circles (side areas - faded) -->
    <div class="pointer-events-none absolute -right-8 -top-8 h-32 w-32 rounded-full {{ $v['blur1'] }} blur-2xl opacity-30"></div>
    <div class="pointer-events-none absolute -bottom-8 -left-8 h-32 w-32 rounded-full {{ $v['blur2'] }} blur-2xl opacity-30"></div>
    
    <!-- Light bubble particles - Middle section (proper bubbles) -->
    <div class="pointer-events-none absolute left-1/2 top-1/3 h-16 w-16 -translate-x-1/2 -translate-y-1/2 rounded-full {{ $v['blur1'] }} blur-xl bubble-animate-1 opacity-60"></div>
    <div class="pointer-events-none absolute left-1/2 top-2/3 h-12 w-12 -translate-x-1/2 -translate-y-1/2 rounded-full {{ $v['blur2'] }} blur-lg bubble-animate-2 opacity-70"></div>
    <div class="pointer-events-none absolute left-1/3 top-1/2 h-14 w-14 -translate-x-1/2 -translate-y-1/2 rounded-full {{ $v['blur1'] }} blur-xl bubble-animate-3 opacity-65"></div>
    <div class="pointer-events-none absolute left-2/3 top-1/2 h-10 w-10 -translate-x-1/2 -translate-y-1/2 rounded-full {{ $v['blur2'] }} blur-lg bubble-animate-4 opacity-68"></div>
    
    <!-- Light bubble particles - Side areas (faded) -->
    <div class="pointer-events-none absolute left-1/4 top-1/4 h-8 w-8 rounded-full {{ $v['blur1'] }} blur-md bubble-animate-5 opacity-20"></div>
    <div class="pointer-events-none absolute right-1/4 top-1/4 h-8 w-8 rounded-full {{ $v['blur2'] }} blur-md bubble-animate-1 opacity-20"></div>
    <div class="pointer-events-none absolute left-1/4 bottom-1/4 h-8 w-8 rounded-full {{ $v['blur1'] }} blur-md bubble-animate-3 opacity-20"></div>
    <div class="pointer-events-none absolute right-1/4 bottom-1/4 h-8 w-8 rounded-full {{ $v['blur2'] }} blur-md bubble-animate-2 opacity-20"></div>
    
    <div class="relative z-10">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium {{ $v['subtext'] }}">{{ $title }}</p>
                <h3 class="mt-2 text-4xl font-bold {{ $v['text'] }}">{{ $count }}</h3>
            </div>
            <div class="rounded-xl bg-gradient-to-br {{ $v['gradient'] }} p-3 shadow-md">
                {!! $icon !!}
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm {{ $v['subtext'] }}">
            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <span>{{ $description }}</span>
        </div>
    </div>
</div>

