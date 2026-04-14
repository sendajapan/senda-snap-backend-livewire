<?php

namespace App\Livewire\Vehicles;

use App\Services\VehicleService;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public string $search = '';

    public string $statusFilter = '';

    public function updatedSearch(): void
    {
        $this->resetPage();
    }

    public function updatedStatusFilter(): void
    {
        $this->resetPage();
    }

    public function render(VehicleService $vehicleService)
    {
        $filters = [
            'search' => $this->search,
            'status' => $this->statusFilter,
        ];

        $vehicles = $vehicleService->getPaginated($filters, 10);

        return view('livewire.vehicles.index', [
            'vehicles' => $vehicles,
        ])->layout('components.layouts.app', ['title' => __('Vehicles')]);
    }
}
