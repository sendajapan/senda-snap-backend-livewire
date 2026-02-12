<div class="flex h-full w-full flex-1 flex-col gap-4">
    <!-- Header Section -->
    <x-page-header :title="__('Vehicle Search History')" :description="__('View recent vehicle searches and results')"
        variant="amber">
        <x-slot:icon>
            <flux:icon.magnifying-glass class="h-7 w-7 text-white" />
        </x-slot:icon>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="amber">
        <div class="mb-4 flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <flux:input wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search by user name, email, or query...') }}" icon="magnifying-glass" />
            </div>
            @if($vendors)
                <div class="w-48">
                    <flux:select wire:model.live="vendorFilter" placeholder="{{ __('All Vendors') }}">
                        <option value="">{{ __('All Vendors') }}</option>
                        @foreach($vendors as $vendor)
                            <option value="{{ $vendor->id }}">{{ $vendor->name }}</option>
                        @endforeach
                    </flux:select>
                </div>
            @endif
            <div class="w-48">
                <flux:select wire:model.live="searchTypeFilter" placeholder="{{ __('All Search Types') }}">
                    <option value="">{{ __('All Search Types') }}</option>
                    <option value="vehicle_id">{{ __('Vehicle ID') }}</option>
                    <option value="veh_chassis_number">{{ __('Chassis Number') }}</option>
                </flux:select>
            </div>

            @if($search || $vendorFilter || $searchTypeFilter)
                <div class="flex items-center">
                    <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                        {{ __('Clear Filters') }}
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if($search || $vendorFilter || $searchTypeFilter)
            <div class="mb-3 flex flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>
                @if($search)
                    <flux:badge color="amber" size="sm">{{ __('Search:') }} "{{ $search }}"</flux:badge>
                @endif
                @if($vendorFilter)
                    <flux:badge color="amber" size="sm">{{ __('Vendor:') }}
                        {{ $vendors->firstWhere('id', $vendorFilter)?->name ?? __('Unknown') }}
                    </flux:badge>
                @endif
                @if($searchTypeFilter)
                    <flux:badge color="amber" size="sm">{{ __('Type:') }}
                        {{ $searchTypeFilter === 'vehicle_id' ? __('Vehicle ID') : __('Chassis Number') }}
                    </flux:badge>
                @endif
            </div>
        @endif

        <!-- Table View -->
        <div class="overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20"
            wire:key="vehicle-searches-table-{{ md5(($search ?? '') . '|' . ($vendorFilter ?? '') . '|' . ($searchTypeFilter ?? '')) }}">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th
                            class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-16">
                            {{ __('S/N') }}
                        </th>
                        <th
                            class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('User') }}
                        </th>
                        <th
                            class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Vendor') }}
                        </th>
                        <th
                            class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Search Method') }}
                        </th>
                        <th
                            class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Query') }}
                        </th>
                        <th
                            class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Results') }}
                        </th>
                        <th
                            class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden lg:table-cell">
                            {{ __('Search Time') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($searchLogs as $index => $searchLog)
                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-800/50 transition-colors"
                            x-data="{ expanded: false }">
                            <td class="px-3 md:px-6 py-4 text-center text-sm text-gray-900 dark:text-white">
                                {{ $searchLogs->firstItem() + $index }}
                            </td>
                            <td class="px-3 md:px-6 py-4 text-sm">
                                @if($searchLog->user)
                                    <div class="flex items-center gap-2">
                                        <div
                                            class="flex h-8 w-8 items-center justify-center rounded-full bg-amber-100 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-semibold">
                                            {{ $searchLog->user->initials() }}
                                        </div>
                                        <div>
                                            <div class="font-medium text-gray-900 dark:text-white">{{ $searchLog->user->name }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $searchLog->user->email }}
                                            </div>
                                        </div>
                                    </div>
                                @else
                                    <span class="text-gray-400 dark:text-gray-500">{{ __('System') }}</span>
                                @endif
                            </td>
                            <td class="px-3 md:px-6 py-4 text-sm text-gray-900 dark:text-white">
                                {{ $searchLog->vendor_name }}
                            </td>
                            <td class="px-3 md:px-6 py-4 text-sm">
                                <flux:badge :color="$searchLog->search_type === 'vehicle_id' ? 'blue' : 'violet'" size="sm">
                                    {{ $searchLog->search_type === 'vehicle_id' ? __('Vehicle ID') : __('Chassis Number') }}
                                </flux:badge>
                            </td>
                            <td class="px-3 md:px-6 py-4 text-sm font-mono text-gray-900 dark:text-white">
                                {{ $searchLog->search_query }}
                            </td>
                            <td class="px-3 md:px-6 py-4 text-center text-sm">
                                <button @click="expanded = !expanded"
                                    class="inline-flex items-center gap-1 rounded-lg px-3 py-1.5 text-xs font-medium transition-colors hover:bg-amber-100 dark:hover:bg-amber-900/30 text-amber-700 dark:text-amber-300">
                                    <span>{{ $searchLog->vehicles_found }} {{ __('vehicle(s)') }}</span>
                                    <svg class="h-4 w-4 transition-transform" :class="{ 'rotate-180': expanded }"
                                        fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7" />
                                    </svg>
                                </button>
                            </td>
                            <td class="px-3 md:px-6 py-4 text-sm text-gray-500 dark:text-gray-400 hidden lg:table-cell">
                                {{ $searchLog->created_at->format('M d, Y H:i') }}
                            </td>
                        </tr>
                        <!-- Expandable Vehicle Results Row -->
                        <tr x-show="expanded" x-collapse class="bg-amber-50/30 dark:bg-amber-900/10">
                            <td colspan="7" class="px-3 md:px-6 py-6">
                                <div class="space-y-4">
                                    <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                        {{ __('Vehicle Results') }} ({{ $searchLog->vehicles_found }})
                                    </div>
                                    @php
                                        $vehicles = $searchLog->vehicles;
                                    @endphp
                                    @if(!empty($vehicles))
                                        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                                            @foreach($vehicles as $vehicle)
                                                <div
                                                    class="rounded-lg border border-amber-200 dark:border-amber-800 bg-white dark:bg-gray-800 p-4 shadow-sm">
                                                    <!-- Vehicle Image -->
                                                    @if(!empty($vehicle['images']) && is_array($vehicle['images']))
                                                        <div
                                                            class="mb-3 aspect-video w-full overflow-hidden rounded-lg bg-gray-100 dark:bg-gray-700">
                                                            <img src="{{ $vehicle['images'][0] }}" alt="{{ __('Vehicle Image') }}"
                                                                class="h-full w-full object-cover" loading="lazy"
                                                                onerror="this.src='data:image/svg+xml,%3Csvg xmlns=\'http://www.w3.org/2000/svg\' width=\'400\' height=\'300\'%3E%3Crect fill=\'%23e5e7eb\' width=\'400\' height=\'300\'/%3E%3Ctext fill=\'%239ca3af\' font-family=\'sans-serif\' font-size=\'20\' dy=\'10.5\' font-weight=\'bold\' x=\'50%25\' y=\'50%25\' text-anchor=\'middle\'%3ENo Image%3C/text%3E%3C/svg%3E';" />
                                                        </div>
                                                    @else
                                                        <div
                                                            class="mb-3 aspect-video w-full flex items-center justify-center rounded-lg bg-gray-100 dark:bg-gray-700">
                                                            <svg class="h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                            </svg>
                                                        </div>
                                                    @endif

                                                    <!-- Vehicle Details -->
                                                    <div class="space-y-1.5">
                                                        <div class="text-sm font-semibold text-gray-900 dark:text-white">
                                                            {{ $vehicle['make'] ?? __('N/A') }} {{ $vehicle['model'] ?? '' }}
                                                        </div>
                                                        <div class="text-xs text-gray-600 dark:text-gray-400">
                                                            <div><strong>{{ __('Year:') }}</strong>
                                                                {{ $vehicle['veh_year'] ?? __('N/A') }}</div>
                                                            <div><strong>{{ __('Color:') }}</strong>
                                                                {{ $vehicle['veh_color'] ?? __('N/A') }}</div>
                                                            <div><strong>{{ __('Chassis:') }}</strong>
                                                                {{ $vehicle['chassis_number'] ?? __('N/A') }}</div>
                                                            @if(!empty($vehicle['vehicle_id']))
                                                                <div><strong>{{ __('Vehicle ID:') }}</strong>
                                                                    {{ $vehicle['vehicle_id'] }}</div>
                                                            @endif
                                                        </div>
                                                        @if(!empty($vehicle['veh_buy_price']))
                                                            <div class="text-xs font-medium text-amber-600 dark:text-amber-400">
                                                                {{ __('Price:') }} ${{ number_format($vehicle['veh_buy_price'], 2) }}
                                                            </div>
                                                        @endif
                                                    </div>

                                                    <!-- Additional Images Count -->
                                                    @if(!empty($vehicle['images']) && is_array($vehicle['images']) && count($vehicle['images']) > 1)
                                                        <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                                            +{{ count($vehicle['images']) - 1 }} {{ __('more image(s)') }}
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div
                                            class="rounded-lg border border-amber-200 dark:border-amber-800 bg-amber-50/50 dark:bg-amber-900/20 p-4 text-center">
                                            <p class="text-sm text-gray-600 dark:text-gray-400">
                                                {{ __('No vehicle details available') }}
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 md:px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div
                                        class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">
                                        {{ __('No search logs found') }}
                                    </p>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">
                                        {{ __('Try adjusting your search or filters') }}
                                    </p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $searchLogs->links() }}
        </div>
    </x-table-card>
</div>
