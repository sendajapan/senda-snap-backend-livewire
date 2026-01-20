<?php

declare(strict_types=1);

namespace App\Livewire\ShippingCompanies;

use App\Models\ShipLine;
use App\Services\ShipLineService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class ShippingCompanyPreview extends Component
{
    public bool $open = false;

    public ?ShipLine $shippingCompany = null;

    #[On('open-shipping-company-preview')]
    public function openPreview(?int $shippingCompanyId, ShipLineService $shipLineService): void
    {
        if ($shippingCompanyId) {
            $this->shippingCompany = $shipLineService->getById($shippingCompanyId);
        } else {
            $this->shippingCompany = null;
        }

        $this->open = true;
    }

    public function closePreview(): void
    {
        $this->open = false;
        $this->shippingCompany = null;
    }

    public function editShippingCompany(): void
    {
        if ($this->shippingCompany) {
            $this->dispatch('open-shipping-company-modal', shippingCompanyId: $this->shippingCompany->id);
            $this->closePreview();
        }
    }

    public function deleteShippingCompany(ShipLineService $shipLineService): void
    {
        if ($this->shippingCompany) {
            try {
                $shipLineService->delete($this->shippingCompany);
                $this->dispatch('shipping-company-saved');
                $this->dispatch('notify', message: __('Shipping company deleted successfully.'), type: 'success');
                $this->closePreview();
            } catch (\Exception $e) {
                \Log::error('Shipping company delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the shipping company.'), type: 'error');
            }
        }
    }

    public function canDelete(): bool
    {
        $currentUser = Auth::user();
        if (! $currentUser || ! $this->shippingCompany) {
            return false;
        }

        // Only admin or manager can delete
        return in_array($currentUser->role, ['admin', 'manager']);
    }

    public function render()
    {
        return view('livewire.shipping-companies.shipping-company-preview');
    }
}
