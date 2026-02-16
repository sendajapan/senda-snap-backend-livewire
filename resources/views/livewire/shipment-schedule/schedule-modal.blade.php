<div>
    <!-- Backdrop -->
    <div x-data="{ open: @entangle('open') }"
         x-show="open"
         x-cloak
         class="fixed inset-0 z-50 overflow-hidden"
         style="display: none;">

        <!-- Background overlay -->
        <div x-show="open"
             x-transition:enter="transition ease-out duration-300"
             x-transition:enter-start="opacity-0"
             x-transition:enter-end="opacity-100"
             x-transition:leave="transition ease-in duration-500"
             x-transition:leave-start="opacity-100"
             x-transition:leave-end="opacity-0"
             class="absolute inset-0 bg-gray-900/50 backdrop-blur-sm"></div>

        <!-- Modal Panel -->
        <div class="fixed inset-0 sm:inset-y-0 sm:right-0 sm:left-auto flex max-w-full pl-0 sm:pl-10 justify-end">
            <div x-show="open"
                 x-transition:enter="transform transition ease-in-out duration-500"
                 x-transition:enter-start="translate-y-full sm:translate-y-0 sm:translate-x-full"
                 x-transition:enter-end="translate-y-0 sm:translate-x-0"
                 x-transition:leave="transform transition ease-in-out duration-500"
                 x-transition:leave-start="translate-y-0 sm:translate-x-0"
                 x-transition:leave-end="translate-y-full sm:translate-y-0 sm:translate-x-full"
                 class="w-full sm:w-screen sm:max-w-4xl bg-white/60 backdrop-blur-xl dark:bg-gray-800/60 sm:rounded-none rounded-t-2xl sm:rounded-t-none">

                <div class="flex h-full flex-col overflow-y-auto border-t sm:border-t-0 sm:border-l {{ $isPublicMode ? 'border-gray-300/50 shadow-xl shadow-gray-200/40 dark:border-gray-700/50 dark:shadow-gray-900/30' : 'border-blue-300/50 shadow-xl shadow-blue-200/40 dark:border-blue-800/50 dark:shadow-blue-900/30' }} bg-white/60 backdrop-blur-xl dark:bg-gray-800/60">
                    <!-- Decorative Elements -->
                    @if($isPublicMode)
                        <div class="pointer-events-none absolute -right-4 sm:-right-8 -top-4 sm:-top-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-gray-400/20 to-gray-500/20 blur-3xl"></div>
                        <div class="pointer-events-none absolute -bottom-4 sm:-bottom-8 -left-4 sm:-left-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-gray-500/20 to-gray-400/20 blur-3xl"></div>
                    @else
                        <div class="pointer-events-none absolute -right-4 sm:-right-8 -top-4 sm:-top-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-blue-400/20 to-cyan-400/20 blur-3xl"></div>
                        <div class="pointer-events-none absolute -bottom-4 sm:-bottom-8 -left-4 sm:-left-8 h-40 w-40 sm:h-64 sm:w-64 rounded-full bg-gradient-to-br from-cyan-400/20 to-blue-400/20 blur-3xl"></div>
                    @endif

                    <!-- Header -->
                    <div class="relative border-b border-gray-200/50 bg-white/50 px-4 py-4 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                        <div class="flex items-center justify-between gap-3">
                            <div class="flex items-center gap-3 min-w-0">
                                <div class="flex h-icon-sm w-icon-sm flex-shrink-0 items-center justify-center rounded-lg sm:rounded-xl shadow-lg text-base sm:text-lg [&_svg]:size-[1em] {{ $isPublicMode ? 'bg-gradient-to-br from-gray-600 to-gray-700 dark:from-gray-500 dark:to-gray-600' : 'bg-gradient-to-br from-blue-500 to-cyan-600' }}">
                                    <svg class="text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                    </svg>
                                </div>
                                <div class="min-w-0">
                                    <h2 class="text-base sm:text-lg font-bold text-gray-900 dark:text-white truncate">
                                        {{ $isEditing ? __('Edit Schedule') : __('Add New Schedule') }}
                                    </h2>
                                    <p class="text-sm text-gray-600 dark:text-gray-400 line-clamp-1">
                                        {{ $isEditing ? __('Update schedule information') : __('Create a new shipment schedule') }}
                                    </p>
                                </div>
                            </div>
                            <button wire:click="closeModal" type="button" class="flex-shrink-0 rounded-lg p-2 text-gray-400 transition-colors hover:bg-gray-100 hover:text-gray-600 dark:hover:bg-gray-800 dark:hover:text-gray-300 text-xl [&_svg]:size-[1em]">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Form -->
                    <form wire:submit="save" class="relative flex-1 overflow-y-auto {{ $isPublicMode ? 'text-sm md:text-base' : '' }}">
                        <div class="space-y-4 p-4">
                            <!-- Vessel Name and Voyage No (60-40 ratio) -->
                            <div class="grid grid-cols-1 sm:grid-cols-5 gap-3">
                                <div class="col-span-1 sm:col-span-3">
                                    <flux:input wire:model="vessel_name" label="{{ __('Vessel Name') }}" placeholder="{{ __('Enter vessel name') }}" required />
                                    @error('vessel_name')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-span-1 sm:col-span-2">
                                    <flux:input wire:model="voyage_no" label="{{ __('Voyage No') }}" placeholder="{{ __('Enter voyage number') }}" required />
                                    @error('voyage_no')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Carriers -->
                            <div>
                                <flux:select wire:model="carrier_1_id" label="{{ __('Carrier 1') }}">
                                    <option value="">{{ __('Select Carrier') }}</option>
                                    @foreach($providers as $provider)
                                        <option value="{{ $provider->id }}">{{ $provider->line_name }}</option>
                                    @endforeach
                                </flux:select>
                                @error('carrier_1_id')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Carrier 2 and 3 (Disabled for now) -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 opacity-50 pointer-events-none">
                                <div>
                                    <flux:select wire:model="carrier_2_id" label="{{ __('Carrier 2') }}" disabled>
                                        <option value="">{{ __('Select Carrier') }}</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->line_name }}</option>
                                        @endforeach
                                    </flux:select>
                                </div>

                                <div>
                                    <flux:select wire:model="carrier_3_id" label="{{ __('Carrier 3') }}" disabled>
                                        <option value="">{{ __('Select Carrier') }}</option>
                                        @foreach($providers as $provider)
                                            <option value="{{ $provider->id }}">{{ $provider->line_name }}</option>
                                        @endforeach
                                    </flux:select>
                                </div>
                            </div>

                            <!-- Ports -->
                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <flux:select wire:model="start_port_id" label="{{ __('Start Port') }}" required>
                                        <option value="">{{ __('Select Start Port') }}</option>
                                        @foreach($localPorts as $port)
                                            <option value="{{ $port->id }}">{{ $port->port_name }}</option>
                                        @endforeach
                                    </flux:select>
                                    @error('start_port_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <flux:select wire:model="end_port_id" label="{{ __('End Port') }}" required>
                                        <option value="">{{ __('Select End Port') }}</option>
                                        @foreach($endPorts as $port)
                                            <option value="{{ $port->id }}">{{ $port->port_name }}</option>
                                        @endforeach
                                    </flux:select>
                                    @error('end_port_id')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- ETA -->
                            <div>
                                <flux:input type="date" wire:model="eta" label="{{ __('ETA') }}" required />
                                @error('eta')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- ETD -->
                            <div>
                                <flux:input type="date" wire:model="etd" label="{{ __('ETD') }}" />
                                @error('etd')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Comment -->
                            <div>
                                <flux:textarea wire:model="comment" label="{{ __('Comment') }}" placeholder="{{ __('Enter comment (optional)') }}" rows="3" />
                                @error('comment')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Stopovers Section -->
                            <div class="border-t border-gray-200/50 pt-4 dark:border-gray-700/50">
                                <div class="flex items-center justify-between mb-3">
                                    <h3 class="text-base sm:text-lg font-semibold text-gray-900 dark:text-white">
                                        {{ __('Stopovers') }}
                                    </h3>
                                    @if(!$showingAddStopover && $editingStopoverIndex === null)
                                        <flux:button
                                            type="button"
                                            wire:click="$set('showingAddStopover', true)"
                                            size="sm"
                                            variant="outline"
                                            icon="plus">
                                            {{ __('Add Stopover') }}
                                        </flux:button>
                                    @endif
                                </div>

                                <!-- Add/Edit Stopover Form (Inline) -->
                                @if($showingAddStopover || $editingStopoverIndex !== null)
                                    <div class="mb-3 p-3 rounded-lg border {{ $isPublicMode ? 'border-gray-200 bg-gray-50/50 dark:border-gray-600 dark:bg-gray-800/50' : 'border-blue-200 bg-blue-50/30 dark:border-blue-800 dark:bg-blue-900/20' }}">
                                        <div class="space-y-4">
                                            <div class="flex items-center justify-between mb-2">
                                                <h4 class="text-sm font-semibold text-gray-900 dark:text-white">
                                                    {{ $editingStopoverIndex !== null ? __('Edit Stopover') : __('Add New Stopover') }}
                                                </h4>
                                                <button
                                                    type="button"
                                                    wire:click="{{ $editingStopoverIndex !== null ? 'cancelEditStopover' : 'cancelAddStopover' }}"
                                                    class="text-gray-400 hover:text-gray-600 dark:hover:text-gray-300">
                                                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                                    </svg>
                                                </button>
                                            </div>

                                            <!-- Port -->
                                            <div>
                                                <flux:select wire:model="newStopoverPortId" label="{{ __('Port') }}" required>
                                                    <option value="">{{ __('Select Port') }}</option>
                                                    @foreach($stopoverPorts as $port)
                                                        <option value="{{ $port->id }}">{{ $port->port_name }} ({{ $port->port_type }})</option>
                                                    @endforeach
                                                </flux:select>
                                                @error('newStopoverPortId')
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Stopover ETA -->
                                            <div>
                                                <flux:input type="date" wire:model="newStopoverEta" label="{{ __('Arrival (ETA)') }}" />
                                                @error('newStopoverEta')
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Stopover ETD -->
                                            <div>
                                                <flux:input type="date" wire:model="newStopoverEtd" label="{{ __('Departure (ETD)') }}" />
                                                @error('newStopoverEtd')
                                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <!-- Form Actions -->
                                            <div class="flex items-center justify-end gap-2 pt-2">
                                                <flux:button
                                                    type="button"
                                                    wire:click="{{ $editingStopoverIndex !== null ? 'cancelEditStopover' : 'cancelAddStopover' }}"
                                                    variant="ghost"
                                                    size="sm">
                                                    {{ __('Cancel') }}
                                                </flux:button>
                                                <flux:button
                                                    type="button"
                                                    wire:click="{{ $editingStopoverIndex !== null ? 'updateStopover' : 'addStopover' }}"
                                                    variant="primary"
                                                    size="sm"
                                                    icon="check">
                                                    {{ $editingStopoverIndex !== null ? __('Update') : __('Add') }}
                                                </flux:button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <!-- Stopovers Table -->
                                @if(count($stopovers) > 0)
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
                                                @foreach($stopovers as $index => $stopover)
                                                    @php
                                                        $port = $stopoverPorts->firstWhere('id', $stopover['port_id']);
                                                    @endphp
                                                    <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/30">
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <div class="flex items-center gap-2">
                                                                <svg class="h-4 w-4 {{ $isPublicMode ? 'text-gray-500' : 'text-blue-500' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                                                </svg>
                                                                <span class="text-sm text-gray-900 dark:text-white">{{ $port->port_name ?? 'N/A' }}</span>
                                                            </div>
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            @if($stopover['stopover_eta'])
                                                                <div class="flex items-center gap-1.5">
                                                                    <svg class="h-4 w-4 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                                                                    </svg>
                                                                    <span class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($stopover['stopover_eta'])->format('M d, Y') }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Not set') }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            @if($stopover['stopover_etd'])
                                                                <div class="flex items-center gap-1.5">
                                                                    <svg class="h-4 w-4 text-orange-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                                                    </svg>
                                                                    <span class="text-sm text-gray-900 dark:text-white">{{ \Carbon\Carbon::parse($stopover['stopover_etd'])->format('M d, Y') }}</span>
                                                                </div>
                                                            @else
                                                                <span class="text-xs text-gray-400 dark:text-gray-500">{{ __('Not set') }}</span>
                                                            @endif
                                                        </td>
                                                        <td class="px-3 py-2 whitespace-nowrap">
                                                            <div class="flex justify-center items-center gap-1.5">
                                                                <button
                                                                    type="button"
                                                                    wire:click="editStopover({{ $index }})"
                                                                    class="rounded-lg border-2 p-1.5 transition-colors {{ $isPublicMode ? 'border-gray-600 bg-gray-100 dark:bg-gray-700/50 text-gray-700 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600/50' : 'border-cyan-700/60 bg-cyan-500/10 text-cyan-700 hover:bg-cyan-500/20' }}"
                                                                    title="{{ __('Edit Stopover') }}">
                                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                                                                    </svg>
                                                                </button>
                                                                <button
                                                                    type="button"
                                                                    wire:click="removeStopover({{ $index }})"
                                                                    wire:confirm="{{ __('Are you sure you want to remove this stopover?') }}"
                                                                    class="rounded-lg border-2 border-red-700/60 bg-red-500/10 p-1.5 text-red-700 transition-colors hover:bg-red-500/20"
                                                                    title="{{ __('Remove Stopover') }}">
                                                                    <svg class="h-3.5 w-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                @else
                                    <p class="text-sm text-gray-500 dark:text-gray-400 text-center py-4">
                                        {{ __('No stopovers added yet') }}
                                    </p>
                                @endif
                            </div>
                        </div>

                        <!-- Footer Actions -->
                        <div class="border-t border-gray-200/50 px-4 py-3 backdrop-blur-sm dark:border-gray-700/50 dark:bg-gray-800/60">
                            <div class="flex flex-col-reverse sm:flex-row items-stretch sm:items-center justify-end gap-2">
                                <flux:button type="button" wire:click="closeModal" variant="ghost" class="w-full sm:w-auto">
                                    {{ __('Cancel') }}
                                </flux:button>
                                <flux:button type="submit" variant="primary" icon="check" class="w-full sm:w-auto">
                                    {{ $isEditing ? __('Update Schedule') : __('Create Schedule') }}
                                </flux:button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
