<?php

declare(strict_types=1);

namespace App\Livewire\Ports;

use App\Models\Port;
use App\Services\PortService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class PortPreview extends Component
{
    public bool $open = false;

    public ?Port $port = null;

    #[On('open-port-preview')]
    public function openPreview(?int $portId, PortService $portService): void
    {
        if ($portId) {
            $this->port = $portService->getById($portId);
        } else {
            $this->port = null;
        }

        $this->open = true;
    }

    public function closePreview(): void
    {
        $this->open = false;
        $this->port = null;
    }

    public function editPort(): void
    {
        if ($this->port) {
            $this->dispatch('open-port-modal', portId: $this->port->id);
            $this->closePreview();
        }
    }

    public function deletePort(PortService $portService): void
    {
        if ($this->port) {
            try {
                $portService->delete($this->port);
                $this->dispatch('port-saved');
                $this->dispatch('notify', message: __('Port deleted successfully.'), type: 'success');
                $this->closePreview();
            } catch (\Exception $e) {
                \Log::error('Port delete error: '.$e->getMessage());
                $this->dispatch('notify', message: __('An error occurred while deleting the port.'), type: 'error');
            }
        }
    }

    public function canDelete(): bool
    {
        $currentUser = Auth::user();
        if (! $currentUser || ! $this->port) {
            return false;
        }

        // Only admin or manager can delete
        return in_array($currentUser->role, ['admin', 'manager']);
    }

    public function render()
    {
        return view('livewire.ports.port-preview');
    }
}
