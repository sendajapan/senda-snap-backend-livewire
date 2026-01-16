<?php

declare(strict_types=1);

namespace App\Livewire\ShippingCompanies;

use App\Services\ShippingCompanyService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?string $companyTypeFilter = null;

    public ?string $companyStatusFilter = null;

    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
        $this->resetPage();
    }

    public function updatedCompanyTypeFilter($value): void
    {
        $this->companyTypeFilter = ($value === '' || $value === null) ? null : $value;
        $this->resetPage();
    }

    public function updatedCompanyStatusFilter($value): void
    {
        $this->companyStatusFilter = ($value === '' || $value === null) ? null : $value;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = null;
        $this->companyTypeFilter = null;
        $this->companyStatusFilter = null;
        $this->resetPage();
    }

    #[On('shipping-company-saved')]
    public function refreshShippingCompanies(): void
    {
        // This will trigger a re-render and refresh the shipping companies list
    }

    #[On('delete-shipping-company')]
    public function deleteShippingCompany(array $payload, ShippingCompanyService $shippingCompanyService): void
    {
        $shippingCompanyId = $payload['shippingCompanyId'] ?? null;
        if ($shippingCompanyId) {
            try {
                $shippingCompany = $shippingCompanyService->getById($shippingCompanyId);
                $shippingCompanyService->delete($shippingCompany);
                $this->dispatch('notify', message: __('Shipping company deleted successfully.'), type: 'success');
            } catch (\Exception $e) {
                \Log::error('Shipping company delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the shipping company.'), type: 'error');
            }
        }
    }

    public function render(ShippingCompanyService $shippingCompanyService): View
    {
        $filters = [];
        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }
        if ($this->companyTypeFilter !== null && $this->companyTypeFilter !== '') {
            $filters['company_type'] = $this->companyTypeFilter;
        }
        if ($this->companyStatusFilter !== null && $this->companyStatusFilter !== '') {
            $filters['company_status'] = $this->companyStatusFilter;
        }

        $shippingCompanies = $shippingCompanyService->list($filters, 15);

        return view('livewire.shipping-companies.index', [
            'shippingCompanies' => $shippingCompanies,
        ])->layout('components.layouts.app', ['title' => __('Shipping Companies')]);
    }
}
