<?php

declare(strict_types=1);

namespace App\Livewire\ShipmentSchedule;

use App\Models\Port;
use App\Models\Schedule;
use App\Models\ScheduleStopover;
use App\Models\ShippingCompany;
use App\Services\ScheduleService;
use App\Services\ScheduleStopoverService;
use Livewire\Attributes\On;
use Livewire\Component;

class ScheduleModal extends Component
{
    public bool $open = false;

    public ?Schedule $schedule = null;

    public bool $isEditing = false;

    // Form fields
    public string $vessel_name = '';

    public string $voyage_no = '';

    public ?int $carrier_1_id = null;

    public ?int $carrier_2_id = null;

    public ?int $carrier_3_id = null;

    public ?int $start_port_id = null;

    public ?int $end_port_id = null;

    public string $eta = '';

    public ?string $comment = null;

    // Stopover management
    public array $stopovers = [];

    public bool $showingAddStopover = false;

    public ?int $editingStopoverIndex = null;

    public ?int $newStopoverPortId = null;

    public ?string $newStopoverEta = null;

    public ?string $newStopoverEtd = null;

    protected function rules(): array
    {
        return [
            'vessel_name' => ['required', 'string', 'max:255'],
            'voyage_no' => ['required', 'string', 'max:255'],
            'carrier_1_id' => ['nullable', 'exists:shipping_companies,id'],
            'carrier_2_id' => ['nullable', 'exists:shipping_companies,id'],
            'carrier_3_id' => ['nullable', 'exists:shipping_companies,id'],
            'start_port_id' => ['required', 'exists:ports,id'],
            'end_port_id' => ['required', 'exists:ports,id'],
            'eta' => ['required', 'string', 'max:255'],
            'comment' => ['nullable', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'vessel_name.required' => 'Vessel name is required.',
            'voyage_no.required' => 'Voyage number is required.',
            'start_port_id.required' => 'Start port is required.',
            'start_port_id.exists' => 'Selected start port does not exist.',
            'end_port_id.required' => 'End port is required.',
            'end_port_id.exists' => 'Selected end port does not exist.',
            'eta.required' => 'ETA is required.',
            'carrier_1_id.exists' => 'Selected carrier 1 does not exist.',
            'carrier_2_id.exists' => 'Selected carrier 2 does not exist.',
            'carrier_3_id.exists' => 'Selected carrier 3 does not exist.',
        ];
    }

    #[On('open-schedule-modal')]
    public function openModal(?int $scheduleId = null): void
    {
        $this->resetForm();

        if ($scheduleId) {
            $this->schedule = Schedule::with('stopovers.port')->findOrFail($scheduleId);
            $this->isEditing = true;
            $this->vessel_name = $this->schedule->vessel_name;
            $this->voyage_no = $this->schedule->voyage_no;
            $this->carrier_1_id = $this->schedule->carrier_1_id;
            $this->carrier_2_id = $this->schedule->carrier_2_id;
            $this->carrier_3_id = $this->schedule->carrier_3_id;
            $this->start_port_id = $this->schedule->start_port_id;
            $this->end_port_id = $this->schedule->end_port_id;
            $this->eta = $this->schedule->eta;
            $this->comment = $this->schedule->comment;
            $this->loadExistingStopovers();
        } else {
            $this->isEditing = false;
        }

        $this->open = true;
    }

    public function closeModal(): void
    {
        $this->open = false;
        $this->resetForm();
    }

    public function resetForm(): void
    {
        $this->schedule = null;
        $this->isEditing = false;
        $this->vessel_name = '';
        $this->voyage_no = '';
        $this->carrier_1_id = null;
        $this->carrier_2_id = null;
        $this->carrier_3_id = null;
        $this->start_port_id = null;
        $this->end_port_id = null;
        $this->eta = '';
        $this->comment = null;
        $this->stopovers = [];
        $this->showingAddStopover = false;
        $this->editingStopoverIndex = null;
        $this->newStopoverPortId = null;
        $this->newStopoverEta = null;
        $this->newStopoverEtd = null;
        $this->resetValidation();
    }

    public function loadExistingStopovers(): void
    {
        $this->stopovers = $this->schedule->stopovers->map(function ($stopover) {
            return [
                'id' => $stopover->id,
                'port_id' => $stopover->port_id,
                'stopover_eta' => $stopover->stopover_eta ? $stopover->stopover_eta->format('Y-m-d') : null,
                'stopover_etd' => $stopover->stopover_etd ? $stopover->stopover_etd->format('Y-m-d') : null,
            ];
        })->toArray();
    }

    public function addStopover(): void
    {
        $this->validate([
            'newStopoverPortId' => ['required', 'exists:ports,id'],
            'newStopoverEta' => ['nullable', 'date'],
            'newStopoverEtd' => ['nullable', 'date', 'after_or_equal:newStopoverEta'],
        ], [
            'newStopoverPortId.required' => 'Port is required.',
            'newStopoverPortId.exists' => 'Selected port does not exist.',
            'newStopoverEta.date' => 'Arrival (ETA) must be a valid date.',
            'newStopoverEtd.date' => 'Departure (ETD) must be a valid date.',
            'newStopoverEtd.after_or_equal' => 'Departure (ETD) must be after or equal to Arrival (ETA).',
        ]);

        $this->stopovers[] = [
            'id' => null,
            'port_id' => $this->newStopoverPortId,
            'stopover_eta' => $this->newStopoverEta,
            'stopover_etd' => $this->newStopoverEtd,
        ];

        $this->cancelAddStopover();
    }

    public function editStopover(int $index): void
    {
        if (isset($this->stopovers[$index])) {
            $this->editingStopoverIndex = $index;
            $this->newStopoverPortId = $this->stopovers[$index]['port_id'];
            $this->newStopoverEta = $this->stopovers[$index]['stopover_eta'];
            $this->newStopoverEtd = $this->stopovers[$index]['stopover_etd'];
            $this->showingAddStopover = false;
        }
    }

    public function updateStopover(): void
    {
        if ($this->editingStopoverIndex === null || ! isset($this->stopovers[$this->editingStopoverIndex])) {
            return;
        }

        $this->validate([
            'newStopoverPortId' => ['required', 'exists:ports,id'],
            'newStopoverEta' => ['nullable', 'date'],
            'newStopoverEtd' => ['nullable', 'date', 'after_or_equal:newStopoverEta'],
        ], [
            'newStopoverPortId.required' => 'Port is required.',
            'newStopoverPortId.exists' => 'Selected port does not exist.',
            'newStopoverEta.date' => 'Stopover ETA must be a valid date.',
            'newStopoverEtd.date' => 'Stopover ETD must be a valid date.',
            'newStopoverEtd.after_or_equal' => 'Stopover ETD must be after or equal to ETA.',
        ]);

        $this->stopovers[$this->editingStopoverIndex] = [
            'id' => $this->stopovers[$this->editingStopoverIndex]['id'],
            'port_id' => $this->newStopoverPortId,
            'stopover_eta' => $this->newStopoverEta,
            'stopover_etd' => $this->newStopoverEtd,
        ];

        $this->cancelEditStopover();
    }

    public function removeStopover(int $index): void
    {
        if (isset($this->stopovers[$index])) {
            unset($this->stopovers[$index]);
            $this->stopovers = array_values($this->stopovers);
        }
    }

    public function cancelAddStopover(): void
    {
        $this->showingAddStopover = false;
        $this->newStopoverPortId = null;
        $this->newStopoverEta = null;
        $this->newStopoverEtd = null;
        $this->resetValidation(['newStopoverPortId', 'newStopoverEta', 'newStopoverEtd']);
    }

    public function cancelEditStopover(): void
    {
        $this->editingStopoverIndex = null;
        $this->newStopoverPortId = null;
        $this->newStopoverEta = null;
        $this->newStopoverEtd = null;
        $this->resetValidation(['newStopoverPortId', 'newStopoverEta', 'newStopoverEtd']);
    }

    public function save(ScheduleService $scheduleService, ScheduleStopoverService $stopoverService): void
    {
        $this->validate();

        try {
            $data = [
                'vessel_name' => $this->vessel_name,
                'voyage_no' => $this->voyage_no,
                'carrier_1_id' => $this->carrier_1_id,
                'carrier_2_id' => $this->carrier_2_id,
                'carrier_3_id' => $this->carrier_3_id,
                'start_port_id' => $this->start_port_id,
                'end_port_id' => $this->end_port_id,
                'eta' => $this->eta,
                'comment' => $this->comment,
            ];

            // Save schedule
            if ($this->isEditing) {
                $schedule = $scheduleService->update($this->schedule, $data);
                $message = __('Schedule updated successfully.');
            } else {
                $schedule = $scheduleService->create($data, auth()->id());
                $message = __('Schedule created successfully.');
            }

            // Reload schedule with stopovers
            $schedule->load('stopovers');

            // Get existing stopover IDs
            $existingIds = $schedule->stopovers->pluck('id')->toArray();
            $currentIds = collect($this->stopovers)->pluck('id')->filter()->toArray();

            // Delete stopovers that were removed
            $toDelete = array_diff($existingIds, $currentIds);
            foreach ($toDelete as $id) {
                $stopover = ScheduleStopover::find($id);
                if ($stopover) {
                    $stopoverService->delete($stopover);
                }
            }

            // Save/update stopovers
            foreach ($this->stopovers as $stopoverData) {
                if (isset($stopoverData['id']) && $stopoverData['id'] !== null) {
                    // Update existing
                    $stopover = ScheduleStopover::find($stopoverData['id']);
                    if ($stopover) {
                        $stopoverService->update($stopover, [
                            'port_id' => $stopoverData['port_id'],
                            'stopover_eta' => $stopoverData['stopover_eta'] ? date('Y-m-d 00:00:00', strtotime($stopoverData['stopover_eta'])) : null,
                            'stopover_etd' => $stopoverData['stopover_etd'] ? date('Y-m-d 00:00:00', strtotime($stopoverData['stopover_etd'])) : null,
                        ]);
                    }
                } else {
                    // Create new
                    $stopoverService->create([
                        'schedule_id' => $schedule->id,
                        'port_id' => $stopoverData['port_id'],
                        'stopover_eta' => $stopoverData['stopover_eta'] ? date('Y-m-d 00:00:00', strtotime($stopoverData['stopover_eta'])) : null,
                        'stopover_etd' => $stopoverData['stopover_etd'] ? date('Y-m-d 00:00:00', strtotime($stopoverData['stopover_etd'])) : null,
                    ], auth()->id());
                }
            }

            $this->dispatch('schedule-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Schedule save error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred. Please try again.'), type: 'error');
        }
    }

    public function getProvidersProperty()
    {
        return ShippingCompany::where('company_type', 'PROVIDER')
            ->where('company_status', 'Active')
            ->orderBy('company_name', 'asc')
            ->get();
    }

    public function getLocalPortsProperty()
    {
        return Port::where('port_type', 'Local Port')
            ->orderBy('port_name', 'asc')
            ->get();
    }

    public function getStopoverPortsProperty()
    {
        return Port::whereIn('port_type', ['Overseas Port', 'Local Port'])
            ->orderBy('port_name', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.shipment-schedule.schedule-modal', [
            'providers' => $this->providers,
            'localPorts' => $this->localPorts,
            'stopoverPorts' => $this->stopoverPorts,
        ]);
    }
}
