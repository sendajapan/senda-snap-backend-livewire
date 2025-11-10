<?php

use App\Models\Vehicle;
use Livewire\Volt\Component;

new class extends Component {
    public Vehicle $vehicle;

    public function mount(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle->load(['creator', 'photos', 'consignee', 'tasks']);
    }
}; ?>

<x-layouts.app :title="__('Vehicle Details')">
    <div class="flex h-full w-full flex-1 flex-col gap-6 p-6">
        <div class="flex items-center justify-between">
            <div>
                <flux:heading size="xl">{{ $vehicle->serial_number }}</flux:heading>
                <flux:text>{{ $vehicle->make }} {{ $vehicle->model }}</flux:text>
            </div>
            <flux:button :href="route('vehicles.edit', $vehicle)" icon="pencil" wire:navigate>{{ __('Edit') }}</flux:button>
        </div>

        <div class="grid gap-6 md:grid-cols-3">
            <div class="md:col-span-2 space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Vehicle Information') }}</h3>
                    <dl class="grid gap-4 md:grid-cols-2">
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Make') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->make }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Model') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->model }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Year') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->year }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Color') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->color }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Chassis Model') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->chassis_model }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('CC') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->cc }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Buying Price') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($vehicle->buying_price, 2) }}</dd></div>
                        <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Area') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->area }}</dd></div>
                    </dl>
                </div>

                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Photos') }}</h3>
                    @if($vehicle->photos->count() > 0)
                        <div class="grid gap-4 md:grid-cols-3">
                            @foreach($vehicle->photos as $photo)
                                <div class="rounded-lg border border-gray-200 p-2 dark:border-gray-700">
                                    <flux:badge>{{ ucfirst($photo->photo_type) }}</flux:badge>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-sm text-gray-500 dark:text-gray-400">{{ __('No photos') }}</p>
                    @endif
                </div>
            </div>

            <div class="space-y-6">
                <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                    <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Status') }}</h3>
                    <flux:badge :color="match($vehicle->status) { 'sold' => 'green', 'ready' => 'blue', 'in_yard' => 'yellow', default => 'gray' }" size="lg">
                        {{ ucfirst(str_replace('_', ' ', $vehicle->status)) }}
                    </flux:badge>
                </div>

                @if($vehicle->consignee)
                    <div class="rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
                        <h3 class="mb-4 text-lg font-semibold text-gray-900 dark:text-white">{{ __('Consignee') }}</h3>
                        <dl class="space-y-3">
                            <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Name') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->consignee->name }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Email') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->consignee->email }}</dd></div>
                            <div><dt class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ __('Phone') }}</dt><dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $vehicle->consignee->phone }}</dd></div>
                        </dl>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layouts.app>
