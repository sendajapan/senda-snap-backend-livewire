<?php

use App\Models\Vehicle;
use Livewire\Volt\Component;

new class extends Component {
    public array $form = [
        'serial_number' => '',
        'make' => '',
        'model' => '',
        'chassis_model' => '',
        'cc' => '',
        'year' => '',
        'color' => '',
        'vehicle_buy_date' => '',
        'auction_ship_number' => '',
        'net_weight' => '',
        'area' => '',
        'length' => '',
        'width' => '',
        'height' => '',
        'plate_number' => '',
        'buying_price' => '',
        'expected_yard_date' => '',
        'rikso_from' => '',
        'rikso_to' => '',
        'rikso_cost' => '',
        'rikso_company' => '',
        'status' => 'pending',
    ];

    public function save(): void
    {
        $validated = $this->validate([
            'form.serial_number' => 'required|string|unique:vehicles,serial_number',
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

        Vehicle::create([...$validated['form'], 'created_by' => auth()->id()]);
        session()->flash('success', 'Vehicle created successfully.');
        $this->redirect(route('vehicles.index'), navigate: true);
    }
}; ?>

<x-layouts.app :title="__('Create Vehicle')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 p-6">
        <div>
            <flux:heading size="xl">{{ __('Create Vehicle') }}</flux:heading>
            <flux:text>{{ __('Add a new vehicle') }}</flux:text>
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
                        <flux:label>{{ __('Chassis Model') }}</flux:label>
                        <flux:input wire:model="form.chassis_model" />
                        <flux:error name="form.chassis_model" />
                    </flux:field>
                </div>
                <div class="grid gap-4 md:grid-cols-4">
                    <flux:field>
                        <flux:label>{{ __('CC') }}</flux:label>
                        <flux:input type="number" wire:model="form.cc" />
                        <flux:error name="form.cc" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Year') }}</flux:label>
                        <flux:input type="number" wire:model="form.year" />
                        <flux:error name="form.year" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Color') }}</flux:label>
                        <flux:input wire:model="form.color" />
                        <flux:error name="form.color" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Plate Number') }}</flux:label>
                        <flux:input wire:model="form.plate_number" />
                        <flux:error name="form.plate_number" />
                    </flux:field>
                </div>
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Purchase Date') }}</flux:label>
                        <flux:input type="date" wire:model="form.vehicle_buy_date" />
                        <flux:error name="form.vehicle_buy_date" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Expected Yard Date') }}</flux:label>
                        <flux:input type="date" wire:model="form.expected_yard_date" />
                        <flux:error name="form.expected_yard_date" />
                    </flux:field>
                </div>
                <div class="grid gap-4 md:grid-cols-3">
                    <flux:field>
                        <flux:label>{{ __('Auction Ship #') }}</flux:label>
                        <flux:input wire:model="form.auction_ship_number" />
                        <flux:error name="form.auction_ship_number" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Area') }}</flux:label>
                        <flux:input wire:model="form.area" />
                        <flux:error name="form.area" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Buying Price') }}</flux:label>
                        <flux:input type="number" step="0.01" wire:model="form.buying_price" />
                        <flux:error name="form.buying_price" />
                    </flux:field>
                </div>
                <div class="grid gap-4 md:grid-cols-4">
                    <flux:field>
                        <flux:label>{{ __('Net Weight (kg)') }}</flux:label>
                        <flux:input type="number" step="0.01" wire:model="form.net_weight" />
                        <flux:error name="form.net_weight" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Length (m)') }}</flux:label>
                        <flux:input type="number" step="0.01" wire:model="form.length" />
                        <flux:error name="form.length" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Width (m)') }}</flux:label>
                        <flux:input type="number" step="0.01" wire:model="form.width" />
                        <flux:error name="form.width" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Height (m)') }}</flux:label>
                        <flux:input type="number" step="0.01" wire:model="form.height" />
                        <flux:error name="form.height" />
                    </flux:field>
                </div>
                <flux:heading size="lg">{{ __('Rikso Information') }}</flux:heading>
                <div class="grid gap-4 md:grid-cols-2">
                    <flux:field>
                        <flux:label>{{ __('Rikso From') }}</flux:label>
                        <flux:input wire:model="form.rikso_from" />
                        <flux:error name="form.rikso_from" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Rikso To') }}</flux:label>
                        <flux:input wire:model="form.rikso_to" />
                        <flux:error name="form.rikso_to" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Rikso Cost') }}</flux:label>
                        <flux:input type="number" step="0.01" wire:model="form.rikso_cost" />
                        <flux:error name="form.rikso_cost" />
                    </flux:field>
                    <flux:field>
                        <flux:label>{{ __('Rikso Company') }}</flux:label>
                        <flux:input wire:model="form.rikso_company" />
                        <flux:error name="form.rikso_company" />
                    </flux:field>
                </div>
                <div class="flex gap-2">
                    <flux:button type="submit" variant="primary">{{ __('Create Vehicle') }}</flux:button>
                    <flux:button :href="route('vehicles.index')" variant="ghost" wire:navigate>{{ __('Cancel') }}</flux:button>
                </div>
            </form>
        </div>
    </div>
</x-layouts.app>
