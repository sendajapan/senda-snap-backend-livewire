<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVendorRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:vendors,email'],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'status' => ['nullable', 'in:active,inactive'],
            // External vehicle database configuration (required)
            'external_db_host' => ['required', 'string', 'max:255'],
            'external_db_port' => ['nullable', 'string', 'max:10'],
            'external_db_database' => ['required', 'string', 'max:255'],
            'external_db_username' => ['required', 'string', 'max:255'],
            'external_db_password' => ['required', 'string'],
            'external_image_path' => ['required', 'string', 'max:500'],
            'external_image_base_url' => ['required', 'url', 'max:500'],
        ];
    }

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Vendor name is required.',
            'name.max' => 'Vendor name must not exceed 255 characters.',
            'email.required' => 'Email is required.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already registered.',
            'website.url' => 'Website must be a valid URL.',
            'status.in' => 'Status must be either active or inactive.',
            'external_db_host.required' => 'External database host is required.',
            'external_db_database.required' => 'External database name is required.',
            'external_db_username.required' => 'External database username is required.',
            'external_db_password.required' => 'External database password is required.',
            'external_image_path.required' => 'External image path is required.',
            'external_image_base_url.required' => 'External image base URL is required.',
            'external_image_base_url.url' => 'External image base URL must be a valid URL.',
        ];
    }
}
