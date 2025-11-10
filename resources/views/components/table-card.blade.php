@props([
    'variant' => 'emerald', // blue, emerald, violet, amber
])

@php
    $variants = [
        'blue' => [
            'border' => 'border-blue-200 dark:border-blue-900/50',
            'bg' => 'bg-gradient-to-br from-white via-blue-50/30 to-cyan-50/30 dark:from-gray-900 dark:via-blue-900/20 dark:to-cyan-900/20',
            'decorTop' => 'bg-gradient-to-br from-blue-400/20 to-cyan-400/20',
            'decorBottom' => 'bg-gradient-to-br from-cyan-400/20 to-blue-400/20',
        ],
        'emerald' => [
            'border' => 'border-emerald-200 dark:border-emerald-900/50',
            'bg' => 'bg-gradient-to-br from-white via-emerald-50/30 to-teal-50/30 dark:from-gray-900 dark:via-emerald-900/20 dark:to-teal-900/20',
            'decorTop' => 'bg-gradient-to-br from-emerald-400/20 to-teal-400/20',
            'decorBottom' => 'bg-gradient-to-br from-teal-400/20 to-emerald-400/20',
        ],
        'violet' => [
            'border' => 'border-violet-200 dark:border-violet-900/50',
            'bg' => 'bg-gradient-to-br from-white via-violet-50/30 to-purple-50/30 dark:from-gray-900 dark:via-violet-900/20 dark:to-purple-900/20',
            'decorTop' => 'bg-gradient-to-br from-violet-400/20 to-purple-400/20',
            'decorBottom' => 'bg-gradient-to-br from-purple-400/20 to-violet-400/20',
        ],
        'amber' => [
            'border' => 'border-amber-200 dark:border-amber-900/50',
            'bg' => 'bg-gradient-to-br from-white via-amber-50/30 to-orange-50/30 dark:from-gray-900 dark:via-amber-900/20 dark:to-orange-900/20',
            'decorTop' => 'bg-gradient-to-br from-amber-400/20 to-orange-400/20',
            'decorBottom' => 'bg-gradient-to-br from-orange-400/20 to-amber-400/20',
        ],
    ];
    
    $classes = $variants[$variant] ?? $variants['emerald'];
@endphp

<div class="group relative overflow-hidden rounded-2xl border {{ $classes['border'] }} {{ $classes['bg'] }} p-6 shadow-xl transition-all duration-300 hover:shadow-2xl">
    <!-- Decorative Elements -->
    <div class="absolute -right-8 -top-8 h-32 w-32 rounded-full {{ $classes['decorTop'] }} blur-2xl"></div>
    <div class="absolute -bottom-8 -left-8 h-32 w-32 rounded-full {{ $classes['decorBottom'] }} blur-2xl"></div>
    
    <div class="relative">
        {{ $slot }}
    </div>
</div>

