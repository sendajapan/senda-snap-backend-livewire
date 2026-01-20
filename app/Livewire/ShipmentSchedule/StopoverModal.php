<?php

declare(strict_types=1);

namespace App\Livewire\ShipmentSchedule;

use App\Models\Port;
use App\Models\ScheduleStopover;
use App\Services\ScheduleStopoverService;
use Livewire\Attributes\On;
use Livewire\Component;

class StopoverModal extends Component
{
    public bool $open = false;

    public ?ScheduleStopover $stopover = null;

    public bool $isEditing = false;

    public ?int $schedule_id = null;

    // Form fields
    public ?int $port_id = null;

    public ?string $stopover_eta = null;

    public ?string $stopover_etd = null;

    protected function rules(): array
    {
        return [
            'schedule_id' => ['required', 'exists:schedules,id'],
            'port_id' => ['required', 'exists:ports,id'],
            'stopover_eta' => ['nullable', 'date'],
            'stopover_etd' => ['nullable', 'date', 'after_or_equal:stopover_eta'],
        ];
    }

    protected function messages(): array
    {
        return [
            'schedule_id.required' => 'Schedule is required.',
            'schedule_id.exists' => 'Selected schedule does not exist.',
            'port_id.required' => 'Port is required.',
            'port_id.exists' => 'Selected port does not exist.',
            'stopover_eta.date' => 'Arrival (ETA) must be a valid date.',
            'stopover_etd.date' => 'Departure (ETD) must be a valid date.',
            'stopover_etd.after_or_equal' => 'Departure (ETD) must be after or equal to Arrival (ETA).',
        ];
    }

    #[On('open-stopover-modal')]
    public function openModal(?int $stopoverId = null, ?int $scheduleId = null): void
    {
        $this->resetForm();

        if ($stopoverId) {
            $this->stopover = ScheduleStopover::findOrFail($stopoverId);
            $this->isEditing = true;
            $this->schedule_id = $this->stopover->schedule_id;
            $this->port_id = $this->stopover->port_id;
            $this->stopover_eta = $this->stopover->stopover_eta ? $this->stopover->stopover_eta->format('Y-m-d') : null;
            $this->stopover_etd = $this->stopover->stopover_etd ? $this->stopover->stopover_etd->format('Y-m-d') : null;
        } else {
            $this->isEditing = false;
            $this->schedule_id = $scheduleId;
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
        $this->stopover = null;
        $this->isEditing = false;
        $this->schedule_id = null;
        $this->port_id = null;
        $this->stopover_eta = null;
        $this->stopover_etd = null;
        $this->resetValidation();
    }

    public function save(ScheduleStopoverService $stopoverService): void
    {
        $this->validate();

        try {
            $data = [
                'schedule_id' => $this->schedule_id,
                'port_id' => $this->port_id,
                'stopover_eta' => $this->stopover_eta ? date('Y-m-d 00:00:00', strtotime($this->stopover_eta)) : null,
                'stopover_etd' => $this->stopover_etd ? date('Y-m-d 00:00:00', strtotime($this->stopover_etd)) : null,
            ];

            if ($this->isEditing) {
                $stopoverService->update($this->stopover, $data);
                $message = __('Stopover updated successfully.');
            } else {
                $stopoverService->create($data, auth()->id());
                $message = __('Stopover created successfully.');
            }

            $this->dispatch('stopover-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Stopover save error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred. Please try again.'), type: 'error');
        }
    }

    public function getStopoverPortsProperty()
    {
        return Port::whereIn('port_type', ['Overseas Port', 'Local Port'])
            ->orderBy('port_name', 'asc')
            ->get();
    }

    public function render()
    {
        return view('livewire.shipment-schedule.stopover-modal', [
            'stopoverPorts' => $this->stopoverPorts,
        ]);
    }
}
