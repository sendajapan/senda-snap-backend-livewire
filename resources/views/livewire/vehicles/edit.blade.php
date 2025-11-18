<?php

use App\Models\Vehicle;
use Livewire\Volt\Component;

new class extends Component {
    public Vehicle $vehicle;
    public array $form = [];

    public function mount(Vehicle $vehicle): void
    {
        $this->vehicle = $vehicle;
        $this->form = $vehicle->only(['serial_number', 'make', 'model', 'chassis_model', 'cc', 'year', 'color', 'vehicle_buy_date', 'auction_ship_number', 'net_weight', 'area', 'length', 'width', 'height', 'plate_number', 'buying_price', 'expected_yard_date', 'rikso_from', 'rikso_to', 'rikso_cost', 'rikso_company', 'status']);
        $this->form['vehicle_buy_date'] = $vehicle->vehicle_buy_date->format('Y-m-d');
        $this->form['expected_yard_date'] = $vehicle->expected_yard_date->format('Y-m-d');
    }

    public function save(): void
    {
        $validated = $this->validate([
            'form.serial_number' => 'required|string|unique:vehicles,serial_number,' . $this->vehicle->id,
            'form.make' => 'required|string',
            'form.model' => 'required|string',
            'form.chassis_model' => 'required|string',
            'form.cc' => 'required|integer',
            'form.year' => 'required|integer',
            'form.color' => 'required|string',
            'form.vehicle_buy_date' => 'required|date',
            'form.auction_ship_number' => 'required|string',
            'form.net_weight' => 'required|numeric',
            'form.area' => 'required|string',
            'form.length' => 'required|numeric',
            'form.width' => 'required|numeric',
            'form.height' => 'required|numeric',
            'form.plate_number' => 'nullable|string',
            'form.buying_price' => 'required|numeric',
            'form.expected_yard_date' => 'required|date',
            'form.rikso_from' => 'nullable|string',
            'form.rikso_to' => 'nullable|string',
            'form.rikso_cost' => 'nullable|numeric',
            'form.rikso_company' => 'nullable|string',
            'form.status' => 'required|in:pending,in_yard,ready,sold',
        ]);

        $this->vehicle->update($validated['form']);
        session()->flash('success', 'Vehicle updated successfully.');
        $this->redirect(route('vehicles.index'), navigate: true);
    }
}; ?>

<x-layouts.app :title="__('Edit Vehicle')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-6">
        <div>
            <flux:heading size="xl">{{ __('Edit Vehicle') }}</flux:heading>
            <flux:text>{{ __('Update vehicle information') }}</flux:text>
        </div>
        <div class="max-w-4xl rounded-lg border border-gray-200 bg-white p-6 shadow-sm dark:border-gray-700 dark:bg-gray-900">
            <form wire:submit="save" class="space-y-6">
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Serial Number') }}</flux:label>
                        <flux:input wire:model="form.serial_number" />
                        <flux:error name="form.serial_number" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Status') }}</flux:label>
                        <flux:select wire:model="form.status">
                            <option value="pending">{{ __('Pending') }}</option>
                            <option value="in_yard">{{ __('In Yard') }}</option>
                            <option value="ready">{{ __('Ready') }}</option>
                            <option value="sold">{{ __('Sold') }}</option>
                        </flux:select>
                        <flux:error name="form.status" />
                    </flux:field>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <flux:field>
                        <flux:label>{{ __('Make') }}</flux:label>
                        <flux:input wire:model="form.make" />
                        <flux:error name="form.make" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Model') }}</flux:label>
                        <flux:input wire:model="form.model" />
                        <flux:error name="form.model" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Year') }}</flux:label>
                        <flux:input type="number" wire:model="form.year" />
                        <flux:error name="form.year" />
                    </flux:field>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Buying Price') }}</flux:label>
                        <flux:input type="number" step="0.01" wire:model="form.buying_price" />
                        <flux:error name="form.buying_price" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Color') }}</flux:label>
                        <flux:input wire:model="form.color" />
                        <flux:error name="form.color" />
                    </flux:field>
                </div>
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">{{ __('Update Vehicle') }}</flux:button>
                    <flux:button :href="route('vehicles.index')" variant="ghost" wire:navigate>{{ __('Cancel') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
