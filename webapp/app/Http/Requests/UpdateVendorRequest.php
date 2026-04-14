<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVendorRequest extends FormRequest
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
            'name' => ['sometimes', 'string', 'max:255'],
            'email' => ['sometimes', 'email', 'max:255', Rule::unique('vendors', 'email')->ignore($this->vendor)],
            'phone' => ['nullable', 'string', 'max:255'],
            'address' => ['nullable', 'string', 'max:255'],
            'city' => ['nullable', 'string', 'max:255'],
            'state' => ['nullable', 'string', 'max:255'],
            'country' => ['nullable', 'string', 'max:255'],
            'zip' => ['nullable', 'string', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'status' => ['sometimes', 'in:active,inactive'],
            // External vehicle database configuration (optional on update, but must be complete if provided)
            'external_db_host' => ['sometimes', 'required_with:external_db_database', 'string', 'max:255'],
            'external_db_port' => ['nullable', 'string', 'max:10'],
            'external_db_database' => ['sometimes', 'required_with:external_db_host', 'string', 'max:255'],
            'external_db_username' => ['sometimes', 'required_with:external_db_host', 'string', 'max:255'],
            'external_db_password' => ['nullable', 'string'], // Optional - leave blank to keep current
            'external_image_path' => ['sometimes', 'required_with:external_db_host', 'string', 'max:500'],
            'external_image_base_url' => ['sometimes', 'required_with:external_db_host', 'url', 'max:500'],
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
            'name.max' => 'Vendor name must not exceed 255 characters.',
            'email.email' => 'Email must be a valid email address.',
            'email.unique' => 'This email is already registered.',
            'website.url' => 'Website must be a valid URL.',
            'status.in' => 'Status must be either active or inactive.',
            'external_db_host.required_with' => 'External database host is required when updating external configuration.',
            'external_db_database.required_with' => 'External database name is required when updating external configuration.',
            'external_db_username.required_with' => 'External database username is required when updating external configuration.',
            'external_db_password.required_with' => 'External database password is required when updating external configuration.',
            'external_image_path.required_with' => 'External image path is required when updating external configuration.',
            'external_image_base_url.required_with' => 'External image base URL is required when updating external configuration.',
            'external_image_base_url.url' => 'External image base URL must be a valid URL.',
        ];
    }
}
