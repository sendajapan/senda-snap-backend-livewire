<div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{
    openModal(vendorId = null) {
        $wire.$dispatch('open-vendor-modal', { vendorId: vendorId })
    },
    openPreview(vendorId = null) {
        $wire.$dispatch('open-vendor-preview', { vendorId: vendorId })
    },
    confirmDelete(vendorId, vendorName = null) {
        return window.confirmDelete(vendorId, vendorName);
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Vendors')"
        :description="__('Manage and view vendors')"
        variant="violet">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Vendor') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="violet">
        <div class="mb-4 flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search by name, email, or phone...') }}"
                    icon="magnifying-glass" />
            </div>
            <div class="w-48">
                <flux:select wire:model.live="statusFilter" placeholder="{{ __('All Status') }}">
                    <option value="">{{ __('All Status') }}</option>
                    <option value="active">{{ __('Active') }}</option>
                    <option value="inactive">{{ __('Inactive') }}</option>
                </flux:select>
            </div>

            @if($search || $statusFilter)
                <div class="flex items-center">
                    <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                        {{ __('Clear Filters') }}
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if($search || $statusFilter)
            <div class="mb-3 flex flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>
                @if($search)
                    <flux:badge color="violet" size="sm">{{ __('Search:') }} "{{ $search }}"</flux:badge>
                @endif
                @if($statusFilter)
                    <flux:badge color="blue" size="sm">{{ __('Status:') }} {{ ucfirst($statusFilter) }}</flux:badge>
                @endif
            </div>
        @endif

        <!-- Table View (2xl and above) -->
        <div class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20"
             wire:key="vendors-table-{{ md5(($search ?? '').'|'.($statusFilter ?? '')) }}">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Vendor Name') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Email') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Phone') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Status') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden lg:table-cell">
                            {{ __('Created At') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($vendors as $vendor)
                        <x-vendor-table-row :vendor="$vendor" wire:key="vendor-{{ $vendor->id }}" />
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 md:px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No vendors found') }}</p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Stacked View (below 2xl) -->
        <div class="2xl:hidden bg-white/50 backdrop-blur-sm dark:bg-gray-900/20"
             wire:key="vendors-stacked-{{ md5(($search ?? '').'|'.($statusFilter ?? '')) }}">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
                @forelse($vendors as $vendor)
                    <x-vendor-card :vendor="$vendor" :rounded="true" wire:key="vendor-card-{{ $vendor->id }}" />
                @empty
                    <div class="col-span-full p-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.25 21h19.5m-18-18v18m10.5-18v18m6-13.5V21M6.75 6.75h.75m-.75 3h.75m-.75 3h.75m3-6h.75m-.75 3h.75m-.75 3h.75M6.75 21v-3.375c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21M3 3h12m-.75 4.5H21m-3.75 3.75h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008zm0 3h.008v.008h-.008v-.008z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No vendors found') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $vendors->links() }}
        </div>
    </x-table-card>

    <!-- Vendor Modal -->
    <livewire:vendors.vendor-modal />

    <!-- Vendor Preview -->
    <livewire:vendors.vendor-preview />
</div>


