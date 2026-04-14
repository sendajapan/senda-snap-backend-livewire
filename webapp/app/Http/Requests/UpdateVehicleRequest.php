<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVehicleRequest extends FormRequest
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
            'serial_number' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('vehicles', 'serial_number')->ignore($this->route('vehicle')),
            ],
            'make' => 'sometimes|string|max:255',
            'model' => 'sometimes|string|max:255',
            'chassis_model' => 'sometimes|string|max:255',
            'cc' => 'sometimes|integer|min:0',
            'year' => 'sometimes|integer|min:1900|max:'.(date('Y') + 1),
            'color' => 'sometimes|string|max:255',
            'vehicle_buy_date' => 'sometimes|date',
            'auction_ship_number' => 'sometimes|string|max:255',
            'net_weight' => 'sometimes|numeric|min:0',
            'area' => 'sometimes|string|max:255',
            'length' => 'sometimes|numeric|min:0',
            'width' => 'sometimes|numeric|min:0',
            'height' => 'sometimes|numeric|min:0',
            'plate_number' => 'nullable|string|max:255',
            'buying_price' => 'sometimes|numeric|min:0',
            'expected_yard_date' => 'sometimes|date',
            'rikso_from' => 'nullable|string|max:255',
            'rikso_to' => 'nullable|string|max:255',
            'rikso_cost' => 'nullable|numeric|min:0',
            'rikso_company' => 'nullable|string|max:255',
            'auction_sheet' => 'nullable|string|max:255',
            'tohon_copy' => 'nullable|string|max:255',
            'status' => 'sometimes|in:pending,in_yard,ready,sold',
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
            'serial_number.unique' => 'This serial number is already in use.',
            'cc.integer' => 'The engine capacity must be a number.',
            'year.integer' => 'The year must be a valid number.',
            'vehicle_buy_date.date' => 'The purchase date must be a valid date.',
            'buying_price.numeric' => 'The buying price must be a number.',
            'expected_yard_date.date' => 'The expected yard date must be a valid date.',
            'status.in' => 'The status must be one of: pending, in_yard, ready, sold.',
        ];
    }
}
