@props(['vendor', 'rounded' => true])
<div class="group relative overflow-hidden {{ $rounded ? 'rounded-xl' : '' }} border border-violet-200 bg-white/50 p-4 transition-shadow hover:border-violet-300 hover:shadow-lg dark:border-violet-900/50 dark:bg-gray-800/50 dark:hover:border-violet-800">
    <div class="flex flex-col gap-4">
        <!-- Header: Main info + Actions -->
        <div class="flex items-start justify-between gap-3">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-3">
                    <div class="flex h-8 w-8 items-center justify-center rounded-xl ring-2 ring-violet-500 dark:ring-violet-800 flex-shrink-0">
                        <svg class="h-5 w-5 text-violet-600 dark:text-violet-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                        </svg>
                    </div>
                    <div class="min-w-0 flex-1">
                        <h3 class="text-sm font-bold text-gray-900 dark:text-white break-words whitespace-nowrap">{{ $vendor->name }}</h3>
                    </div>
                </div>
            </div>
            <div class="flex flex-col items-end gap-2 flex-shrink-0">
                <flux:badge color="{{ $vendor->status === 'active' ? 'emerald' : 'gray' }}" size="sm" class="font-semibold">
                    {{ ucfirst($vendor->status) }}
                </flux:badge>
            </div>
        </div>

        <!-- Details Grid -->
        <div class="grid grid-cols-1 gap-3">
            <!-- Email -->
            @if($vendor->email)
                <div class="flex items-start gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                    </svg>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ __('Email') }}</p>
                        <p class="text-xs font-semibold text-gray-900 dark:text-white">{{ $vendor->email }}</p>
                    </div>
                </div>
            @endif

            <!-- Phone -->
            @if($vendor->phone)
                <div class="flex items-start gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ __('Phone') }}</p>
                        <p class="text-xs font-semibold text-gray-900 dark:text-white">{{ $vendor->phone }}</p>
                    </div>
                </div>
            @endif

            <!-- Address -->
            @if($vendor->address)
                <div class="flex items-start gap-2">
                    <svg class="h-4 w-4 flex-shrink-0 text-gray-400 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <div class="min-w-0 flex-1">
                        <p class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ __('Address') }}</p>
                        <p class="text-xs font-semibold text-gray-900 line-clamp-3 lg:line-clamp-none dark:text-white">{{ $vendor->address }}</p>
                    </div>
                </div>
            @endif

            <!-- Vehicle Configuration Status -->
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ __('Vehicle Config') }}</p>
                    @if($vendor->external_db_host && $vendor->external_db_database && $vendor->external_image_path)
                        <flux:badge color="blue" size="xs" class="font-semibold">{{ __('Configured') }}</flux:badge>
                    @else
                        <flux:badge color="gray" size="xs" class="font-semibold">{{ __('Not Set') }}</flux:badge>
                    @endif
                </div>
            </div>

            <!-- Created At -->
            <div class="flex items-center gap-2">
                <svg class="h-4 w-4 flex-shrink-0 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                <div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ __('Created') }}</p>
                    <p class="text-xs font-semibold text-gray-900 dark:text-white whitespace-nowrap">{{ $vendor->created_at->format('M d, Y') }}</p>
                </div>
            </div>
        </div>

        <!-- Actions Footer -->
        <div class="flex items-center justify-end border-t border-gray-200/50 pt-3 dark:border-gray-700/50">
            <div class="flex items-center gap-1.5">
                @php
                    $currentUser = auth()->user();
                    $canDelete = $currentUser && $currentUser->role === 'admin';
                @endphp

                <!-- View Button -->
                <button @click="openPreview({{ $vendor->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-violet-700/60 bg-violet-500/10 p-2 transition-shadow hover:border-violet-700 hover:bg-violet-500/20 hover:shadow-lg hover:shadow-violet-700/30 opacity-50 group-hover:opacity-100" title="{{ __('View Vendor') }}">
                    <svg class="h-4 w-4 text-violet-700 transition-all duration-200 group-hover:text-violet-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                </button>

                <!-- Edit Button -->
                <button @click="openModal({{ $vendor->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-purple-700/60 bg-purple-500/10 p-2 transition-shadow hover:border-purple-700 hover:bg-purple-500/20 hover:shadow-lg hover:shadow-purple-700/30 opacity-50 group-hover:opacity-100" title="{{ __('Edit Vendor') }}">
                    <svg class="h-4 w-4 text-purple-700 transition-all duration-200 group-hover:text-purple-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>
                </button>

                <!-- Delete Button -->
                @if($canDelete)
                    <button @click="window.confirmDelete({{ $vendor->id }}, '{{ addslashes($vendor->name) }}', []).then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-vendor', { vendorId: {{ $vendor->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-2 transition-shadow hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30 opacity-50 group-hover:opacity-100" title="{{ __('Delete Vendor') }}">
                        <svg class="h-4 w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                        </svg>
                    </button>
                @endif
            </div>
        </div>
    </div>
</div>
