<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="w-full 2xl:max-w-none mx-auto !p-0 sm:!px-4 lg:!pt-6 lg:!px-8 2xl:!px-12 main-content-padding">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
