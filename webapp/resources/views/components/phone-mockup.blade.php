@props([
    'image' => null,
    'alt' => null,
    'zoomable' => false,
])

<div class="phone-mockup">
    <div class="phone-frame">
        <div class="phone-screen">
            @if($image)
                <img src="{{ asset($image) }}"
                    alt="{{ $alt ?? __('Phone Screenshot') }}"
                    class="phone-image {{ $zoomable ? 'cursor-pointer hover:opacity-90 transition-opacity manual-image' : '' }}"
                    @if($zoomable)
                        data-zoom-src="{{ asset($image) }}"
                        data-zoom-alt="{{ $alt ?? __('Phone Screenshot') }}"
                    @endif
                    onerror="this.style.display='none'; this.nextElementSibling.style.display='block';">
                <div class="p-12 text-center" style="display: none;">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                        {{ $alt ?? __('Phone Screenshot') }}
                    </p>
                </div>
            @else
                <div class="flex h-full w-full flex-col items-center justify-center bg-white p-12 text-center dark:bg-gray-800">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="mt-4 text-sm font-medium text-gray-600 dark:text-gray-400">
                        {{ __('No Image') }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</div>

