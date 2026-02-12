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
            <span class="hidden md:inline-block">
                <flux:button @click="openScheduleModal()" icon="plus" variant="outline" class="cursor-pointer">
                    {{ __('Add Schedule') }}
                </flux:button>
            </span>
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
                        <th class="w-14 border-r border-gray-200 px-3 py-2.5 text-center text-sm font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-600 dark:text-gray-400">{{ __('#') }}</th>
                        <th class="w-10 px-1 py-2.5"></th>
                        <th class="px-3 py-2.5 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Vessel / Voyage') }}</th>
                        <th class="px-3 py-2.5 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Carriers') }}</th>
                        <th class="px-3 py-2.5 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Route') }}</th>
                        <th class="px-3 py-2.5 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('ETA') }}</th>
                        <th class="px-3 py-2.5 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Created by') }}</th>
                        <th class="whitespace-nowrap px-3 py-2.5 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Created at') }}</th>
                        <th class="whitespace-nowrap px-3 py-2.5 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-400">{{ __('Updated at') }}</th>
                        <th class="sticky right-0 z-10 w-28 min-w-[8rem] border-l border-gray-200 bg-gray-50 px-3 py-2.5 text-center text-sm font-semibold uppercase tracking-wider text-gray-600 shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.05)] dark:border-gray-600 dark:bg-gray-800/80 dark:text-gray-400 dark:shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.2)]">{{ __('Action') }}</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @forelse($schedules as $index => $schedule)
                        <tr
                            wire:key="public-schedule-row-{{ $schedule->id }}"
                            class="group hover:bg-gray-50 dark:hover:bg-gray-800/50">
                            <td class="whitespace-nowrap border-r border-gray-200 px-3 py-2.5 text-center text-sm text-gray-500 dark:border-gray-600 dark:text-gray-400">
                                {{ $schedules->firstItem() + $index }}
                            </td>
                            <td class="whitespace-nowrap px-1 py-2.5">
                                <button
                                    type="button"
                                    @click="toggleSchedule({{ $schedule->id }})"
                                    aria-label="{{ __('Toggle stopovers') }}"
                                    aria-expanded="false"
                                    class="rounded p-1 text-gray-400 hover:bg-gray-200 hover:text-gray-600 dark:hover:bg-gray-700 dark:hover:text-gray-300 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900">
                                    <svg class="h-5 w-5 transition-transform" :class="{ 'rotate-90': isExpanded({{ $schedule->id }}) }" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                    </svg>
                                </button>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5">
                                <div class="flex items-center gap-2">
                                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-gray-200 dark:bg-gray-700">
                                        <flux:icon.paper-airplane class="h-4 w-4 text-gray-600 dark:text-gray-300 [&_svg]:size-[1em]" />
                                    </div>
                                    <div class="min-w-0">
                                        <div class="text-sm font-semibold text-gray-900 dark:text-white truncate">{{ $schedule->vessel_name }}</div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">{{ __('Voyage') }} {{ $schedule->voyage_no }}</div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-3 py-2.5">
                                <div class="flex flex-wrap gap-1">
                                    @if($schedule->carrier1)
                                        <flux:badge color="gray" size="sm" class="text-sm">{{ $schedule->carrier1->line_name }}</flux:badge>
                                    @endif
                                    @if($schedule->carrier2)
                                        <flux:badge color="gray" size="sm" class="text-sm">{{ $schedule->carrier2->line_name }}</flux:badge>
                                    @endif
                                    @if($schedule->carrier3)
                                        <flux:badge color="gray" size="sm" class="text-sm">{{ $schedule->carrier3->line_name }}</flux:badge>
                                    @endif
                                    @if(!$schedule->carrier1 && !$schedule->carrier2 && !$schedule->carrier3)
                                        <span class="text-sm text-gray-400 dark:text-gray-500">—</span>
                                    @endif
                                </div>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300">
                                <span>{{ $schedule->startPort->port_name ?? '—' }}</span>
                                <span class="mx-1 text-gray-400">→</span>
                                <span>{{ $schedule->endPort->port_name ?? '—' }}</span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300">
                                {{ $schedule->eta ? $schedule->eta->format('M d, Y') : '—' }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-700 dark:text-gray-300">
                                {{ $schedule->creatorDisplayName() }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-600 dark:text-gray-400">
                                {{ $schedule->created_at ? $schedule->created_at->format('M d, Y H:i') : '—' }}
                            </td>
                            <td class="whitespace-nowrap px-3 py-2.5 text-sm text-gray-600 dark:text-gray-400">
                                {{ $schedule->updated_at ? $schedule->updated_at->format('M d, Y H:i') : '—' }}
                            </td>
                            <td class="sticky right-0 z-10 min-w-[8rem] whitespace-nowrap border-l border-gray-200 bg-white px-3 py-2.5 text-center shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.05)] group-hover:bg-gray-50 dark:border-gray-600 dark:bg-gray-900/30 dark:shadow-[-4px_0_6px_-2px_rgba(0,0,0,0.2)] dark:group-hover:bg-gray-800/50">
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
                                        class="rounded p-1.5 text-gray-500 hover:bg-gray-200 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" />
                                        </svg>
                                    </button>
                                        <button
                                            type="button"
                                            @click="confirmDeleteSchedule({{ $schedule->id }}, '{{ addslashes($schedule->vessel_name) }}', @js($warnings)).then((r) => { if (r && r.isConfirmed) $wire.$dispatch('delete-schedule', { scheduleId: {{ $schedule->id }} }) })"
                                            title="{{ __('Delete') }}"
                                            aria-label="{{ __('Delete schedule') }}"
                                            @if(!$canDelete) disabled @endif
                                            class="rounded p-1.5 text-gray-500 hover:bg-red-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-red-900/20 dark:hover:text-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-gray-500 dark:disabled:hover:bg-transparent dark:disabled:hover:text-gray-400">
                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                        <tr
                            wire:key="public-schedule-expand-{{ $schedule->id }}"
                            x-show="isExpanded({{ $schedule->id }})"
                            x-collapse
                            class="bg-gray-100/80 dark:bg-gray-800/50">
                            <td colspan="10" class="px-3 py-3">
                                <div class="ml-9 border-l-2 border-gray-300 pl-4 dark:border-gray-600">
                                    <div class="overflow-hidden rounded-lg border border-gray-200 bg-gray-50 shadow-sm dark:border-gray-600 dark:bg-gray-800/80">
                                        <div class="overflow-x-auto">
                                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-600">
                                                <thead>
                                                    <tr class="bg-gray-100 dark:bg-gray-700/80">
                                                        <th class="w-12 border-r border-gray-200 px-3 py-2 text-center text-sm font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-600 dark:text-gray-300">{{ __('#') }}</th>
                                                        <th class="px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">{{ __('Port') }}</th>
                                                        <th class="whitespace-nowrap px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">{{ __('ETA') }}</th>
                                                        <th class="whitespace-nowrap px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">{{ __('ETD') }}</th>
                                                        <th class="whitespace-nowrap px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">{{ __('Created at') }}</th>
                                                        <th class="whitespace-nowrap px-3 py-2 text-left text-sm font-semibold uppercase tracking-wider text-gray-600 dark:text-gray-300">{{ __('Updated at') }}</th>
                                                        <th class="w-24 border-l border-gray-200 px-3 py-2 text-center text-sm font-semibold uppercase tracking-wider text-gray-600 dark:border-gray-600 dark:text-gray-300">{{ __('Action') }}</th>
                                                    </tr>
                                                </thead>
                                                <tbody class="divide-y divide-gray-200 dark:divide-gray-600">
                                                    @forelse($schedule->stopovers as $stopoverIndex => $stopover)
                                                        @php $canDeleteStopover = ($isCreator ?? false) || ($isCreatorGuest ?? false); @endphp
                                                        <tr class="bg-gray-50/50 dark:bg-gray-800/50">
                                                            <td class="whitespace-nowrap border-r border-gray-200 px-3 py-2 text-center text-sm text-gray-500 dark:border-gray-600 dark:text-gray-400">{{ $stopoverIndex + 1 }}</td>
                                                            <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-900 dark:text-white">{{ $stopover->port->port_name ?? '—' }}</td>
                                                            <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-600 dark:text-gray-400">{{ $stopover->stopover_eta ? $stopover->stopover_eta->format('M d, Y') : '—' }}</td>
                                                            <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-600 dark:text-gray-400">{{ $stopover->stopover_etd ? $stopover->stopover_etd->format('M d, Y') : '—' }}</td>
                                                            <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-600 dark:text-gray-400">{{ $stopover->created_at ? $stopover->created_at->format('M d, Y H:i') : '—' }}</td>
                                                            <td class="whitespace-nowrap px-3 py-2 text-sm text-gray-600 dark:text-gray-400">{{ $stopover->updated_at ? $stopover->updated_at->format('M d, Y H:i') : '—' }}</td>
                                                            <td class="whitespace-nowrap border-l border-gray-200 px-3 py-2 text-center dark:border-gray-600">
                                                                <div class="flex items-center justify-center gap-1">
                                                                    <button
                                                                        type="button"
                                                                        @click="openScheduleModal({{ $schedule->id }})"
                                                                        title="{{ __('Edit') }}"
                                                                        aria-label="{{ __('Edit stopover') }}"
                                                                        class="rounded p-1.5 text-gray-500 hover:bg-gray-200 hover:text-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900">
                                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125" /></svg>
                                                                    </button>
                                                                        <button
                                                                            type="button"
                                                                            @click="confirmDeleteStopover({{ $stopover->id }}, '{{ addslashes($stopover->port->port_name ?? 'N/A') }}').then((r) => { if (r && r.isConfirmed) $wire.$dispatch('delete-stopover', { stopoverId: {{ $stopover->id }} }) })"
                                                                            title="{{ __('Delete') }}"
                                                                            aria-label="{{ __('Delete stopover') }}"
                                                                            @if(!$canDeleteStopover) disabled @endif
                                                                            class="rounded p-1.5 text-gray-500 hover:bg-red-50 hover:text-red-600 dark:text-gray-400 dark:hover:bg-red-900/20 dark:hover:text-red-400 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-1 dark:focus:ring-offset-gray-900 disabled:opacity-40 disabled:cursor-not-allowed disabled:hover:bg-transparent disabled:hover:text-gray-500 dark:disabled:hover:bg-transparent dark:disabled:hover:text-gray-400">
                                                                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                                                    </button>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                    @empty
                                                        <tr>
                                                            <td colspan="7" class="px-3 py-4 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No stopovers') }}</td>
                                                        </tr>
                                                    @endforelse
                                                </tbody>
                                            </table>
                                        </div>
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

        <div class="mt-4 flex justify-center">
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
</div>
