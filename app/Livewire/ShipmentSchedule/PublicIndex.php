<?php

declare(strict_types=1);

namespace App\Livewire\ShipmentSchedule;

use App\Models\Port;
use App\Models\ScheduleStopover;
use App\Models\ShipLine;
use App\Services\ScheduleService;
use App\Services\ScheduleStopoverService;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

class PublicIndex extends Component
{
    use WithPagination;

    /**
     * Open the schedule modal in public mode (is_public = true when saving).
     * Called from the frontend so the server forwards to the child ScheduleModal.
     */
    public function openScheduleModalForPublic($scheduleId = null, $creatorName = null): void
    {
        $payload = [
            'scheduleId' => $scheduleId,
            'isPublic' => true,
            'creatorName' => $creatorName ? (string) $creatorName : null,
        ];
        $this->dispatch('open-schedule-modal', $payload)->to(ScheduleModal::class);
    }

    public ?string $creatorName = null;

    public ?string $search = null;

    public ?string $vesselFilter = null;

    public ?string $voyageFilter = null;

    public ?int $carrierFilter = null;

    public ?int $startPortFilter = null;

    public ?int $endPortFilter = null;

    public bool $showPreview = false;

    public array $previewNodes = [];

    public array $previewConnections = [];

    public function mount(): void
    {
        if (auth()->check()) {
            // Logged in: always use the user's name; ignore ?name= and session
            $this->creatorName = auth()->user()->name;
            session()->forget('public_schedule_creator_name');
        } else {
            // Guest: if URL has ?name=, store in session; on reload use session; otherwise use "Guest"
            $queryName = request()->query('name');
            if ($queryName !== null && trim((string) $queryName) !== '') {
                session(['public_schedule_creator_name' => trim((string) $queryName)]);
            }
            $saved = session('public_schedule_creator_name');
            $this->creatorName = ($saved !== null && $saved !== '') ? trim((string) $saved) : 'Guest';
        }
    }

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

    public function previewSchedule($scheduleId): void
    {
        $schedule = \App\Models\Schedule::with(['startPort', 'endPort', 'stopovers.port'])->find($scheduleId);
        if (! $schedule) {
            return;
        }

        $this->buildPreviewFlow($schedule);
        $this->showPreview = true;
    }

    public function closePreview(): void
    {
        $this->showPreview = false;
    }

    protected function buildPreviewFlow(\App\Models\Schedule $schedule): void
    {
        $this->previewNodes = [];
        $this->previewConnections = [];

        $nodes = [];

        // Start Node
        $nodes[] = [
            'port' => $schedule->startPort->port_name ?? __('Start Port'),
            'event' => 'ETD',
            'date' => $schedule->etd ? $schedule->etd->format('Y-m-d') : 'N/A',
            'type' => 'start',
        ];

        // Stopovers
        foreach ($schedule->stopovers as $stopover) {
            $nodes[] = [
                'port' => $stopover->port->port_name ?? __('Stopover'),
                'event' => 'ETA',
                'date' => $stopover->stopover_eta ? $stopover->stopover_eta->format('Y-m-d') : 'N/A',
                'type' => 'stopover',
            ];
        }

        // End Node
        $nodes[] = [
            'port' => $schedule->endPort->port_name ?? __('Destination'),
            'event' => 'ETA',
            'date' => $schedule->eta ? $schedule->eta->format('Y-m-d') : 'N/A',
            'type' => 'destination',
        ];

        $this->previewNodes = $nodes;

        // Connections
        for ($i = 0; $i < count($nodes) - 1; $i++) {
            $from = $nodes[$i];
            $to = $nodes[$i + 1];
            $this->previewConnections[] = [
                'label' => sprintf(
                    '%s (%s: %s) -> %s (%s: %s)',
                    $from['port'],
                    $from['event'],
                    $from['date'],
                    $to['port'],
                    $to['event'],
                    $to['date']
                ),
            ];
        }
    }

    #[On('schedule-saved')]
    public function refreshSchedules(): void
    {
        // Re-render will refresh the list
    }

    #[On('delete-schedule')]
    public function deleteSchedule($scheduleId = null, ?ScheduleService $scheduleService = null): void
    {
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

            if (! $schedule->is_public) {
                return;
            }

            $isCreator = auth()->check() && auth()->id() === $schedule->added_by;
            $isGuestCreator = ! auth()->check() && $schedule->added_by_name && trim((string) $schedule->added_by_name) === trim((string) session('public_schedule_creator_name', ''));
            if (! $isCreator && ! $isGuestCreator) {
                $this->dispatch('notify', message: __('You can only delete schedules you created.'), type: 'error');

                return;
            }

            $scheduleService->delete($schedule);
            $this->dispatch('notify', message: __('Schedule deleted successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Public schedule delete error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred while deleting the schedule.'), type: 'error');
        }
    }

    #[On('delete-stopover')]
    public function deleteStopover($stopoverId = null, ?ScheduleStopoverService $stopoverService = null): void
    {
        if (is_array($stopoverId)) {
            $stopoverId = $stopoverId['stopoverId'] ?? null;
        } elseif (is_object($stopoverId)) {
            $stopoverId = $stopoverId->stopoverId ?? null;
        }

        if (! $stopoverId) {
            return;
        }

        try {
            $stopover = ScheduleStopover::with('schedule')->findOrFail($stopoverId);
            $schedule = $stopover->schedule;

            if (! $schedule || ! $schedule->is_public) {
                return;
            }

            $isCreator = auth()->check() && auth()->id() === $schedule->added_by;
            $isGuestCreator = ! auth()->check() && $schedule->added_by_name && trim((string) $schedule->added_by_name) === trim((string) session('public_schedule_creator_name', ''));
            if (! $isCreator && ! $isGuestCreator) {
                $this->dispatch('notify', message: __('You can only delete stopovers for schedules you created.'), type: 'error');

                return;
            }

            if (! $stopoverService) {
                $stopoverService = app(ScheduleStopoverService::class);
            }
            $stopoverService->delete($stopover);
            $this->dispatch('notify', message: __('Stopover deleted successfully.'), type: 'success');
        } catch (\Exception $e) {
            \Log::error('Public stopover delete error: '.$e->getMessage());
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
        // Show all public schedules regardless of creator (logged-in user or guest)
        $filters['is_public'] = true;

        $schedules = $scheduleService->list($filters, 100);

        $exportQuery = [];
        if ($this->search !== null && $this->search !== '') {
            $exportQuery['search'] = $this->search;
        }
        if ($this->vesselFilter !== null && $this->vesselFilter !== '') {
            $exportQuery['vessel'] = $this->vesselFilter;
        }
        if ($this->voyageFilter !== null && $this->voyageFilter !== '') {
            $exportQuery['voyage'] = $this->voyageFilter;
        }
        if ($this->carrierFilter !== null) {
            $exportQuery['carrier_id'] = $this->carrierFilter;
        }
        if ($this->startPortFilter !== null) {
            $exportQuery['start_port_id'] = $this->startPortFilter;
        }
        if ($this->endPortFilter !== null) {
            $exportQuery['end_port_id'] = $this->endPortFilter;
        }
        $exportUrl = route('shipment-schedule.public.export').(count($exportQuery) > 0 ? '?'.http_build_query($exportQuery) : '');

        return view('livewire.shipment-schedule.public-index', [
            'schedules' => $schedules,
            'providers' => $this->providers,
            'localPorts' => $this->localPorts,
            'exportUrl' => $exportUrl,
        ])->layout('components.layouts.public', ['title' => __('Public Shipment Schedule')]);
    }
}
