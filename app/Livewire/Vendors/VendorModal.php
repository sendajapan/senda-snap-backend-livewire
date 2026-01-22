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

    // External vehicle database configuration
    public string $external_db_host = '';

    public string $external_db_port = '3306';

    public string $external_db_database = '';

    public string $external_db_username = '';

    public string $external_db_password = '';

    public string $external_image_path = '';

    public string $external_image_base_url = '';

    public function mount(): void
    {
        // Only admin can access vendors
        if (Auth::user()?->role !== 'admin') {
            abort(403, 'Only administrators can access vendor management.');
        }
    }

    protected function rules(): array
    {
        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', \Illuminate\Validation\Rule::unique('vendors', 'email')->ignore($this->vendor->id ?? null)],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'status' => ['required', 'in:active,inactive'],
            // External vehicle database configuration
            'external_db_host' => ['required', 'string', 'max:255'],
            'external_db_port' => ['nullable', 'string', 'max:10'],
            'external_db_database' => ['required', 'string', 'max:255'],
            'external_db_username' => ['required', 'string', 'max:255'],
            'external_image_path' => ['required', 'string', 'max:500'],
            'external_image_base_url' => ['required', 'url', 'max:500'],
        ];

        // Password is required for new vendors, optional for updates
        if ($this->isEditing) {
            $rules['external_db_password'] = ['nullable', 'string'];
        } else {
            $rules['external_db_password'] = ['required', 'string'];
        }

        return $rules;
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
            'external_db_host.required' => 'External database host is required.',
            'external_db_database.required' => 'External database name is required.',
            'external_db_username.required' => 'External database username is required.',
            'external_db_password.required' => 'External database password is required.',
            'external_db_password.nullable' => 'Leave password blank to keep current password.',
            'external_image_path.required' => 'External image path is required.',
            'external_image_base_url.required' => 'External image base URL is required.',
            'external_image_base_url.url' => 'External image base URL must be a valid URL.',
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
            $this->external_db_host = $this->vendor->external_db_host ?? '';
            $this->external_db_port = $this->vendor->external_db_port ?? '3306';
            $this->external_db_database = $this->vendor->external_db_database ?? '';
            $this->external_db_username = $this->vendor->external_db_username ?? '';
            // Don't populate password for security - user must re-enter if changing
            $this->external_db_password = '';
            $this->external_image_path = $this->vendor->external_image_path ?? '';
            $this->external_image_base_url = $this->vendor->external_image_base_url ?? '';
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
        $this->external_db_host = '';
        $this->external_db_port = '3306';
        $this->external_db_database = '';
        $this->external_db_username = '';
        $this->external_db_password = '';
        $this->external_image_path = '';
        $this->external_image_base_url = '';
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
                'external_db_host' => $this->external_db_host,
                'external_db_port' => $this->external_db_port,
                'external_db_database' => $this->external_db_database,
                'external_db_username' => $this->external_db_username,
                'external_db_password' => $this->external_db_password,
                'external_image_path' => $this->external_image_path,
                'external_image_base_url' => $this->external_image_base_url,
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
