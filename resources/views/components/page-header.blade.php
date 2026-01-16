@props([
    'title',
    'description',
    'icon',
    'variant' => 'blue', // blue, emerald, violet, amber
])

@php
    $variants = [
        'blue' => [
            'border' => 'border-blue-200 dark:border-blue-900/50',
            'bg' => 'bg-white/50 backdrop-blur-sm dark:bg-gray-800/50',
            'shadow' => 'shadow-md shadow-blue-100/50 dark:shadow-blue-900/20',
            'hoverShadow' => 'hover:shadow-lg hover:shadow-blue-200/50 dark:hover:shadow-blue-800/30',
            'hoverBorder' => 'hover:border-blue-300 dark:hover:border-blue-800',
            'decorTop' => 'bg-gradient-to-br from-blue-400/20 to-cyan-400/20',
            'decorBottom' => 'bg-gradient-to-br from-cyan-400/20 to-blue-400/20',
            'iconBg' => 'bg-gradient-to-br from-blue-500 to-cyan-500',
        ],
        'emerald' => [
            'border' => 'border-emerald-200 dark:border-emerald-900/50',
            'bg' => 'bg-white/50 backdrop-blur-sm dark:bg-gray-800/50',
            'shadow' => 'shadow-md shadow-emerald-100/50 dark:shadow-emerald-900/20',
            'hoverShadow' => 'hover:shadow-lg hover:shadow-emerald-200/50 dark:hover:shadow-emerald-800/30',
            'hoverBorder' => 'hover:border-emerald-300 dark:hover:border-emerald-800',
            'decorTop' => 'bg-gradient-to-br from-emerald-400/20 to-teal-400/20',
            'decorBottom' => 'bg-gradient-to-br from-teal-400/20 to-emerald-400/20',
            'iconBg' => 'bg-gradient-to-br from-emerald-500 to-teal-500',
        ],
        'violet' => [
            'border' => 'border-violet-200 dark:border-violet-900/50',
            'bg' => 'bg-white/50 backdrop-blur-sm dark:bg-gray-800/50',
            'shadow' => 'shadow-md shadow-violet-100/50 dark:shadow-violet-900/20',
            'hoverShadow' => 'hover:shadow-lg hover:shadow-violet-200/50 dark:hover:shadow-violet-800/30',
            'hoverBorder' => 'hover:border-violet-300 dark:hover:border-violet-800',
            'decorTop' => 'bg-gradient-to-br from-violet-400/20 to-purple-400/20',
            'decorBottom' => 'bg-gradient-to-br from-purple-400/20 to-violet-400/20',
            'iconBg' => 'bg-gradient-to-br from-violet-500 to-purple-500',
        ],
        'amber' => [
            'border' => 'border-amber-200 dark:border-amber-900/50',
            'bg' => 'bg-white/50 backdrop-blur-sm dark:bg-gray-800/50',
            'shadow' => 'shadow-md shadow-amber-100/50 dark:shadow-amber-900/20',
            'hoverShadow' => 'hover:shadow-lg hover:shadow-amber-200/50 dark:hover:shadow-amber-800/30',
            'hoverBorder' => 'hover:border-amber-300 dark:hover:border-amber-800',
            'decorTop' => 'bg-gradient-to-br from-amber-400/20 to-orange-400/20',
            'decorBottom' => 'bg-gradient-to-br from-orange-400/20 to-amber-400/20',
            'iconBg' => 'bg-gradient-to-br from-amber-500 to-orange-500',
        ],
    ];
    
    $classes = $variants[$variant] ?? $variants['blue'];
@endphp

<div class="group relative rounded-2xl border {{ $classes['border'] }} {{ $classes['bg'] }} {{ $classes['shadow'] }} p-6 transition-all duration-300 {{ $classes['hoverShadow'] }} {{ $classes['hoverBorder'] }}">
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

