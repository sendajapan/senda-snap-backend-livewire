<?php

declare(strict_types=1);

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use App\Services\VendorService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class VendorPreview extends Component
{
    public bool $open = false;

    public ?Vendor $vendor = null;

    public function mount(): void
    {
        // Only admin can access vendors
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Only administrators can access vendor management.');
        }
    }

    #[On('open-vendor-preview')]
    public function openPreview(?int $vendorId, VendorService $vendorService): void
    {
        if ($vendorId) {
            $this->vendor = $vendorService->getById($vendorId);
        } else {
            $this->vendor = null;
        }

        $this->open = true;
    }

    public function closePreview(): void
    {
        $this->open = false;
        $this->vendor = null;
    }

    public function editVendor(): void
    {
        if ($this->vendor) {
            $this->dispatch('open-vendor-modal', vendorId: $this->vendor->id);
            $this->closePreview();
        }
    }

    public function deleteVendor(VendorService $vendorService): void
    {
        if ($this->vendor) {
            try {
                $vendorService->delete($this->vendor);
                $this->dispatch('vendor-saved');
                $this->dispatch('notify', message: __('Vendor deleted successfully.'), type: 'success');
                $this->closePreview();
            } catch (\Exception $e) {
                \Log::error('Vendor delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the vendor.'), type: 'error');
            }
        }
    }

    public function canDelete(): bool
    {
        $currentUser = Auth::user();
        if (! $currentUser || ! $this->vendor) {
            return false;
        }

        // Only admin can delete vendors
        return $currentUser->role === 'admin';
    }

    /**
     * Get child record warnings for a vendor
     */
    public function getVendorWarnings(): array
    {
        if (! $this->vendor) {
            return [];
        }

        $userCount = $this->vendor->users()->count();
        $vehicleCount = $this->vendor->vehicles()->count();

        $warnings = [];
        if ($userCount > 0) {
            $warnings[] = __(':count user(s) will have their vendor association removed', ['count' => $userCount]);
        }
        if ($vehicleCount > 0) {
            $warnings[] = __(':count vehicle(s) will have their vendor association removed', ['count' => $vehicleCount]);
        }

        return $warnings;
    }

    public function render()
    {
        return view('livewire.vendors.vendor-preview');
    }
}
