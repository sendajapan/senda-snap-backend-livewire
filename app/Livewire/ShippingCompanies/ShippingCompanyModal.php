<?php

declare(strict_types=1);

namespace App\Livewire\ShippingCompanies;

use App\Models\ShipLine;
use App\Services\ShipLineService;
use Livewire\Attributes\On;
use Livewire\Component;

class ShippingCompanyModal extends Component
{
    public bool $open = false;

    public ?ShipLine $shippingCompany = null;

    public bool $isEditing = false;

    // Form fields
    public string $line_name = '';

    public string $status = 'Active';

    protected function rules(): array
    {
        return [
            'line_name' => ['required', 'string', 'max:255'],
            'status' => ['sometimes', 'in:Active,Inactive'],
        ];
    }

    protected function messages(): array
    {
        return [
            'line_name.required' => 'Line name is required.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }

    #[On('open-shipping-company-modal')]
    public function openModal(?int $shippingCompanyId = null): void
    {
        $this->resetForm();

        if ($shippingCompanyId) {
            $this->shippingCompany = ShipLine::findOrFail($shippingCompanyId);
            $this->isEditing = true;
            $this->line_name = $this->shippingCompany->line_name;
            $this->status = $this->shippingCompany->status;
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
        $this->shippingCompany = null;
        $this->isEditing = false;
        $this->line_name = '';
        $this->status = 'Active';
        $this->resetValidation();
    }

    public function save(ShipLineService $shipLineService): void
    {
        $this->validate();

        try {
            $data = [
                'line_name' => $this->line_name,
                'status' => $this->status,
            ];

            if ($this->isEditing) {
                $shipLineService->update($this->shippingCompany, $data);
                $message = __('Shipping company updated successfully.');
            } else {
                $shipLineService->create($data);
                $message = __('Shipping company created successfully.');
            }

            $this->dispatch('shipping-company-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Shipping company save error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred. Please try again.'), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.shipping-companies.shipping-company-modal');
    }
}
