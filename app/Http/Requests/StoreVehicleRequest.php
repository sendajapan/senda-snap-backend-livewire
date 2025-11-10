<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVehicleRequest extends FormRequest
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
            'serial_number' => 'required|string|unique:vehicles,serial_number|max:255',
            'make' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'chassis_model' => 'required|string|max:255',
            'cc' => 'required|integer|min:0',
            'year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'color' => 'required|string|max:255',
            'vehicle_buy_date' => 'required|date',
            'auction_ship_number' => 'required|string|max:255',
            'net_weight' => 'required|numeric|min:0',
            'area' => 'required|string|max:255',
            'length' => 'required|numeric|min:0',
            'width' => 'required|numeric|min:0',
            'height' => 'required|numeric|min:0',
            'plate_number' => 'nullable|string|max:255',
            'buying_price' => 'required|numeric|min:0',
            'expected_yard_date' => 'required|date',
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
            'serial_number.required' => 'The serial number is required.',
            'serial_number.unique' => 'This serial number is already in use.',
            'make.required' => 'The vehicle make is required.',
            'model.required' => 'The vehicle model is required.',
            'chassis_model.required' => 'The chassis model is required.',
            'cc.required' => 'The engine capacity (CC) is required.',
            'cc.integer' => 'The engine capacity must be a number.',
            'year.required' => 'The vehicle year is required.',
            'year.integer' => 'The year must be a valid number.',
            'color.required' => 'The vehicle color is required.',
            'vehicle_buy_date.required' => 'The purchase date is required.',
            'vehicle_buy_date.date' => 'The purchase date must be a valid date.',
            'buying_price.required' => 'The buying price is required.',
            'buying_price.numeric' => 'The buying price must be a number.',
            'expected_yard_date.required' => 'The expected yard date is required.',
            'expected_yard_date.date' => 'The expected yard date must be a valid date.',
            'status.in' => 'The status must be one of: pending, in_yard, ready, sold.',
        ];
    }
}
