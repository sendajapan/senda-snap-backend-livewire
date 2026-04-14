@props(['shippingCompany', 'index'])
<tr class="group hover:bg-indigo-50/30 dark:hover:bg-indigo-900/10">
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 text-center">
        <span class="text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $index ?? '' }}</span>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <div class="flex items-center">
            <div class="flex h-10 md:h-12 w-10 md:w-12 items-center justify-center rounded-xl bg-indigo-400/20 shadow-lg ring-2 ring-indigo-300 dark:ring-indigo-800 flex-shrink-0">
                <svg class="h-5 md:h-6 w-5 md:w-6 text-indigo-600 dark:text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
            </div>
            <div class="ml-2 md:ml-4">
                <div class="text-xs md:text-sm font-bold text-gray-900 dark:text-white">
                    {{ $shippingCompany->line_name }}
                </div>
            </div>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
        <flux:badge :color="$shippingCompany->status === 'Active' ? 'emerald' : 'gray'" size="sm" class="font-semibold text-xs">
            {{ $shippingCompany->status }}
        </flux:badge>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 hidden lg:table-cell">
        <div class="flex flex-col">
            <span class="text-xs md:text-sm text-gray-900 dark:text-white">{{ $shippingCompany->created_at->format('M d, Y') }}</span>
            <span class="text-[10px] md:text-xs text-gray-500 dark:text-gray-400">{{ $shippingCompany->created_at->format('h:i A') }}</span>
        </div>
    </td>
    <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 w-32">
        <div class="flex justify-center items-center gap-1.5 md:gap-2">
            @php
                $currentUser = auth()->user();
                $canDelete = $currentUser && in_array($currentUser->role, ['admin', 'manager']);
            @endphp

            <!-- View Button -->
            <button @click="openPreview({{ $shippingCompany->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-indigo-700/60 bg-indigo-500/10 p-1.5 transition-all duration-200 hover:border-indigo-700 hover:bg-indigo-500/20 hover:shadow-lg hover:shadow-indigo-700/30" title="{{ __('View Shipping Company') }}">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-indigo-700 transition-all duration-200 group-hover:text-indigo-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
            </button>

            <!-- Edit Button -->
            <button @click="openModal({{ $shippingCompany->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 transition-all duration-200 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-700/30" title="{{ __('Edit Shipping Company') }}">
                <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-cyan-700 transition-all duration-200 group-hover:text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                </svg>
            </button>

            <!-- Delete Button -->
            @if($canDelete)
                <button @click="window.confirmDelete({{ $shippingCompany->id }}, '{{ addslashes($shippingCompany->line_name) }}', []).then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-shipping-company', { shippingCompanyId: {{ $shippingCompany->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 transition-all duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30" title="{{ __('Delete Shipping Company') }}">
                    <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                    </svg>
                </button>
            @endif
        </div>
    </td>
</tr>
