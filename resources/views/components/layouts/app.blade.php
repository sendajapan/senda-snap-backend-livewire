<x-layouts.app.sidebar :title="$title ?? null">
    <flux:main class="w-full 2xl:w-[90%]">
        {{ $slot }}
    </flux:main>
</x-layouts.app.sidebar>
