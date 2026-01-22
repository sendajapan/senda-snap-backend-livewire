<?php

declare(strict_types=1);

namespace App\Livewire\ShipmentSchedule;

use App\Models\Port;
use App\Models\ScheduleStopover;
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
    public function deleteSchedule($scheduleId = null, ?ScheduleService $scheduleService = null): void
    {
        // Handle both direct scheduleId parameter and object/array with scheduleId property
        if (is_array($scheduleId)) {
            $scheduleId = $scheduleId['scheduleId'] ?? null;
        } elseif (is_object($scheduleId)) {
            $scheduleId = $scheduleId->scheduleId ?? null;
        }

        if (! $scheduleId) {
            return;
        }

        try {
            if (! $scheduleService) {
                $scheduleService = app(ScheduleService::class);
            }
            $schedule = $scheduleService->getById($scheduleId);

            // Check for child records
            $stopoverCount = $schedule->stopovers()->count();
            $warnings = [];
            if ($stopoverCount > 0) {
                $warnings[] = __(':count stopover(s)', ['count' => $stopoverCount]);
            }

            $scheduleService->delete($schedule);
            $this->dispatch('notify', message: __('Schedule deleted successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Schedule delete error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while deleting the schedule.'), type: 'error');
        }
    }

    /**
     * Get child record warnings for a schedule
     */
    public function getScheduleWarnings(int $scheduleId): array
    {
        $schedule = \App\Models\Schedule::withCount('stopovers')->findOrFail($scheduleId);
        $warnings = [];

        if ($schedule->stopovers_count > 0) {
            $warnings[] = __(':count stopover(s)', ['count' => $schedule->stopovers_count]);
        }

        return $warnings;
    }

    #[On('delete-stopover')]
    public function deleteStopover($stopoverId = null, ?\App\Services\ScheduleStopoverService $stopoverService = null): void
    {
        // Handle both direct stopoverId parameter and object/array with stopoverId property
        if (is_array($stopoverId)) {
            $stopoverId = $stopoverId['stopoverId'] ?? null;
        } elseif (is_object($stopoverId)) {
            $stopoverId = $stopoverId->stopoverId ?? null;
        }

        if (! $stopoverId) {
            return;
        }

        try {
            $stopover = ScheduleStopover::findOrFail($stopoverId);
            if (! $stopoverService) {
                $stopoverService = app(\App\Services\ScheduleStopoverService::class);
            }
            $stopoverService->delete($stopover);
            $this->dispatch('notify', message: __('Stopover deleted successfully.'), type: 'success');
            // Refresh will happen automatically via Livewire reactivity
        } catch (\Exception $e) {
            \Log::error('Stopover delete error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while deleting the stopover.'), type: 'error');
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
