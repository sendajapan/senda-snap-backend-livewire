<?php

declare(strict_types=1);

namespace App\Livewire\Ports;

use App\Services\PortService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?string $portTypeFilter = null;

    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
        $this->resetPage();
    }

    public function updatedPortTypeFilter($value): void
    {
        $this->portTypeFilter = ($value === '' || $value === null) ? null : $value;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = null;
        $this->portTypeFilter = null;
        $this->resetPage();
    }

    #[On('port-saved')]
    public function refreshPorts(): void
    {
        // This will trigger a re-render and refresh the ports list
    }

    #[On('delete-port')]
    public function deletePort(array $payload, PortService $portService): void
    {
        $portId = $payload['portId'] ?? null;
        if ($portId) {
            try {
                $port = $portService->getById($portId);
                $portService->delete($port);
                $this->dispatch('notify', message: __('Port deleted successfully.'), type: 'success');
            } catch (\Exception $e) {
                \Log::error('Port delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the port.'), type: 'error');
            }
        }
    }

    public function render(PortService $portService): View
    {
        $filters = [];
        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }
        if ($this->portTypeFilter !== null && $this->portTypeFilter !== '') {
            $filters['port_type'] = $this->portTypeFilter;
        }

        $ports = $portService->list($filters, 15);

        return view('livewire.ports.index', [
            'ports' => $ports,
        ])->layout('components.layouts.app', ['title' => __('Ports')]);
    }
}
