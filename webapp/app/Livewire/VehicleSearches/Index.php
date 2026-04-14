<?php

declare(strict_types=1);

namespace App\Livewire\VehicleSearches;

use App\Models\VehicleSearchLog;
use App\Models\Vendor;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?int $vendorFilter = null;

    public ?string $searchTypeFilter = null;

    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
        $this->resetPage();
    }

    public function updatedVendorFilter($value): void
    {
        $this->vendorFilter = ($value === '' || $value === null) ? null : (int) $value;
        $this->resetPage();
    }

    public function updatedSearchTypeFilter($value): void
    {
        $this->searchTypeFilter = ($value === '' || $value === null) ? null : $value;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = null;
        $this->vendorFilter = null;
        $this->searchTypeFilter = null;
        $this->resetPage();
    }

    public function render(): View
    {
        $query = VehicleSearchLog::with(['user', 'vendor'])
            ->forCurrentVendor()
            ->recent();

        // Filter by search term (user name or search query)
        if ($this->search !== null && $this->search !== '') {
            $search = $this->search;
            $query->where(function ($q) use ($search) {
                $q->where('search_query', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($userQuery) use ($search) {
                        $userQuery->where('name', 'like', "%{$search}%")
                            ->orWhere('email', 'like', "%{$search}%");
                    });
            });
        }

        // Filter by vendor
        if ($this->vendorFilter !== null) {
            $query->where('vendor_id', $this->vendorFilter);
        }

        // Filter by search type
        if ($this->searchTypeFilter !== null && $this->searchTypeFilter !== '') {
            $query->where('search_type', $this->searchTypeFilter);
        }

        $searchLogs = $query->paginate(15);

        // Get vendors for filter dropdown (only for admin users)
        $vendors = null;
        if (auth()->user()?->role === 'admin') {
            $vendors = Vendor::orderBy('name', 'asc')->get();
        }

        return view('livewire.vehicle-searches.index', [
            'searchLogs' => $searchLogs,
            'vendors' => $vendors,
        ])->layout('components.layouts.app', ['title' => __('Vehicle Search History')]);
    }
}
