@props([
    'variant' => 'emerald', // blue, cyan, emerald, violet, amber, red, gray
])

@php
    $variants = [
        'blue' => [
            'border' => 'border-blue-300/50 dark:border-blue-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-sm shadow-blue-200/20 dark:shadow-blue-900/20',
            'hoverShadow' => 'hover:shadow-md hover:shadow-blue-300/20 dark:hover:shadow-blue-800/20',
            'hoverBorder' => 'hover:border-blue-400/60 dark:hover:border-blue-700',
            'decorTop' => 'bg-gradient-to-br from-blue-400/30 to-cyan-400/30',
            'decorBottom' => 'bg-gradient-to-br from-cyan-400/30 to-blue-400/30',
        ],
        'cyan' => [
            'border' => 'border-cyan-300/50 dark:border-cyan-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-cyan-200/40 dark:shadow-cyan-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-cyan-300/50 dark:hover:shadow-cyan-800/40',
            'hoverBorder' => 'hover:border-cyan-400/60 dark:hover:border-cyan-700',
            'decorTop' => 'bg-gradient-to-br from-cyan-400/30 to-teal-400/30',
            'decorBottom' => 'bg-gradient-to-br from-teal-400/30 to-cyan-400/30',
        ],
        'emerald' => [
            'border' => 'border-emerald-300/50 dark:border-emerald-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-emerald-200/40 dark:shadow-emerald-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-emerald-300/50 dark:hover:shadow-emerald-800/40',
            'hoverBorder' => 'hover:border-emerald-400/60 dark:hover:border-emerald-700',
            'decorTop' => 'bg-gradient-to-br from-emerald-400/30 to-teal-400/30',
            'decorBottom' => 'bg-gradient-to-br from-teal-400/30 to-emerald-400/30',
        ],
        'violet' => [
            'border' => 'border-violet-300/50 dark:border-violet-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-violet-200/40 dark:shadow-violet-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-violet-300/50 dark:hover:shadow-violet-800/40',
            'hoverBorder' => 'hover:border-violet-400/60 dark:hover:border-violet-700',
            'decorTop' => 'bg-gradient-to-br from-violet-400/30 to-purple-400/30',
            'decorBottom' => 'bg-gradient-to-br from-purple-400/30 to-violet-400/30',
        ],
        'amber' => [
            'border' => 'border-amber-300/50 dark:border-amber-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-amber-200/40 dark:shadow-amber-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-amber-300/50 dark:hover:shadow-amber-800/40',
            'hoverBorder' => 'hover:border-amber-400/60 dark:hover:border-amber-700',
            'decorTop' => 'bg-gradient-to-br from-amber-400/30 to-orange-400/30',
            'decorBottom' => 'bg-gradient-to-br from-orange-400/30 to-amber-400/30',
        ],
        'red' => [
            'border' => 'border-red-300/50 dark:border-red-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-red-200/40 dark:shadow-red-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-red-300/50 dark:hover:shadow-red-800/40',
            'hoverBorder' => 'hover:border-red-400/60 dark:hover:border-red-700',
            'decorTop' => 'bg-gradient-to-br from-red-400/30 to-rose-400/30',
            'decorBottom' => 'bg-gradient-to-br from-rose-400/30 to-red-400/30',
        ],
        'gray' => [
            'border' => 'border-gray-300/60 dark:border-gray-600/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-sm shadow-gray-200/30 dark:shadow-gray-900/20',
            'hoverShadow' => 'hover:shadow-md hover:shadow-gray-300/30 dark:hover:shadow-gray-800/30',
            'hoverBorder' => 'hover:border-gray-400/60 dark:hover:border-gray-500',
            'decorTop' => 'bg-gradient-to-br from-gray-300/40 to-gray-400/30',
            'decorBottom' => 'bg-gradient-to-br from-gray-400/30 to-gray-300/40',
        ],
    ];
    
    $classes = $variants[$variant] ?? $variants['emerald'];
@endphp

<div class="page-card group relative rounded-2xl border {{ $classes['border'] }} {{ $classes['bg'] }} {{ $classes['shadow'] }} p-4 ring-1 ring-white/20 transition-shadow duration-300 dark:ring-white/10 {{ $classes['hoverShadow'] }} {{ $classes['hoverBorder'] }}">
    <!-- Decorative Elements Container (with overflow-hidden to clip decorative elements) -->
    <div class="absolute inset-0 overflow-hidden rounded-2xl pointer-events-none">
        <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full {{ $classes['decorTop'] }} blur-2xl"></div>
        <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full {{ $classes['decorBottom'] }} blur-2xl"></div>
    </div>
    
    <div class="relative">
        {{ $slot }}
    </div>
</div>

