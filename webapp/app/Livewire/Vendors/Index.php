<?php

declare(strict_types=1);

namespace App\Livewire\Vendors;

use App\Services\VendorService;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?string $statusFilter = null;

    public function mount(): void
    {
        // Only admin can access vendors
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Only administrators can access vendor management.');
        }
    }

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

    #[On('vendor-saved')]
    public function refreshVendors(): void
    {
        $this->resetPage();
        // This will trigger a re-render and refresh the vendors list
    }

    #[On('delete-vendor')]
    public function deleteVendor($vendorId = null, ?VendorService $vendorService = null): void
    {
        // Handle both direct vendorId parameter and object/array with vendorId property
        if (is_array($vendorId)) {
            $vendorId = $vendorId['vendorId'] ?? null;
        } elseif (is_object($vendorId)) {
            $vendorId = $vendorId->vendorId ?? null;
        }

        if (! $vendorId) {
            return;
        }

        try {
            if (! $vendorService) {
                $vendorService = app(VendorService::class);
            }
            $vendor = $vendorService->getById($vendorId);
            $vendorService->delete($vendor);
            $this->dispatch('notify', message: __('Vendor deleted successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Vendor delete error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while deleting the vendor.'), type: 'error');
        }
    }

    public function render(VendorService $vendorService): View
    {
        $filters = [];
        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }
        if ($this->statusFilter !== null && $this->statusFilter !== '') {
            $filters['status'] = $this->statusFilter;
        }

        $vendors = $vendorService->list($filters, 15);

        return view('livewire.vendors.index', [
            'vendors' => $vendors,
        ])->layout('components.layouts.app', ['title' => __('Vendors')]);
    }
}
