<?php

declare(strict_types=1);

namespace App\Livewire\Vendors;

use App\Models\Vendor;
use App\Services\VendorService;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class VendorModal extends Component
{
    public bool $open = false;

    public ?Vendor $vendor = null;

    public bool $isEditing = false;

    // Form fields
    public string $name = '';

    public string $email = '';

    public string $phone = '';

    public string $address = '';

    public string $website = '';

    public string $status = 'active';

    public function mount(): void
    {
        // Only admin can access vendors
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Only administrators can access vendor management.');
        }
    }

    protected function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('vendors', 'email')->ignore($this->vendor->id ?? null)],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
        ];
    }

    protected function messages(): array
    {
        return [
            'name.required' => 'Vendor name is required.',
            'name.max' => 'Vendor name must not exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already registered.',
            'website.url' => 'Website must be a valid URL.',
            'status.required' => 'Status is required.',
            'status.in' => 'Status must be either active or inactive.',
        ];
    }

    #[On('open-vendor-modal')]
    public function openModal(?int $vendorId = null): void
    {
        $this->resetForm();

        if ($vendorId) {
            $this->vendor = Vendor::findOrFail($vendorId);
            $this->isEditing = true;
            $this->name = $this->vendor->name;
            $this->email = $this->vendor->email;
            $this->phone = $this->vendor->phone ?? '';
            $this->address = $this->vendor->address ?? '';
            $this->website = $this->vendor->website ?? '';
            $this->status = $this->vendor->status;
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
        $this->vendor = null;
        $this->isEditing = false;
        $this->name = '';
        $this->email = '';
        $this->phone = '';
        $this->address = '';
        $this->website = '';
        $this->status = 'active';
        $this->resetValidation();
    }

    public function save(VendorService $vendorService): void
    {
        $this->validate();

        try {
            $data = [
                'name' => $this->name,
                'email' => $this->email,
                'phone' => $this->phone,
                'address' => $this->address,
                'website' => $this->website,
                'status' => $this->status,
            ];

            if ($this->isEditing) {
                $vendorService->update($this->vendor, $data);
                $message = __('Vendor updated successfully.');
            } else {
                $vendorService->create($data);
                $message = __('Vendor created successfully.');
            }

            $this->dispatch('vendor-saved');
            $this->dispatch('notify', message: $message, type: 'success');
            $this->closeModal();
        } catch (\Exception $e) {
            \Log::error('Vendor save error: '.$e->getMessage());
            $this->dispatch('notify', message: __('An error occurred. Please try again.'), type: 'error');
        }
    }

    public function render()
    {
        return view('livewire.vendors.vendor-modal');
    }
}
