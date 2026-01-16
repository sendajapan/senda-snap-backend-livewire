<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShippingCompanyRequest extends FormRequest
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
            'company_name' => ['sometimes', 'required', 'string', 'max:255'],
            'company_type' => ['sometimes', 'required', 'in:Transporter,Shipping Line,Workshop,PROVIDER,EXPENSE,COURIER'],
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

    /**
     * Get custom error messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'company_name.required' => 'Company name is required.',
            'company_name.max' => 'Company name must not exceed 255 characters.',
            'company_type.required' => 'Company type is required.',
            'company_type.in' => 'Company type must be one of: Transporter, Shipping Line, Workshop, PROVIDER, EXPENSE, COURIER.',
            'company_status.in' => 'Company status must be either Active or Inactive.',
            'per_m3.integer' => 'Per m³ must be an integer.',
            'per_m3.min' => 'Per m³ must be at least 0.',
            'per_container.integer' => 'Per container must be an integer.',
            'per_container.min' => 'Per container must be at least 0.',
        ];
    }
}
