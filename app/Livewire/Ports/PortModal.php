<?php

declare(strict_types=1);

namespace App\Livewire\Ports;

use App\Models\Port;
use App\Services\PortService;
use Livewire\Attributes\On;
use Livewire\Component;

class PortModal extends Component
{
    public bool $open = false;

    public ?Port $port = null;

    public bool $isEditing = false;

    // Form fields
    public string $port_name = '';

    public string $port_type = 'Auction';

    public string $port_address = '';

    protected function rules(): array
    {
        return [
            'port_name' => ['required', 'string', 'max:255'],
            'port_type' => ['required', 'in:Auction,Yard,Local Port,Overseas Port'],
            'port_address' => ['required', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'port_name.required' => 'Port name is required.',
            'port_type.required' => 'Port type is required.',
            'port_type.in' => 'Port type must be one of: Auction, Yard, Local Port, Overseas Port.',
            'port_address.required' => 'Port address is required.',
        ];
    }

    #[On('open-port-modal')]
    public function openModal(?int $portId = null): void
    {
        $this->resetForm();

        if ($portId) {
            $this->port = Port::findOrFail($portId);
            $this->isEditing = true;
            $this->port_name = $this->port->port_name;
            $this->port_type = $this->port->port_type;
            $this->port_address = $this->port->port_address;
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
        $this->port = null;
        $this->isEditing = false;
        $this->port_name = '';
        $this->port_type = 'Auction';
        $this->port_address = '';
        $this->resetValidation();
    }

    public function save(PortService $portService): void
    {
        $this->validate();

        try {
            $data = [
                'port_name' => $this->port_name,
                'port_type' => $this->port_type,
                'port_address' => $this->port_address,
            ];

            if ($this->isEditing) {
                $portService->update($this->port, $data);
                $message = __('Port updated successfully.');
            } else {
                $portService->create($data);
                $message = __('Port created successfully.');
            }

            $this->dispatch('port-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Port save error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred. Please try again.'), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.ports.port-modal');
    }
}
