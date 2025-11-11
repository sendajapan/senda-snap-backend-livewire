@props([
    'title',
    'count',
    'description',
    'topCircleColor' => 'bg-blue-300',
    'bottomCircleColor' => 'bg-blue-400',
    'icon',
])

<div class="group relative overflow-hidden shadow-lg rounded-2xl border bg-zink-200 dark:bg-zinc-900 dark:border-gray-200 p-6 transition-all hover:scale-100 hover:shadow-2xl">
    <div class="absolute -right-4 -top-4 h-24 w-24 rounded-full {{ $topCircleColor }} dark:bg-white/10 backdrop-blur-sm"></div>
    <div class="absolute -bottom-4 -right-4 h-32 w-32 rounded-full {{ $bottomCircleColor }} dark:bg-white/5"></div>
    <div class="relative">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-accent">{{ $title }}</p>
                <h3 class="mt-2 text-4xl font-bold text-accent">{{ $count }}</h3>
            </div>
            <div class="rounded-2xl bg-white/20 p-4 backdrop-blur-sm">
                {!! $icon !!}
            </div>
        </div>
        <div class="mt-4 flex items-center text-sm text-accent">
            <svg class="mr-1 h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
            </svg>
            <span>{{ $description }}</span>
        </div>
    </div>
</div>

