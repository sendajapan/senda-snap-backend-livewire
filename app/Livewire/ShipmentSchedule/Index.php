<?php

namespace App\Livewire\ShipmentSchedule;

use Illuminate\View\View;
use Livewire\Component;

class Index extends Component
{
    public function render(): View
    {
        return view('livewire.shipment-schedule.index')
            ->layout('components.layouts.app', ['title' => __('Shipment Schedule')]);
    }
}
