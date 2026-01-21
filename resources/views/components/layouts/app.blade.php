<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="w-full max-w-[1600px] 2xl:max-w-none mx-auto px-4 sm:px-6 lg:px-8 2xl:px-12 main-content-padding">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
