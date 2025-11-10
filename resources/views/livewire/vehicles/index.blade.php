<div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ __('Vehicles') }}</flux:heading>
                <flux:text>{{ __('Manage all vehicles') }}</flux:text>
            </div>
            <flux:button :href="route('vehicles.create')" icon="plus" wire:navigate>
                {{ __('Add Vehicle') }}
            </flux:button>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <div class="mb-4 flex gap-4">
                <div class="flex-1">
                    <flux:input wire:model.live.debounce.300ms="search" placeholder="{{ __('Search vehicles...') }}" icon="magnifying-glass" />
                </div>
                <div class="w-48">
                    <flux:select wire:model.live="statusFilter">
                        <option value="">{{ __('All Status') }}</option>
                        <option value="pending">{{ __('Pending') }}</option>
                        <option value="in_yard">{{ __('In Yard') }}</option>
                        <option value="ready">{{ __('Ready') }}</option>
                        <option value="sold">{{ __('Sold') }}</option>
                    </flux:select>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-800">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Serial') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Vehicle') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Year') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Color') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Price') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Status') }}</th>
                            <th class="px-6 py-3 text-left text-xs font-medium uppercase tracking-wider text-gray-500 dark:text-gray-400">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white dark:divide-gray-700 dark:bg-gray-900">
                        @forelse($vehicles as $vehicle)
                            <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-gray-900 dark:text-white">{{ $vehicle->serial_number }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $vehicle->make }} {{ $vehicle->model }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $vehicle->year }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">{{ $vehicle->color }}</td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm text-gray-900 dark:text-white">${{ number_format($vehicle->buying_price, 2) }}</td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <flux:badge :color="match($vehicle->status) { 'sold' => 'green', 'ready' => 'blue', 'in_yard' => 'yellow', default => 'gray' }">
                                        {{ ucfirst(str_replace('_', ' ', $vehicle->status)) }}
                                    </flux:badge>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium">
                                    <div class="flex gap-2">
                                        <flux:button size="sm" variant="ghost" :href="route('vehicles.show', $vehicle)" icon="eye" wire:navigate></flux:button>
                                        <flux:button size="sm" variant="ghost" :href="route('vehicles.edit', $vehicle)" icon="pencil" wire:navigate></flux:button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">{{ __('No vehicles found.') }}</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-4">{{ $vehicles->links() }}</div>
        </div>
</div>
