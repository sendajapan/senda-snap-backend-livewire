@props([
    'title',
    'description',
    'icon',
    'variant' => 'blue', // blue, emerald, violet, amber
])

@php
    $variants = [
        'blue' => [
            'border' => 'border-blue-300/50 dark:border-blue-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-blue-200/40 dark:shadow-blue-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-blue-300/50 dark:hover:shadow-blue-800/40',
            'hoverBorder' => 'hover:border-blue-400/60 dark:hover:border-blue-700',
            'decorTop' => 'bg-gradient-to-br from-blue-400/30 to-cyan-400/30',
            'decorBottom' => 'bg-gradient-to-br from-cyan-400/30 to-blue-400/30',
            'iconBg' => 'bg-gradient-to-br from-blue-500 to-cyan-500',
        ],
        'emerald' => [
            'border' => 'border-emerald-300/50 dark:border-emerald-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-emerald-200/40 dark:shadow-emerald-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-emerald-300/50 dark:hover:shadow-emerald-800/40',
            'hoverBorder' => 'hover:border-emerald-400/60 dark:hover:border-emerald-700',
            'decorTop' => 'bg-gradient-to-br from-emerald-400/30 to-teal-400/30',
            'decorBottom' => 'bg-gradient-to-br from-teal-400/30 to-emerald-400/30',
            'iconBg' => 'bg-gradient-to-br from-emerald-500 to-teal-500',
        ],
        'violet' => [
            'border' => 'border-violet-300/50 dark:border-violet-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-violet-200/40 dark:shadow-violet-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-violet-300/50 dark:hover:shadow-violet-800/40',
            'hoverBorder' => 'hover:border-violet-400/60 dark:hover:border-violet-700',
            'decorTop' => 'bg-gradient-to-br from-violet-400/30 to-purple-400/30',
            'decorBottom' => 'bg-gradient-to-br from-purple-400/30 to-violet-400/30',
            'iconBg' => 'bg-gradient-to-br from-violet-500 to-purple-500',
        ],
        'amber' => [
            'border' => 'border-amber-300/50 dark:border-amber-800/50',
            'bg' => 'bg-white/60 backdrop-blur-xl dark:bg-gray-900/50',
            'shadow' => 'shadow-xl shadow-amber-200/40 dark:shadow-amber-900/30',
            'hoverShadow' => 'hover:shadow-2xl hover:shadow-amber-300/50 dark:hover:shadow-amber-800/40',
            'hoverBorder' => 'hover:border-amber-400/60 dark:hover:border-amber-700',
            'decorTop' => 'bg-gradient-to-br from-amber-400/30 to-orange-400/30',
            'decorBottom' => 'bg-gradient-to-br from-orange-400/30 to-amber-400/30',
            'iconBg' => 'bg-gradient-to-br from-amber-500 to-orange-500',
        ],
    ];
    
    $classes = $variants[$variant] ?? $variants['blue'];
@endphp

<div class="group relative rounded-2xl border {{ $classes['border'] }} {{ $classes['bg'] }} {{ $classes['shadow'] }} p-6 ring-1 ring-white/20 transition-all duration-300 dark:ring-white/10 {{ $classes['hoverShadow'] }} {{ $classes['hoverBorder'] }}">
    <!-- Decorative Elements Container (with overflow-hidden to clip decorative elements) -->
    <div class="absolute inset-0 overflow-hidden rounded-2xl pointer-events-none">
        <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full {{ $classes['decorTop'] }} blur-2xl"></div>
        <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full {{ $classes['decorBottom'] }} blur-2xl"></div>
    </div>
    
    <div class="relative flex items-center justify-between z-10">
        <div class="flex items-center gap-4">
            @if(isset($icon))
                <div class="flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-2xl {{ $classes['iconBg'] }} shadow-lg">
                    {!! $icon !!}
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $title }}</h1>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">{{ $description }}</p>
            </div>
        </div>
        @if(isset($actions))
            <div>
                {{ $actions }}
            </div>
        @endif
    </div>
</div>

