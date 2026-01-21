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
    public function deletePort($portId = null, ?PortService $portService = null): void
    {
        // Handle both direct portId parameter and object/array with portId property
        if (is_array($portId)) {
            $portId = $portId['portId'] ?? null;
        } elseif (is_object($portId)) {
            $portId = $portId->portId ?? null;
        }

        if (! $portId) {
            return;
        }

        try {
            if (! $portService) {
                $portService = app(PortService::class);
            }
            $port = $portService->getById($portId);

            // Check for child records (schedules and stopovers that reference this port)
            $scheduleCount = \App\Models\Schedule::where('start_port_id', $portId)
                ->orWhere('end_port_id', $portId)
                ->count();
            $stopoverCount = \App\Models\ScheduleStopover::where('port_id', $portId)->count();

            $warnings = [];
            if ($scheduleCount > 0) {
                $warnings[] = __(':count schedule(s)', ['count' => $scheduleCount]);
            }
            if ($stopoverCount > 0) {
                $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
            }

            $portService->delete($port);
            $this->dispatch('notify', message: __('Port deleted successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Port delete error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while deleting the port.'), type: 'error');
        }
    }

    /**
     * Get child record warnings for a port
     */
    public function getPortWarnings(int $portId): array
    {
        $scheduleCount = \App\Models\Schedule::where('start_port_id', $portId)
            ->orWhere('end_port_id', $portId)
            ->count();
        $stopoverCount = \App\Models\ScheduleStopover::where('port_id', $portId)->count();

        $warnings = [];
        if ($scheduleCount > 0) {
            $warnings[] = __(':count schedule(s)', ['count' => $scheduleCount]);
        }
        if ($stopoverCount > 0) {
            $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
        }

        return $warnings;
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
