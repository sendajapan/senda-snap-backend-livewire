<div
    class="flex flex-1 flex-col gap-4 pb-24 md:pb-0 pl-[max(1.5rem,env(safe-area-inset-left))] pr-[max(1.5rem,env(safe-area-inset-right))] sm:px-4 md:px-6 lg:px-8"
    data-creator-name="{{ auth()->check() ? '' : e($creatorName ?? '') }}"
    x-data="{
        expandedSchedules: {},
        get livewire() {
            const el = this.$el?.closest('[wire\\:id]');
            return el && typeof Livewire !== 'undefined' ? Livewire.find(el.getAttribute('wire:id')) : null;
        },
        openScheduleModal(scheduleId = null) {
            const wire = this.livewire;
            if (!wire) return;
            const creatorName = (this.$el?.getAttribute('data-creator-name') || '').trim() || null;
            wire.openScheduleModalForPublic(scheduleId ?? null, creatorName);
        },
        toggleSchedule(scheduleId) {
            if (this.expandedSchedules[scheduleId] === undefined) this.expandedSchedules[scheduleId] = false;
            this.expandedSchedules[scheduleId] = !this.expandedSchedules[scheduleId];
        },
        isExpanded(scheduleId) {
            return !!this.expandedSchedules[scheduleId];
        },
        confirmDeleteSchedule(scheduleId, vesselName, warnings) {
            return typeof window.confirmDelete === 'function'
                ? window.confirmDelete(scheduleId, vesselName, warnings)
                : Promise.resolve({ isConfirmed: confirm('Delete this schedule?') });
        },
        confirmDeleteStopover(stopoverId, portName = null) {
            return typeof window.confirmDelete === 'function'
                ? window.confirmDelete(stopoverId, portName)
                : Promise.resolve({ isConfirmed: confirm('Delete this stopover?') });
        }
    }"
    @add-schedule.window="openScheduleModal()">
    <div class="mx-auto w-full max-w-[1920px] flex flex-1 flex-col gap-4 text-sm">
    <x-page-header
        :title="__('Public Shipment Schedule')"
        :description="__('View and add vessel schedules. Anyone can contribute; schedules are visible to all.')"
        variant="gray">
        <x-slot:icon>
            <flux:icon.paper-airplane class="h-7 w-7 text-white" />
        </x-slot:icon>
        <x-slot:actions>
            <div class="flex flex-wrap items-center gap-2">
                <flux:button href="{{ $exportUrl }}" icon="arrow-down-tray" variant="outline" class="cursor-pointer text-green-600 hover:text-green-700 hover:border-green-500 dark:text-green-400 dark:hover:text-green-300 [&_svg]:text-green-600 dark:[&_svg]:text-green-400">
                    {{ __('Export Excel') }}
                </flux:button>
                <flux:button href="{{ route('shipment-schedule.public.import') }}" icon="arrow-up-tray" variant="outline" class="cursor-pointer text-gray-800 hover:text-gray-900 dark:text-gray-200 dark:hover:text-white [&_svg]:text-gray-700 dark:[&_svg]:text-gray-300" wire:navigate>
                    {{ __('Import Excel') }}
                </flux:button>
                <span class="hidden md:inline-block">
                    <flux:button @click="openScheduleModal()" icon="plus" variant="outline" class="cursor-pointer">
                        {{ __('Add Schedule') }}
                    </flux:button>
                </span>
            </div>
        </x-slot:actions>
    </x-page-header>

    @if($creatorName)
        <div class="border-l-4 border-gray-500 bg-gray-50 px-3 py-2.5 sm:px-4 dark:border-gray-600 dark:bg-gray-800/50">
            <p class="text-sm text-gray-700 dark:text-gray-300">
                {{ __('Schedules you add will be listed as created by :name.', ['name' => $creatorName]) }}
            </p>
        </div>
    @endif

    <x-table-card variant="gray">
        {{-- Filters: one per row on mobile, multiple on larger screens --}}
        <div class="mb-4">
            <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6">
                <div class="sm:col-span-2 lg:col-span-1 xl:col-span-2">
                    <flux:input
                        wire:model.live.debounce.300ms="search"
                        placeholder="{{ __('Search vessel or voyage...') }}"
                        icon="magnifying-glass" />
                </div>
                <div>
                    <flux:input
                        wire:model.live.debounce.300ms="vesselFilter"
                        placeholder="{{ __('Vessel') }}" />
                </div>
                <div>
                    <flux:input
                        wire:model.live.debounce.300ms="voyageFilter"
                        placeholder="{{ __('Voyage') }}" />
                </div>
                <div>
                    <flux:select wire:model.live="carrierFilter" placeholder="{{ __('Carrier') }}">
                        <option value="">{{ __('All Carriers') }}</option>
                        @foreach($providers as $provider)
                            <option value="{{ $provider->id }}">{{ $provider->line_name }}</option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="startPortFilter" placeholder="{{ __('From port') }}">
                        <option value="">{{ __('All') }}</option>
                        @foreach($localPorts as $port)
                            <option value="{{ $port->id }}">{{ $port->port_name }}</option>
                        @endforeach
                    </flux:select>
                </div>
                <div>
                    <flux:select wire:model.live="endPortFilter" placeholder="{{ __('To port') }}">
                        <option value="">{{ __('All') }}</option>
                        @foreach($localPorts as $port)
                            <option value="{{ $port->id }}">{{ $port->port_name }}</option>
                        @endforeach
                    </flux:select>
                </div>
            </div>
            @if($search || $vesselFilter || $voyageFilter || $carrierFilter || $startPortFilter || $endPortFilter)
                <div class="mt-3 flex items-center">
                    <flux:button wire:click="clearFilters" variant="ghost" size="sm" icon="x-mark">
                        {{ __('Clear filters') }}
                    </flux:button>
                </div>
            @endif
        </div>

        <div
            class="hidden overflow-x-auto rounded-lg border border-gray-200 bg-white md:block dark:border-gray-700 dark:bg-gray-900/30"
            wire:key="public-schedules-table-{{ md5(($search ?? '') . '|' . ($vesselFilter ?? '') . '|' . ($voyageFilter ?? '') . '|' . ($carrierFilter ?? '') . '|' . ($startPortFilter ?? '') . '|' . ($endPortFilter ?? '')) }}">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead>
                    <tr class="bg-gray-50 dark:bg-gray-800/80">
                        <th class="w-14 border-r border-gray-200 px-3 py-2.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-600 dark:text-gray-400">{{ __('#') }}</th>
                        <th class="w-10 px-1 py-2.5"></th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Vessel / Voyage') }}</th>
                        <th class="px-3 py-2.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Stopovers') }}</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Carriers') }}</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Route') }}</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('ETA') }}</th>
                        <th class="px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Created by') }}</th>
                        <th class="whitespace-nowrap px-3 py-2.5 text-left text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Created at') }} / {{ __('Updated at') }}</th>
                        <th class="whitespace-nowrap px-3 py-2.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400 border-l border-gray-200 dark:border-gray-600">{{ __('Preview') }}</th>
                        <th class="w-28 min-w-[8rem] border-l border-gray-200 px-3 py-2.5 text-center text-xs font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-600 dark:text-gray-400">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($schedules as $index => $schedule)
                        <tr
                            wire:key="public-schedule-row-{{ $schedule->id }}"
                            class="group hover:bg-gray-50 dark:hover:bg-gray-800/50 transition-colors duration-150"
                            :class="{ '!bg-blue-50 dark:!bg-blue-900/30': isExpanded({{ $schedule->id }}) }">
                            <td class="whitespace-nowrap border-r border-gray-200 px-3 py-2.5 text-center text-xs text-gray-500 dark:border-gray-600 dark:text-gray-400">
                                {{ $schedules->firstItem() + $index }}
                            </td>
                            <td class="whitespace-nowrap px-1 py-2.5 text-center">
                                @if($schedule->stopovers->isNotEmpty())
                                    <button
                                        type="button"
                                        @click="toggleSchedule({{ $schedule->id }})"
                                        aria-label="{{ __('Toggle stopovers') }}"
                                        aria-expanded="false"
                                        class="cursor-pointer rounded p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900">
                                        <svg class="h-5 w-5 transition-transform" :class="{ 'rotate-90': isExpanded({{ $schedule->id }}) }" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-200 dark:bg-gray-700">
                                        <img src="{{ asset('assets/images/icons/shipping.png') }}" class="h-5 w-5" alt="Shipping">
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-xs font-semibold text-gray-900 dark:text-white truncate">{{ $schedule->vessel_name }}</div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400">{{ __('Voyage') }} {{ $schedule->voyage_no }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-center text-xs text-gray-700 dark:text-gray-300">
                                {{ $schedule->stopovers->count() }}
                            </td>
                            <td class="px-3 py-2.5">
                                <div class="flex flex-wrap gap-1">
                                    @if($schedule->carrier1)
                                        <flux:badge color="gray" size="sm" class="text-xs">{{ $schedule->carrier1->line_name }}</flux:badge>
                                    @endif
                                    @if($schedule->carrier2)
                                        <flux:badge color="gray" size="sm" class="text-xs">{{ $schedule->carrier2->line_name }}</flux:badge>
                                    @endif
                                    @if($schedule->carrier3)
                                        <flux:badge color="gray" size="sm" class="text-xs">{{ $schedule->carrier3->line_name }}</flux:badge>
                                    @endif
                                    @if(!$schedule->carrier1 && !$schedule->carrier2 && !$schedule->carrier3)
                                        <span class="text-xs text-gray-400 dark:text-gray-500">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-xs text-gray-700 dark:text-gray-300">
                                <span>{{ $schedule->startPort->port_name ?? '—' }}</span>
                                <span class="mx-1 text-gray-400">→</span>
                                <span>{{ $schedule->endPort->port_name ?? '—' }}</span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-xs text-gray-700 dark:text-gray-300">
                                {{ $schedule->eta ? $schedule->eta->format('M d, Y') : '—' }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-xs text-gray-700 dark:text-gray-300">
                                {{ $schedule->creatorDisplayName() }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-xs text-gray-600 dark:text-gray-400">
                                <div class="flex flex-col gap-0.5">
                                    <span>{{ $schedule->created_at ? $schedule->created_at->format('M d, Y H:i') : '—' }}</span>
                                    <span class="text-gray-500 dark:text-gray-500">{{ $schedule->updated_at ? $schedule->updated_at->format('M d, Y H:i') : '—' }}</span>
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-center text-xs border-l border-gray-200 dark:border-gray-600">
                                <div class="flex items-center justify-center">
                                    <button
                                        type="button"
                                        wire:click="previewSchedule({{ $schedule->id }})"
                                        title="{{ __('Preview Route') }}"
                                        class="flex items-center gap-1 cursor-pointer rounded border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900">
                                        <img src="{{ asset('assets/images/icons/route.png') }}" class="h-3.5 w-3.5" alt="Route">
                                        <span>{{ __('Preview') }}</span>
                                    </button>
                                </div>
                            </td>
                            <td class="min-w-[8rem] whitespace-nowrap border-l border-gray-200 px-3 py-2.5 text-center dark:border-gray-600">
                                @php
                                    $isCreator = auth()->check() && $schedule->added_by === auth()->id();
                                    $guestName = trim((string) ($creatorName ?? ''));
                                    $scheduleGuestName = $schedule->added_by_name ? trim((string) $schedule->added_by_name) : '';
                                    $isCreatorGuest = !auth()->check() && $schedule->is_public && $scheduleGuestName !== '' && $scheduleGuestName === $guestName;
                                    $canDelete = $isCreator || $isCreatorGuest;
                                    $stopoverCount = $schedule->stopovers()->count();
                                    $warnings = $stopoverCount > 0 ? [__(':count stopover(s)', ['count' => $stopoverCount])] : [];
                                @endphp
                                <div class="flex flex-nowrap items-center justify-center gap-1">
                                    <button
                                        type="button"
                                        @click="openScheduleModal({{ $schedule->id }})"
                                        title="{{ __('Edit') }}"
                                        aria-label="{{ __('Edit schedule') }}"
                                        class="flex items-center gap-1 cursor-pointer rounded border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-gray-700 hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-800 dark:text-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                        <span>{{ __('Edit') }}</span>
                                    </button>
                                        <button
                                            type="button"
                                            @click="confirmDeleteSchedule({{ $schedule->id }}, '{{ addslashes($schedule->vessel_name) }}', @js($warnings)).then((r) => { if (r && r.isConfirmed) $wire.$dispatch('delete-schedule', { scheduleId: {{ $schedule->id }} }) })"
                                            title="{{ __('Delete') }}"
                                            aria-label="{{ __('Delete schedule') }}"
                                            @if(!$canDelete) disabled @endif
                                            class="flex items-center gap-1 cursor-pointer rounded border border-gray-300 bg-white px-2 py-1 text-xs font-medium text-red-600 hover:bg-red-50 hover:border-red-300 dark:border-gray-600 dark:bg-gray-800 dark:text-red-400 dark:hover:bg-red-900/20 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-white disabled:hover:text-gray-500 disabled:hover:border-gray-300">
                                        <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span>{{ __('Delete') }}</span>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr
                            wire:key="public-schedule-expand-{{ $schedule->id }}">
                            <td colspan="11" class="px-0 py-0">
                                <div class="w-full bg-blue-50 dark:bg-blue-900/30 overflow-hidden text-sm transition-all duration-1000 ease-in-out"
                                     :style="'max-height: ' + (isExpanded({{ $schedule->id }}) ? '2000px' : '0px') + '; opacity: ' + (isExpanded({{ $schedule->id }}) ? '1' : '0')">
                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                            <thead>
                                                <tr class="bg-blue-100/50 dark:bg-blue-800/50">
                                                    <th class="w-8 px-0 py-2"></th> {{-- Timeline column --}}
                                                    <th class="w-12 border-r border-gray-200 px-3 py-2 text-center text-xs font-semibold uppercase tracking-wider text-blue-500 dark:border-gray-600 dark:text-blue-400">{{ __('#') }}</th>
                                                    <th class="px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-blue-500 dark:text-blue-400">
                                                        {{ __('Port') }}
                                                    </th>
                                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-blue-500 dark:text-blue-400">{{ __('ETA') }}</th>
                                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-blue-500 dark:text-blue-400">{{ __('ETD') }}</th>
                                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-blue-500 dark:text-blue-400">{{ __('Created at') }}</th>
                                                    <th class="whitespace-nowrap px-3 py-2 text-left text-xs font-semibold uppercase tracking-wider text-blue-500 dark:text-blue-400">{{ __('Updated at') }}</th>
                                                    <th class="w-24 border-l border-gray-200 px-3 py-2 text-center text-xs font-semibold uppercase tracking-wider text-blue-500 dark:border-gray-600 dark:text-blue-400">{{ __('Action') }}</th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                                @forelse($schedule->stopovers as $stopoverIndex => $stopover)
                                                    @php $canDeleteStopover = ($isCreator ?? false) || ($isCreatorGuest ?? false); @endphp
                                                    <tr class="bg-transparent dark:bg-gray-800/20">
                                                        <td class="relative w-8 px-0 py-0 text-center align-middle !border-0">
                                                            {{-- Timeline dashed line (Top half) --}}
                                                            @if(!$loop->first)
                                                                <div class="absolute top-0 left-1/2 -ml-px h-1/2 w-px border-l-2 border-dashed border-gray-400 dark:border-gray-500"></div>
                                                            @endif
                                                            {{-- Timeline dashed line (Bottom half) --}}
                                                            @if(!$loop->last)
                                                                <div class="absolute bottom-0 left-1/2 -ml-px h-1/2 w-px border-l-2 border-dashed border-gray-400 dark:border-gray-500"></div>
                                                            @endif
                                                            {{-- Timeline circle --}}
                                                            <div class="relative z-10 inline-block h-3 w-3 rounded-full border-2 border-white bg-blue-500 ring-2 ring-gray-100 dark:border-gray-800 dark:ring-gray-700"></div>
                                                        </td>
                                                        <td class="whitespace-nowrap border-l border-r border-gray-200 px-3 py-2 text-center text-xs text-gray-500 dark:border-gray-600 dark:text-gray-400">{{ $stopoverIndex + 1 }}</td>
                                                        <td class="whitespace-nowrap px-3 py-2 text-xs text-gray-900 dark:text-white">
                                                            <div class="flex items-center gap-1.5">
                                                                <img src="{{ asset('assets/images/icons/port.png') }}" class="h-3.5 w-3.5" alt="Port">
                                                                <span>{{ $stopover->port->port_name ?? '—' }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="whitespace-nowrap px-3 py-2 text-xs text-gray-600 dark:text-gray-400">{{ $stopover->stopover_eta ? $stopover->stopover_eta->format('M d, Y') : '—' }}</td>
                                                        <td class="whitespace-nowrap px-3 py-2 text-xs text-gray-600 dark:text-gray-400">{{ $stopover->stopover_etd ? $stopover->stopover_etd->format('M d, Y') : '—' }}</td>
                                                        <td class="whitespace-nowrap px-3 py-2 text-xs text-gray-600 dark:text-gray-400">{{ $stopover->created_at ? $stopover->created_at->format('M d, Y H:i') : '—' }}</td>
                                                        <td class="whitespace-nowrap px-3 py-2 text-xs text-gray-600 dark:text-gray-400">{{ $stopover->updated_at ? $stopover->updated_at->format('M d, Y H:i') : '—' }}</td>
                                                        <td class="whitespace-nowrap border-l border-gray-200 px-3 py-2 text-center dark:border-gray-600">
                                                            <div class="flex items-center justify-center gap-2">
                                                                <button
                                                                    type="button"
                                                                    @click="openScheduleModal({{ $schedule->id }})"
                                                                    title="{{ __('Edit') }}"
                                                                    class="flex items-center justify-center rounded-md border border-amber-300 bg-amber-50 p-1 text-amber-600 hover:bg-amber-100 focus:outline-none focus:ring-2 focus:ring-amber-500 dark:border-amber-700 dark:bg-amber-900/20 dark:text-amber-500 dark:hover:bg-amber-900/40">
                                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                                                </button>
                                                                <button
                                                                    type="button"
                                                                    @click="confirmDeleteStopover({{ $stopover->id }}, '{{ addslashes($stopover->port->port_name ?? 'N/A') }}').then((r) => { if (r && r.isConfirmed) $wire.$dispatch('delete-stopover', { stopoverId: {{ $stopover->id }} }) })"
                                                                    title="{{ __('Delete') }}"
                                                                    @if(!$canDeleteStopover) disabled @endif
                                                                    class="flex items-center justify-center rounded-md border border-red-300 bg-red-50 p-1 text-red-600 hover:bg-red-100 focus:outline-none focus:ring-2 focus:ring-red-500 dark:border-red-700 dark:bg-red-900/20 dark:text-red-500 dark:hover:bg-red-900/40 disabled:opacity-50 disabled:cursor-not-allowed">
                                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td colspan="8" class="px-3 py-4 text-center text-xs text-gray-500 dark:text-gray-400">{{ __('No stopovers') }}</td>
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
                            <td colspan="10" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center gap-3">
                                    <flux:icon.paper-airplane class="h-10 w-10 text-gray-300 dark:text-gray-600 [&_svg]:size-[1em]" />
                                    <div>
                                        <p class="text-sm font-semibold text-gray-900 dark:text-white">{{ __('No schedules yet') }}</p>
                                        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400 hidden md:block">{{ __('Add the first schedule using the button above.') }}</p>
                                        <p class="mt-0.5 text-sm text-gray-500 dark:text-gray-400 md:hidden">{{ __('Tap the + button below to add.') }}</p>
                                    </div>
                                    <flux:button @click="openScheduleModal()" variant="outline" icon="plus" size="sm" class="hidden md:inline-flex">
                                        {{ __('Add Schedule') }}
                                    </flux:button>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="space-y-3 md:hidden">
            @forelse($schedules as $schedule)
                <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800/50">
                    <div class="flex items-start justify-between gap-3">
                        <div class="min-w-0 flex-1">
                            <h3 class="text-sm md:text-base font-medium text-gray-900 dark:text-white truncate">{{ $schedule->vessel_name }}</h3>
                            <p class="text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ __('Voyage') }} {{ $schedule->voyage_no }}</p>
                            <p class="mt-1 text-sm md:text-base text-gray-700 dark:text-gray-300">{{ $schedule->startPort->port_name ?? '—' }} → {{ $schedule->endPort->port_name ?? '—' }}</p>
                            <p class="mt-0.5 text-xs sm:text-sm text-gray-500 dark:text-gray-400">{{ $schedule->eta ? $schedule->eta->format('M d, Y') : '—' }} · {{ $schedule->creatorDisplayName() }}</p>
                        </div>
                        @if(auth()->check() && $schedule->added_by === auth()->id())
                            <button
                                type="button"
                                @click="openScheduleModal({{ $schedule->id }})"
                                aria-label="{{ __('Edit') }}"
                                class="shrink-0 rounded p-2 text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                            </button>
                        @endif
                    </div>
                </div>
            @empty
                <div class="rounded-lg border border-dashed border-gray-300 bg-gray-50 px-4 py-10 text-center sm:px-6 dark:border-gray-600 dark:bg-gray-800/30">
                    <p class="text-sm md:text-base text-gray-600 dark:text-gray-400">{{ __('No public schedules yet') }}</p>
                    <p class="mt-1 text-xs text-gray-500 md:hidden">{{ __('Tap + below to add.') }}</p>
                    <flux:button @click="openScheduleModal()" variant="outline" size="sm" class="mt-3 hidden md:inline-flex">{{ __('Add Schedule') }}</flux:button>
                </div>
            @endforelse
        </div>

        <div class="mt-4">
            {{ $schedules->links() }}
        </div>
    </x-table-card>

    </div>{{-- /max-w-[1920px] --}}

    {{-- Floating action button: teleported to body; on mobile slides down when modal opens, slides up when modal closes --}}
    @teleport('body')
    <div
        x-data="{ modalOpen: false }"
        @schedule-modal-opened.window="modalOpen = true"
        @schedule-modal-closed.window="modalOpen = false"
        class="fixed z-[100] md:hidden transition-transform duration-300 ease-out"
        style="right: max(1.5rem, env(safe-area-inset-right)); bottom: max(1.5rem, env(safe-area-inset-bottom));"
        :class="{ 'translate-y-full opacity-0 pointer-events-none': modalOpen }">
        <button
            type="button"
            @click="$dispatch('add-schedule')"
            aria-label="{{ __('Add Schedule') }}"
            class="flex h-14 w-14 min-w-[3.5rem] min-h-[3.5rem] shrink-0 items-center justify-center rounded-full bg-gray-700 text-white shadow-lg shadow-gray-900/25 transition hover:bg-gray-600 active:scale-95 dark:bg-gray-600 dark:hover:bg-gray-500 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-900 p-3 box-border">
            <svg class="size-6 shrink-0" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v12m6-6H6" />
            </svg>
        </button>
    </div>
    @endteleport

    <livewire:shipment-schedule.schedule-modal />
    
    @php
        $previewModalW = 1080;
        $previewCardW = 220;
        $previewCardH = 116;
        $previewGap = 40;
        $previewBridgeH = 56;
    @endphp
    <div
        x-data="{ previewOpen: $wire.entangle('showPreview').live }"
        x-cloak
        x-show="previewOpen"
        x-transition.opacity.duration.150ms
        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-2xl dark:border-gray-700 dark:bg-gray-900" style="width: {{ $previewModalW }}px;">
                <div class="flex items-center justify-between border-b border-gray-200 px-5 py-4 dark:border-gray-700">
                    <div>
                        <flux:heading size="lg">{{ __('Route Preview') }}</flux:heading>
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('Roadmap from start port to destination with stopovers') }}</p>
                    </div>
                    <flux:button type="button" @click="previewOpen = false" variant="ghost" icon="x-mark" />
                </div>

                <div class="overflow-y-auto overflow-x-hidden py-6" style="max-height: 75vh;">
                    @if(count($previewNodes) > 0)
                        @php
                            $cardsPerRow = 4;
                            $previewRows = array_chunk($previewNodes, $cardsPerRow, true);
                            $totalRows = count($previewRows);
                        @endphp
                        <div class="flex flex-col items-center" style="width: {{ $previewModalW }}px;">
                            @foreach($previewRows as $rowIndex => $rowNodes)
                                @php
                                    $thisRowN = count($rowNodes);
                                    $thisRowWidth = $thisRowN * $previewCardW + ($thisRowN - 1) * $previewGap;
                                @endphp
                                <div class="flex items-center" style="width: {{ $thisRowWidth }}px;">
                                    @foreach($rowNodes as $nodeIndex => $node)
                                        @php
                                            $isStart = ($node['type'] ?? '') === 'start';
                                            $isDestination = ($node['type'] ?? '') === 'destination';
                                            $nodeColor = $isStart
                                                ? 'from-emerald-500 to-emerald-600 dark:from-emerald-400 dark:to-emerald-500'
                                                : ($isDestination
                                                    ? 'from-blue-500 to-indigo-600 dark:from-blue-400 dark:to-indigo-500'
                                                    : 'from-amber-500 to-orange-600 dark:from-amber-400 dark:to-orange-500');
                                            $cardBorder = $isStart
                                                ? 'border-emerald-300/70 dark:border-emerald-700/60'
                                                : ($isDestination ? 'border-blue-300/70 dark:border-blue-700/60' : 'border-amber-300/70 dark:border-amber-700/60');
                                        @endphp
                                        <div class="flex shrink-0 flex-col items-center text-center" style="width: {{ $previewCardW }}px;">
                                            <div class="flex h-full w-full flex-col rounded-xl border {{ $cardBorder }} bg-white p-3 shadow-sm transition-transform duration-200 hover:-translate-y-0.5 dark:bg-gray-800/80" style="min-height: {{ $previewCardH }}px;">
                                                <span class="mx-auto mb-2 inline-flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-gradient-to-br text-xs font-semibold text-white {{ $nodeColor }}">
                                                    {{ $nodeIndex + 1 }}
                                                </span>
                                                <p class="line-clamp-2 flex-1 text-xs font-semibold text-gray-800 dark:text-gray-100">{{ $node['port'] }}</p>
                                                <p class="mt-1 shrink-0 text-[11px] font-medium text-gray-500 dark:text-gray-400">
                                                    {{ $node['event'] }}: {{ $node['date'] }}
                                                </p>
                                                <span class="mt-2 inline-flex shrink-0 rounded-full px-2 py-0.5 text-[10px] font-semibold uppercase tracking-wide
                                                    {{ $isStart
                                                        ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-900/40 dark:text-emerald-300'
                                                        : ($isDestination
                                                            ? 'bg-blue-100 text-blue-700 dark:bg-blue-900/40 dark:text-blue-300'
                                                            : 'bg-amber-100 text-amber-700 dark:bg-amber-900/40 dark:text-amber-300') }}">
                                                    {{ $isStart ? __('Start') : ($isDestination ? __('Destination') : __('Stopover')) }}
                                                </span>
                                            </div>
                                        </div>

                                        @if(!$loop->last)
                                            <div class="group/conn relative shrink-0 flex h-16 items-center justify-center" style="width: {{ $previewGap }}px;">
                                                <svg class="absolute inset-0 h-full w-full" viewBox="0 0 {{ $previewGap }} 64" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <defs>
                                                        <marker id="arrowH{{ $nodeIndex }}" markerWidth="8" markerHeight="6" refX="7" refY="3" orient="auto">
                                                            <path d="M0 0 L8 3 L0 6 Z" class="fill-cyan-500 dark:fill-cyan-400" />
                                                        </marker>
                                                    </defs>
                                                    <line x1="4" y1="32" x2="{{ $previewGap - 4 }}" y2="32"
                                                        class="route-svg-line stroke-cyan-400 dark:stroke-cyan-500"
                                                        stroke-width="2" stroke-dasharray="6 4"
                                                        marker-end="url(#arrowH{{ $nodeIndex }})" />
                                                </svg>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                @if($rowIndex < $totalRows - 1)
                                    @php
                                        $n1 = count($rowNodes);
                                        $n2 = count($previewRows[$rowIndex + 1]);
                                        $row1Px = $n1 * $previewCardW + ($n1 - 1) * $previewGap;
                                        $row2Px = $n2 * $previewCardW + ($n2 - 1) * $previewGap;
                                        $row1Offset = (int) (($previewModalW - $row1Px) / 2);
                                        $row2Offset = (int) (($previewModalW - $row2Px) / 2);
                                        $startX = $row1Offset + ($n1 - 1) * ($previewCardW + $previewGap) + $previewCardW / 2;
                                        $endX = $row2Offset + $previewCardW / 2;
                                        $midY = (int) ($previewBridgeH / 2);
                                        $curveX = (int) (($startX + $endX) / 2);
                                    @endphp
                                    <div class="group/rowconn relative flex shrink-0 items-center justify-center" style="width: {{ $previewModalW }}px; height: {{ $previewBridgeH }}px;">
                                        <svg class="block" width="{{ $previewModalW }}" height="{{ $previewBridgeH }}" viewBox="0 0 {{ $previewModalW }} {{ $previewBridgeH }}" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <defs>
                                                <marker id="arrowBridge{{ $rowIndex }}" markerWidth="8" markerHeight="6" refX="4" refY="3" orient="auto">
                                                    <path d="M0 0 L8 3 L0 6 Z" class="fill-cyan-500 dark:fill-cyan-400" />
                                                </marker>
                                            </defs>
                                            <path d="M {{ $startX }} 0 L {{ $startX }} 12 Q {{ $startX }} {{ $midY }}, {{ $curveX }} {{ $midY }} L {{ $endX + 40 }} {{ $midY }} Q {{ $endX }} {{ $midY }}, {{ $endX }} {{ $previewBridgeH - 12 }} L {{ $endX }} {{ $previewBridgeH }}"
                                                class="route-svg-line stroke-cyan-400 dark:stroke-cyan-500"
                                                stroke-width="2" stroke-dasharray="6 4" fill="none"
                                                marker-end="url(#arrowBridge{{ $rowIndex }})" />
                                        </svg>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @else
                        <p class="py-10 text-center text-gray-500 dark:text-gray-400">{{ __('No route data available for preview.') }}</p>
                    @endif
                </div>

                <div class="flex justify-end border-t border-gray-200 px-5 py-3 dark:border-gray-700">
                    <flux:button type="button" @click="previewOpen = false" variant="primary">{{ __('Close') }}</flux:button>
                </div>
            </div>
    </div>
</div>
