<?php

declare(strict_types=1);

namespace App\Livewire\ShippingCompanies;

use App\Models\ShippingCompany;
use App\Services\ShippingCompanyService;
use Livewire\Attributes\On;
use Livewire\Component;

class ShippingCompanyModal extends Component
{
    public bool $open = false;

    public ?ShippingCompany $shippingCompany = null;

    public bool $isEditing = false;

    // Form fields
    public string $company_name = '';

    public string $company_type = 'Transporter';

    public string $company_status = 'Active';

    public ?string $company_name_jp = null;

    public ?int $per_m3 = null;

    public ?int $per_container = null;

    public ?string $zip = null;

    public ?string $country_name = null;

    public ?string $state = null;

    public ?string $city = null;

    public ?string $address = null;

    protected function rules(): array
    {
        return [
            'company_name' => ['required', 'string', 'max:255'],
            'company_type' => ['required', 'in:Transporter,Shipping Line,Workshop,PROVIDER,EXPENSE,COURIER'],
            'company_status' => ['sometimes', 'in:Active,Inactive'],
            'company_name_jp' => ['nullable', 'string', 'max:255'],
            'per_m3' => ['nullable', 'integer', 'min:0'],
            'per_container' => ['nullable', 'integer', 'min:0'],
            'zip' => ['nullable', 'string', 'max:20'],
            'country_name' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string'],
        ];
    }

    protected function messages(): array
    {
        return [
            'company_name.required' => 'Company name is required.',
            'company_type.required' => 'Company type is required.',
            'company_type.in' => 'Company type must be one of: Transporter, Shipping Line, Workshop, PROVIDER, EXPENSE, COURIER.',
            'company_status.in' => 'Company status must be either Active or Inactive.',
            'per_m3.integer' => 'Per m³ must be an integer.',
            'per_m3.min' => 'Per m³ must be at least 0.',
            'per_container.integer' => 'Per container must be an integer.',
            'per_container.min' => 'Per container must be at least 0.',
        ];
    }

    #[On('open-shipping-company-modal')]
    public function openModal(?int $shippingCompanyId = null): void
    {
        $this->resetForm();

        if ($shippingCompanyId) {
            $this->shippingCompany = ShippingCompany::findOrFail($shippingCompanyId);
            $this->isEditing = true;
            $this->company_name = $this->shippingCompany->company_name;
            $this->company_type = $this->shippingCompany->company_type;
            $this->company_status = $this->shippingCompany->company_status;
            $this->company_name_jp = $this->shippingCompany->company_name_jp;
            $this->per_m3 = $this->shippingCompany->per_m3;
            $this->per_container = $this->shippingCompany->per_container;
            $this->zip = $this->shippingCompany->zip;
            $this->country_name = $this->shippingCompany->country_name;
            $this->state = $this->shippingCompany->state;
            $this->city = $this->shippingCompany->city;
            $this->address = $this->shippingCompany->address;
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
        $this->company_name = '';
        $this->company_type = 'Transporter';
        $this->company_status = 'Active';
        $this->company_name_jp = null;
        $this->per_m3 = null;
        $this->per_container = null;
        $this->zip = null;
        $this->country_name = null;
        $this->state = null;
        $this->city = null;
        $this->address = null;
        $this->resetValidation();
    }

    public function save(ShippingCompanyService $shippingCompanyService): void
    {
        $this->validate();

        try {
            $data = [
                'company_name' => $this->company_name,
                'company_type' => $this->company_type,
                'company_status' => $this->company_status,
                'company_name_jp' => $this->company_name_jp ?: null,
                'per_m3' => $this->per_m3,
                'per_container' => $this->per_container,
                'zip' => $this->zip ?: null,
                'country_name' => $this->country_name ?: null,
                'state' => $this->state ?: null,
                'city' => $this->city ?: null,
                'address' => $this->address ?: null,
            ];

            if ($this->isEditing) {
                $shippingCompanyService->update($this->shippingCompany, $data);
                $message = __('Shipping company updated successfully.');
            } else {
                $shippingCompanyService->create($data);
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
