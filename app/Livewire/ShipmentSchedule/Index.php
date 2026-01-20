<?php

declare(strict_types=1);

namespace App\Livewire\ShipmentSchedule;

use App\Models\Port;
use App\Models\ShipLine;
use App\Services\ScheduleService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    public ?string $search = null;

    public ?string $vesselFilter = null;

    public ?string $voyageFilter = null;

    public ?int $carrierFilter = null;

    public ?int $startPortFilter = null;

    public ?int $endPortFilter = null;

    public function updatedSearch($value): void
    {
        $this->search = trim((string) $value) === '' ? null : trim((string) $value);
        $this->resetPage();
    }

    public function updatedVesselFilter($value): void
    {
        $this->vesselFilter = ($value === '' || $value === null) ? null : trim((string) $value);
        $this->resetPage();
    }

    public function updatedVoyageFilter($value): void
    {
        $this->voyageFilter = ($value === '' || $value === null) ? null : trim((string) $value);
        $this->resetPage();
    }

    public function updatedCarrierFilter($value): void
    {
        $this->carrierFilter = ($value === '' || $value === null) ? null : (int) $value;
        $this->resetPage();
    }

    public function updatedStartPortFilter($value): void
    {
        $this->startPortFilter = ($value === '' || $value === null) ? null : (int) $value;
        $this->resetPage();
    }

    public function updatedEndPortFilter($value): void
    {
        $this->endPortFilter = ($value === '' || $value === null) ? null : (int) $value;
        $this->resetPage();
    }

    public function clearFilters(): void
    {
        $this->search = null;
        $this->vesselFilter = null;
        $this->voyageFilter = null;
        $this->carrierFilter = null;
        $this->startPortFilter = null;
        $this->endPortFilter = null;
        $this->resetPage();
    }

    #[On('schedule-saved')]
    public function refreshSchedules(): void
    {
        // This will trigger a re-render and refresh the schedules list
    }

    #[On('stopover-saved')]
    public function refreshStopovers(): void
    {
        // This will trigger a re-render and refresh the schedules list
    }

    #[On('delete-schedule')]
    public function deleteSchedule(array $payload, ScheduleService $scheduleService): void
    {
        $scheduleId = $payload['scheduleId'] ?? null;
        if ($scheduleId) {
            try {
                $schedule = $scheduleService->getById($scheduleId);
                $scheduleService->delete($schedule);
                $this->dispatch('notify', message: __('Schedule deleted successfully.'), type: 'success');
            } catch (\Exception $e) {
                \Log::error('Schedule delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the schedule.'), type: 'error');
            }
        }
    }

    #[On('delete-stopover')]
    public function deleteStopover(array $payload, \App\Services\ScheduleStopoverService $stopoverService): void
    {
        $stopoverId = $payload['stopoverId'] ?? null;
        if ($stopoverId) {
            try {
                $stopover = \App\Models\ScheduleStopover::findOrFail($stopoverId);
                $stopoverService->delete($stopover);
                $this->dispatch('notify', message: __('Stopover deleted successfully.'), type: 'success');
                // Refresh will happen automatically via Livewire reactivity
            } catch (\Exception $e) {
                \Log::error('Stopover delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the stopover.'), type: 'error');
            }
        }
    }

    public function getProvidersProperty()
    {
        return ShipLine::where('status', 'Active')
            ->orderBy('line_name', 'asc')
            ->get();
    }

    public function getLocalPortsProperty()
    {
        return Port::where('port_type', 'Local Port')
            ->orderBy('port_name', 'asc')
            ->get();
    }

    public function render(ScheduleService $scheduleService): View
    {
        $filters = [];
        if ($this->search !== null && $this->search !== '') {
            $filters['search'] = $this->search;
        }
        if ($this->vesselFilter !== null && $this->vesselFilter !== '') {
            $filters['vessel_name'] = $this->vesselFilter;
        }
        if ($this->voyageFilter !== null && $this->voyageFilter !== '') {
            $filters['voyage_no'] = $this->voyageFilter;
        }
        if ($this->carrierFilter !== null) {
            $filters['carrier_id'] = $this->carrierFilter;
        }
        if ($this->startPortFilter !== null) {
            $filters['start_port_id'] = $this->startPortFilter;
        }
        if ($this->endPortFilter !== null) {
            $filters['end_port_id'] = $this->endPortFilter;
        }

        $schedules = $scheduleService->list($filters, 15);

        return view('livewire.shipment-schedule.index', [
            'schedules' => $schedules,
            'providers' => $this->providers,
            'localPorts' => $this->localPorts,
        ])->layout('components.layouts.app', ['title' => __('Shipment Schedule')]);
    }
}
