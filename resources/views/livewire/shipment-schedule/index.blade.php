<div class="flex h-full w-full flex-1 flex-col gap-4" x-data="{
    expandedSchedules: {},
    openScheduleModal(scheduleId = null) {
        $wire.$dispatch('open-schedule-modal', { scheduleId: scheduleId })
    },
    openStopoverModal(stopoverId = null, scheduleId = null) {
        $wire.$dispatch('open-stopover-modal', { stopoverId: stopoverId, scheduleId: scheduleId })
    },
    confirmDeleteSchedule(scheduleId, vesselName = null) {
        return window.confirmDelete(scheduleId, vesselName);
    },
    confirmDeleteStopover(stopoverId, portName = null) {
        return window.confirmDelete(stopoverId, portName);
    },
    toggleSchedule(scheduleId) {
        if (!this.expandedSchedules[scheduleId]) {
            this.expandedSchedules[scheduleId] = false;
        }
        this.expandedSchedules[scheduleId] = !this.expandedSchedules[scheduleId];
    },
    isExpanded(scheduleId) {
        return this.expandedSchedules[scheduleId] || false;
    }
}">
    <!-- Header Section -->
    <x-page-header
        :title="__('Shipment Schedule')"
        :description="__('Manage and view shipment schedules')"
        variant="blue">
        <x-slot:icon>
            <svg class="h-7 w-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
            </svg>
        </x-slot:icon>
        <x-slot:actions>
            <flux:button @click="openScheduleModal()" icon="plus" variant="outline" class="cursor-pointer">
                {{ __('Add New Schedule') }}
            </flux:button>
        </x-slot:actions>
    </x-page-header>

    <!-- Table Card -->
    <x-table-card variant="blue">
        <div class="mb-4 flex flex-wrap gap-4">
            <div class="flex-1 min-w-64">
                <flux:input
                    wire:model.live.debounce.300ms="search"
                    placeholder="{{ __('Search by vessel name or voyage number...') }}"
                    icon="magnifying-glass" />
            </div>
            <div class="w-48">
                <flux:input
                    wire:model.live.debounce.300ms="vesselFilter"
                    placeholder="{{ __('Filter by vessel...') }}" />
            </div>
            <div class="w-48">
                <flux:input
                    wire:model.live.debounce.300ms="voyageFilter"
                    placeholder="{{ __('Filter by voyage...') }}" />
            </div>
            <div class="w-48">
                <flux:select wire:model.live="carrierFilter" placeholder="{{ __('All Carriers') }}">
                    <option value="">{{ __('All Carriers') }}</option>
                    @foreach($providers as $provider)
                        <option value="{{ $provider->id }}">{{ $provider->line_name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="startPortFilter" placeholder="{{ __('All Start Ports') }}">
                    <option value="">{{ __('All Start Ports') }}</option>
                    @foreach($localPorts as $port)
                        <option value="{{ $port->id }}">{{ $port->port_name }}</option>
                    @endforeach
                </flux:select>
            </div>
            <div class="w-48">
                <flux:select wire:model.live="endPortFilter" placeholder="{{ __('All End Ports') }}">
                    <option value="">{{ __('All End Ports') }}</option>
                    @foreach($localPorts as $port)
                        <option value="{{ $port->id }}">{{ $port->port_name }}</option>
                    @endforeach
                </flux:select>
            </div>

            @if($search || $vesselFilter || $voyageFilter || $carrierFilter || $startPortFilter || $endPortFilter)
                <div class="flex items-center">
                    <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                        {{ __('Clear Filters') }}
                    </flux:button>
                </div>
            @endif
        </div>

        <!-- Active Filters Display -->
        @if($search || $vesselFilter || $voyageFilter || $carrierFilter || $startPortFilter || $endPortFilter)
            <div class="mb-3 flex flex-wrap gap-2">
                <span class="text-sm font-medium text-gray-700 dark:text-gray-300">{{ __('Active Filters:') }}</span>
                @if($search)
                    <flux:badge color="violet" size="sm">{{ __('Search:') }} "{{ $search }}"</flux:badge>
                @endif
                @if($vesselFilter)
                    <flux:badge color="blue" size="sm">{{ __('Vessel:') }} {{ $vesselFilter }}</flux:badge>
                @endif
                @if($voyageFilter)
                    <flux:badge color="blue" size="sm">{{ __('Voyage:') }} {{ $voyageFilter }}</flux:badge>
                @endif
                @if($carrierFilter)
                    @php
                        $carrier = $providers->firstWhere('id', $carrierFilter);
                    @endphp
                    @if($carrier)
                        <flux:badge color="blue" size="sm">{{ __('Carrier:') }} {{ $carrier->line_name }}</flux:badge>
                    @endif
                @endif
                @if($startPortFilter)
                    @php
                        $port = $localPorts->firstWhere('id', $startPortFilter);
                    @endphp
                    @if($port)
                        <flux:badge color="blue" size="sm">{{ __('Start Port:') }} {{ $port->port_name }}</flux:badge>
                    @endif
                @endif
                @if($endPortFilter)
                    @php
                        $port = $localPorts->firstWhere('id', $endPortFilter);
                    @endphp
                    @if($port)
                        <flux:badge color="blue" size="sm">{{ __('End Port:') }} {{ $port->port_name }}</flux:badge>
                    @endif
                @endif
            </div>
        @endif

        <!-- Table View (2xl and above) -->
        <div class="hidden 2xl:block overflow-x-auto border rounded-xl bg-white/50 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-900/20"
             wire:key="schedules-table-{{ md5(($search ?? '').'|'.($vesselFilter ?? '').'|'.($voyageFilter ?? '').'|'.($carrierFilter ?? '').'|'.($startPortFilter ?? '').'|'.($endPortFilter ?? '')) }}">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-900">
                        <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-16">
                            {{ __('S/N') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-12">
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Vessel / Voyage') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Carriers') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('Route') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-left text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300">
                            {{ __('ETA') }}
                        </th>
                        <th class="px-3 md:px-6 py-3 md:py-4 text-center text-xs font-bold uppercase tracking-wider text-gray-700 dark:text-gray-300 w-32">
                            {{ __('Actions') }}
                        </th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                    @forelse($schedules as $index => $schedule)
                        <tr class="group transition-all duration-200 hover:bg-gradient-to-r hover:from-blue-50/50 hover:to-teal-50/50 dark:hover:from-blue-900/10 dark:hover:to-teal-900/10">
                            <!-- S/N -->
                            <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 text-center">
                                <span class="text-xs md:text-sm font-semibold text-gray-600 dark:text-gray-400">{{ $schedules->firstItem() + $index }}</span>
                            </td>
                            <!-- Expand/Collapse Button -->
                            <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
                                <button @click="toggleSchedule({{ $schedule->id }})" type="button" class="flex items-center justify-center rounded-lg p-1.5 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300">
                                    <svg class="h-5 w-5 transition-transform duration-200" :class="{ 'rotate-90': isExpanded({{ $schedule->id }}) }" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </td>

                            <!-- Vessel / Voyage -->
                            <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
                                <div class="flex items-center">
                                    <div class="flex h-10 md:h-12 w-10 md:w-12 items-center justify-center rounded-xl bg-blue-400/20 shadow-lg ring-2 ring-blue-300 dark:ring-blue-800 flex-shrink-0">
                                        <svg class="h-5 md:h-6 w-5 md:w-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                        </svg>
                                    </div>
                                    <div class="ml-2 md:ml-4">
                                        <div class="text-xs md:text-sm font-bold text-gray-900 dark:text-white">
                                            {{ $schedule->vessel_name }}
                                        </div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ __('Voyage:') }} {{ $schedule->voyage_no }}
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Carriers -->
                            <td class="px-3 md:px-6 py-3 md:py-5">
                                <div class="flex flex-wrap gap-1.5">
                                    @if($schedule->carrier1)
                                        <flux:badge color="blue" size="sm" class="text-xs whitespace-normal break-words">{{ $schedule->carrier1->line_name }}</flux:badge>
                                        @endif
                                        @if($schedule->carrier2)
                                        <flux:badge color="cyan" size="sm" class="text-xs whitespace-normal break-words">{{ $schedule->carrier2->line_name }}</flux:badge>
                                        @endif
                                        @if($schedule->carrier3)
                                        <flux:badge color="teal" size="sm" class="text-xs whitespace-normal break-words">{{ $schedule->carrier3->line_name }}</flux:badge>
                                    @endif
                                    @if(!$schedule->carrier1 && !$schedule->carrier2 && !$schedule->carrier3)
                                        <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('No carriers') }}</span>
                                    @endif
                                </div>
                            </td>

                            <!-- Route -->
                            <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
                                <div class="flex items-center gap-2">
                                    <div class="flex flex-col">
                                        <span class="text-xs md:text-sm font-semibold text-gray-900 dark:text-white">{{ $schedule->startPort->port_name ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Dep Port') }}</span>
                                    </div>
                                    <svg class="h-4 w-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                    </svg>
                                    <div class="flex flex-col">
                                        <span class="text-xs md:text-sm font-semibold text-gray-900 dark:text-white">{{ $schedule->endPort->port_name ?? 'N/A' }}</span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">{{ __('Arrival Port') }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- ETA -->
                            <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5">
                                <div class="flex items-center gap-1.5">
                                    <svg class="h-4 w-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    <span class="text-xs md:text-sm text-gray-900 dark:text-white">{{ $schedule->eta ? $schedule->eta->format('M d, Y') : 'N/A' }}</span>
                                </div>
                            </td>

                            <!-- Actions -->
                            <td class="whitespace-nowrap px-3 md:px-6 py-3 md:py-5 w-32">
                                <div class="flex justify-center items-center gap-1.5 md:gap-2">
                                    @php
                                        $currentUser = auth()->user();
                                        $canDelete = $currentUser && in_array($currentUser->role, ['admin', 'manager']);
                                    @endphp

                                    <!-- Edit Button -->
                                    <button @click="openScheduleModal({{ $schedule->id }})" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 transition-all duration-200 hover:border-cyan-700 hover:bg-cyan-500/20 hover:shadow-lg hover:shadow-cyan-700/30" title="{{ __('Edit Schedule') }}">
                                        <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-cyan-700 transition-all duration-200 group-hover:text-cyan-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                        </svg>
                                    </button>

                                    <!-- Delete Button -->
                                    @if($canDelete)
                                        <button @click="confirmDeleteSchedule({{ $schedule->id }}, '{{ addslashes($schedule->vessel_name) }}').then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-schedule', { scheduleId: {{ $schedule->id }} }) } })" type="button" class="group relative flex items-center justify-center rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 transition-all duration-200 hover:border-red-700 hover:bg-red-500/20 hover:shadow-lg hover:shadow-red-700/30" title="{{ __('Delete Schedule') }}">
                                            <svg class="h-3.5 w-3.5 md:h-4 md:w-4 text-red-700 transition-all duration-200 group-hover:text-red-600" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                            </svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>

                        <!-- Expandable Stopovers Row -->
                        <tr x-show="isExpanded({{ $schedule->id }})" x-collapse class="bg-gray-50/50 dark:bg-gray-800/30">
                            <td colspan="6" class="px-3 md:px-6 py-4">
                                <div class="ml-8 md:ml-12 border-l-2 border-blue-300 dark:border-blue-700 pl-4 md:pl-6">
                                    <div class="flex items-center justify-between mb-3">
                                        <div class="flex items-center gap-2">
                                            <svg class="h-5 w-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                            </svg>
                                            <h4 class="text-sm font-bold text-gray-900 dark:text-white">{{ __('Stopovers') }}</h4>
                                        </div>
                                        @if($schedule->stopovers->count() === 0)
                                            <flux:button @click="openStopoverModal(null, {{ $schedule->id }})" size="sm" variant="outline" icon="plus">
                                                {{ __('Add Stopover') }}
                                            </flux:button>
                                        @endif
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                            <thead>
                                                <tr class="bg-gray-100/50 dark:bg-gray-700/50">
                                                    <th class="px-3 py-2 text-left text-xs font-semibold uppercase text-gray-700 dark:text-gray-300">{{ __('Port') }}</th>
                                                    <th class="px-3 py-2 text-left text-xs font-semibold uppercase text-gray-700 dark:text-gray-300">{{ __('Arrival (ETA)') }}</th>
                                                    <th class="px-3 py-2 text-left text-xs font-semibold uppercase text-gray-700 dark:text-gray-300">{{ __('Departure (ETD)') }}</th>
                                                    <th class="px-3 py-2 text-center text-xs font-semibold uppercase text-gray-700 dark:text-gray-300">{{ __('Actions') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200/50 dark:divide-gray-700/50">
                                                @forelse($schedule->stopovers as $stopover)
                                                    <tr class="hover:bg-gray-100/50 dark:hover:bg-gray-700/30">
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="h-4 w-4 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                </svg>
                                                                <span class="text-xs md:text-sm text-gray-900 dark:text-white">{{ $stopover->port->port_name ?? 'N/A' }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            @if($stopover->stopover_eta)
                                                                <div class="flex items-center gap-1.5">
                                                                    <svg class="h-4 w-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    <span class="text-xs md:text-sm text-gray-900 dark:text-white">{{ $stopover->stopover_eta->format('M d, Y') }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Not set') }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            @if($stopover->stopover_etd)
                                                                <div class="flex items-center gap-1.5">
                                                                    <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                                    </svg>
                                                                    <span class="text-xs md:text-sm text-gray-900 dark:text-white">{{ $stopover->stopover_etd->format('M d, Y') }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Not set') }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <div class="flex justify-center items-center gap-1.5">
                                                                <button @click="openStopoverModal({{ $stopover->id }}, {{ $schedule->id }})" type="button" class="rounded-lg border-2 border-cyan-700/60 bg-cyan-500/10 p-1.5 text-cyan-700 transition-all hover:bg-cyan-500/20" title="{{ __('Edit Stopover') }}">
                                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                    </svg>
                                                                </button>
                                                                @if($canDelete)
                                                                    <button @click="confirmDeleteStopover({{ $stopover->id }}, '{{ addslashes($stopover->port->port_name ?? 'N/A') }}').then((result) => { if (result.isConfirmed) { $wire.$dispatch('delete-stopover', { stopoverId: {{ $stopover->id }} }) } })" type="button" class="rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 text-red-700 transition-all hover:bg-red-500/20" title="{{ __('Delete Stopover') }}">
                                                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                        </svg>
                                                                    </button>
                                                                @endif
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="4" class="px-3 py-6 text-center">
                                                            <div class="flex flex-col items-center gap-3">
                                                                <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No stopovers added yet') }}</p>
                                                                <flux:button @click="openStopoverModal(null, {{ $schedule->id }})" size="sm" variant="outline" icon="plus">
                                                                    {{ __('Add Stopover') }}
                                                                </flux:button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-3 md:px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                        <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                        </svg>
                                    </div>
                                    <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No schedules found') }}</p>
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
             wire:key="schedules-stacked-{{ md5(($search ?? '').'|'.($vesselFilter ?? '').'|'.($voyageFilter ?? '')) }}">
            <div class="grid grid-cols-1 gap-4 p-4">
                @forelse($schedules as $schedule)
                    <div class="rounded-xl border border-blue-200 bg-white/50 p-4 shadow-md shadow-blue-100/50 dark:border-blue-900/50 dark:bg-gray-800/50 dark:shadow-blue-900/20">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex items-center gap-3">
                                <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-blue-400/20">
                                    <svg class="h-5 w-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-gray-900 dark:text-white">{{ $schedule->vessel_name }}</h3>
                                    <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Voyage:') }} {{ $schedule->voyage_no }}</p>
                                </div>
                            </div>
                            <div class="flex gap-1">
                                <button @click="openScheduleModal({{ $schedule->id }})" class="rounded-lg p-1.5 text-cyan-700 hover:bg-cyan-500/10">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                        <div class="space-y-2 text-xs">
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Route:') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $schedule->startPort->port_name ?? 'N/A' }} → {{ $schedule->endPort->port_name ?? 'N/A' }}</span>
                            </div>
                            <div>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">{{ __('ETA:') }}</span>
                                <span class="text-gray-900 dark:text-white">{{ $schedule->eta ? $schedule->eta->format('M d, Y') : 'N/A' }}</span>
                            </div>
                            @if($schedule->stopovers->count() > 0)
                                <div>
                                    <span class="font-semibold text-gray-700 dark:text-gray-300">{{ __('Stopovers:') }}</span>
                                    <span class="text-gray-900 dark:text-white">{{ $schedule->stopovers->count() }}</span>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="col-span-full p-12 text-center">
                        <div class="flex flex-col items-center gap-3">
                            <div class="flex h-16 w-16 items-center justify-center rounded-full bg-gray-100 dark:bg-gray-800">
                                <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <p class="text-sm font-medium text-gray-900 dark:text-white">{{ __('No schedules found') }}</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">{{ __('Try adjusting your search or filters') }}</p>
                        </div>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </x-table-card>

    <!-- Schedule Modal -->
    <livewire:shipment-schedule.schedule-modal />

    <!-- Stopover Modal -->
    <livewire:shipment-schedule.stopover-modal />
</div>
