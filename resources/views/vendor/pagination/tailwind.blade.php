@if ($paginator->hasPages())
    <nav role="navigation" aria-label="{{ __('Pagination Navigation') }}" class="flex items-center justify-between">
        <div class="flex justify-between flex-1 sm:hidden">
            @if ($paginator->onFirstPage())
                <span class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                    {!! __('pagination.previous') !!}
                </span>
            @else
                <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 text-sm font-medium text-emerald-700 bg-white border border-gray-300 leading-5 rounded-md hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 focus:outline-none focus:ring ring-emerald-300 focus:border-emerald-300 active:bg-emerald-100 active:text-emerald-700 transition ease-in-out duration-150 cursor-pointer dark:bg-gray-800 dark:border-gray-600 dark:text-emerald-300 dark:hover:bg-emerald-900/20 dark:focus:border-emerald-700 dark:active:bg-emerald-900/30 dark:active:text-emerald-300">
                    {!! __('pagination.previous') !!}
                </button>
            @endif

            @if ($paginator->hasMorePages())
                <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-emerald-700 bg-white border border-gray-300 leading-5 rounded-md hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 focus:outline-none focus:ring ring-emerald-300 focus:border-emerald-300 active:bg-emerald-100 active:text-emerald-700 transition ease-in-out duration-150 cursor-pointer dark:bg-gray-800 dark:border-gray-600 dark:text-emerald-300 dark:hover:bg-emerald-900/20 dark:focus:border-emerald-700 dark:active:bg-emerald-900/30 dark:active:text-emerald-300">
                    {!! __('pagination.next') !!}
                </button>
            @else
                <span class="relative inline-flex items-center px-4 py-2 ml-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default leading-5 rounded-md dark:text-gray-600 dark:bg-gray-800 dark:border-gray-600">
                    {!! __('pagination.next') !!}
                </span>
            @endif
        </div>

        <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700 leading-5 dark:text-gray-400">
                    {!! __('Showing') !!}
                    @if ($paginator->firstItem())
                        <span class="font-medium">{{ $paginator->firstItem() }}</span>
                        {!! __('to') !!}
                        <span class="font-medium">{{ $paginator->lastItem() }}</span>
                    @else
                        {{ $paginator->count() }}
                    @endif
                    {!! __('of') !!}
                    <span class="font-medium">{{ $paginator->total() }}</span>
                    {!! __('results') !!}
                </p>
            </div>

            <div>
                <span class="relative z-0 inline-flex rtl:flex-row-reverse shadow-sm rounded-md">
                    {{-- Previous Page Link --}}
                    @if ($paginator->onFirstPage())
                        <span aria-disabled="true" aria-label="{{ __('pagination.previous') }}">
                            <span class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-l-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @else
                        <button type="button" wire:click="previousPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="prev" class="relative inline-flex items-center px-2 py-2 text-sm font-medium text-emerald-600 bg-white border border-gray-300 rounded-l-md leading-5 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 focus:z-10 focus:outline-none focus:ring ring-emerald-300 focus:border-emerald-300 active:bg-emerald-100 active:text-emerald-700 transition ease-in-out duration-150 cursor-pointer dark:bg-gray-800 dark:border-gray-600 dark:text-emerald-400 dark:hover:bg-emerald-900/20 dark:active:bg-emerald-900/30 dark:focus:border-emerald-800" aria-label="{{ __('pagination.previous') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @endif

                    {{-- Pagination Elements --}}
                    @foreach ($elements as $element)
                        {{-- "Three Dots" Separator --}}
                        @if (is_string($element))
                            <span aria-disabled="true">
                                <span class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 cursor-default leading-5 dark:bg-gray-800 dark:border-gray-600">{{ $element }}</span>
                            </span>
                        @endif

                        {{-- Array Of Links --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $paginator->currentPage())
                                    <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" aria-current="page" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-bold text-white bg-emerald-600 border border-emerald-600 leading-5 hover:bg-emerald-700 focus:z-10 focus:outline-none focus:ring ring-emerald-300 focus:border-emerald-500 transition ease-in-out duration-150 cursor-pointer dark:bg-emerald-600 dark:border-emerald-600 dark:hover:bg-emerald-700" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </button>
                                @else
                                    <button type="button" wire:click="gotoPage({{ $page }}, '{{ $paginator->getPageName() }}')" class="relative inline-flex items-center px-4 py-2 -ml-px text-sm font-medium text-gray-700 bg-white border border-gray-300 leading-5 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 focus:z-10 focus:outline-none focus:ring ring-emerald-300 focus:border-emerald-300 active:bg-emerald-100 active:text-emerald-700 transition ease-in-out duration-150 cursor-pointer dark:bg-gray-800 dark:border-gray-600 dark:text-gray-400 dark:hover:bg-emerald-900/20 dark:hover:text-emerald-300 dark:hover:border-emerald-700 dark:active:bg-emerald-900/30 dark:focus:border-emerald-800" aria-label="{{ __('Go to page :page', ['page' => $page]) }}">
                                        {{ $page }}
                                    </button>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Next Page Link --}}
                    @if ($paginator->hasMorePages())
                        <button type="button" wire:click="nextPage('{{ $paginator->getPageName() }}')" wire:loading.attr="disabled" rel="next" class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-emerald-600 bg-white border border-gray-300 rounded-r-md leading-5 hover:bg-emerald-50 hover:text-emerald-700 hover:border-emerald-300 focus:z-10 focus:outline-none focus:ring ring-emerald-300 focus:border-emerald-300 active:bg-emerald-100 active:text-emerald-700 transition ease-in-out duration-150 cursor-pointer dark:bg-gray-800 dark:border-gray-600 dark:text-emerald-400 dark:hover:bg-emerald-900/20 dark:active:bg-emerald-900/30 dark:focus:border-emerald-800" aria-label="{{ __('pagination.next') }}">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    @else
                        <span aria-disabled="true" aria-label="{{ __('pagination.next') }}">
                            <span class="relative inline-flex items-center px-2 py-2 -ml-px text-sm font-medium text-gray-500 bg-white border border-gray-300 cursor-default rounded-r-md leading-5 dark:bg-gray-800 dark:border-gray-600" aria-hidden="true">
                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                                </svg>
                            </span>
                        </span>
                    @endif
                </span>
            </div>
        </div>
    </nav>
@endif
