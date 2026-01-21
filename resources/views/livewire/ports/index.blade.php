<div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{
    openModal(portId = null) {
        $wire.$dispatch('open-port-modal', { portId: portId })
    },
    openPreview(portId = null) {
        $wire.$dispatch('open-port-preview', { portId: portId })
    },
    confirmDelete(portId, portName = null, warnings = null) {
        return window.confirmDelete(portId, portName, warnings);
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Ports')"
        :description="__('Manage and view ports')"
        variant="blue">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Port') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="blue">
        <div class="mb-4 flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search by port name or port address...') }}"
                    icon="magnifying-glass" />
            </div>
            <div class="w-48">
                <flux:select wire:model.live="portTypeFilter" placeholder="{{ __('All Types') }}">
                    <option value="">{{ __('All Types') }}</option>
                    <option value="Auction">{{ __('Auction') }}</option>
                    <option value="Yard">{{ __('Yard') }}</option>
                    <option value="Local Port">{{ __('Local Port') }}</option>
                    <option value="Overseas Port">{{ __('Overseas Port') }}</option>
                </flux:select>
            </div>

            @if($search || $portTypeFilter)
                <div class="flex items-center">
                    <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                        {{ __('Clear Filters') }}
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if($search || $portTypeFilter)
            <div class="mb-3 flex flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>
                @if($search)
                    <flux:badge color="violet" size="sm">{{ __('Search:') }} "{{ $search }}"</flux:badge>
                @endif
                @if($portTypeFilter)
                    <flux:badge color="blue" size="sm">{{ __('Type:') }} {{ $portTypeFilter }}</flux:badge>
                @endif
            </div>
        @endif

        <!-- Table View (2xl and above) -->
        <div class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20"
             wire:key="ports-table-{{ md5(($search ?? '').'|'.($portTypeFilter ?? '')) }}">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-16">
                            {{ __('S/N') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Port Name') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Port Type') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Port Address') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 hidden lg:table-cell">
                            {{ __('Created At') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-32">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($ports as $index => $port)
                        <x-port-table-row :port="$port" :index="$ports->firstItem() + $index" wire:key="port-{{ $port->id }}" />
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 md:px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No ports found') }}</p>
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
             wire:key="ports-stacked-{{ md5(($search ?? '').'|'.($portTypeFilter ?? '')) }}">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-4 p-4">
                @forelse($ports as $port)
                    <x-port-card :port="$port" :rounded="true" wire:key="port-card-{{ $port->id }}" />
                @empty
                    <div class="col-span-full p-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No ports found') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $ports->links() }}
        </div>
    </x-table-card>

    <!-- Port Modal -->
    <livewire:ports.port-modal />

    <!-- Port Preview -->
    <livewire:ports.port-preview />
</div>


