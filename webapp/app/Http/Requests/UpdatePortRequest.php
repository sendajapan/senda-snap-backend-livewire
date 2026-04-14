<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePortRequest extends FormRequest
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
            'port_name' => ['sometimes', 'required', 'string', 'max:255'],
            'port_type' => ['sometimes', 'required', 'in:Auction,Yard,Local Port,Overseas Port'],
            'port_address' => ['sometimes', 'required', 'string'],
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
            'port_name.required' => 'Port name is required.',
            'port_name.max' => 'Port name must not exceed 255 characters.',
            'port_type.required' => 'Port type is required.',
            'port_type.in' => 'Port type must be one of: Auction, Yard, Local Port, Overseas Port.',
            'port_address.required' => 'Port address is required.',
        ];
    }
}
