<?php

declare(strict_types=1);

namespace App\Livewire\ShippingCompanies;

use App\Services\ShipLineService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?string $statusFilter = null;

    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
        $this->resetPage();
    }

    public function updatedStatusFilter($value): void
    {
        $this->statusFilter = ($value === '' || $value === null) ? null : $value;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = null;
        $this->statusFilter = null;
        $this->resetPage();
    }

    #[On('shipping-company-saved')]
    public function refreshShippingCompanies(): void
    {
        // This will trigger a re-render and refresh the shipping companies list
    }

    #[On('delete-shipping-company')]
    public function deleteShippingCompany($shippingCompanyId = null, ?ShipLineService $shipLineService = null): void
    {
        // Handle both direct shippingCompanyId parameter and object/array with shippingCompanyId property
        if (is_array($shippingCompanyId)) {
            $shippingCompanyId = $shippingCompanyId['shippingCompanyId'] ?? null;
        } elseif (is_object($shippingCompanyId)) {
            $shippingCompanyId = $shippingCompanyId->shippingCompanyId ?? null;
        }

        if (! $shippingCompanyId) {
            return;
        }

        try {
            if (! $shipLineService) {
                $shipLineService = app(ShipLineService::class);
            }
            $shipLine = $shipLineService->getById($shippingCompanyId);
            $shipLineService->delete($shipLine);
            $this->dispatch('notify', message: __('Shipping company deleted successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Shipping company delete error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while deleting the shipping company.'), type: 'error');
        }
    }

    public function render(ShipLineService $shipLineService): View
    {
        $filters = [];
        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }
        if ($this->statusFilter !== null && $this->statusFilter !== '') {
            $filters['status'] = $this->statusFilter;
        }

        $shippingCompanies = $shipLineService->list($filters, 15);

        return view('livewire.shipping-companies.index', [
            'shippingCompanies' => $shippingCompanies,
        ])->layout('components.layouts.app', ['title' => __('Shipping Companies')]);
    }
}
