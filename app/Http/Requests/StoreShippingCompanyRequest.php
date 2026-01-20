<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreShippingCompanyRequest extends FormRequest
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
            'line_name' => ['required', 'string', 'max:255'],
            'status' => ['sometimes', 'in:Active,Inactive'],
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
            'line_name.required' => 'Line name is required.',
            'line_name.max' => 'Line name must not exceed 255 characters.',
            'status.in' => 'Status must be either Active or Inactive.',
        ];
    }
}
