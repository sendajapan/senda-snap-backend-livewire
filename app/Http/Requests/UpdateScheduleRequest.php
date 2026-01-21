<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScheduleRequest extends FormRequest
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
            'vessel_name' => ['sometimes', 'required', 'string', 'max:255'],
            'voyage_no' => ['sometimes', 'required', 'string', 'max:255'],
            'carrier_1_id' => ['nullable', 'integer', 'exists:tbl_ship_line,id'],
            'carrier_2_id' => ['nullable', 'integer', 'exists:tbl_ship_line,id'],
            'carrier_3_id' => ['nullable', 'integer', 'exists:tbl_ship_line,id'],
            'start_port_id' => ['sometimes', 'required', 'integer', 'exists:ports,id'],
            'end_port_id' => ['sometimes', 'required', 'integer', 'exists:ports,id'],
            'eta' => ['sometimes', 'required', 'date'],
            'status' => ['sometimes', 'string', 'in:Waiting,In Transit,Arrived,Completed,Cancelled'],
            'comment' => ['nullable', 'string'],
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
            'vessel_name.required' => 'Vessel name is required.',
            'voyage_no.required' => 'Voyage number is required.',
            'start_port_id.required' => 'Start port is required.',
            'start_port_id.exists' => 'Selected start port does not exist.',
            'end_port_id.required' => 'End port is required.',
            'end_port_id.exists' => 'Selected end port does not exist.',
            'eta.required' => 'ETA (Estimated Time of Arrival) is required.',
            'eta.date' => 'ETA must be a valid date.',
        ];
    }
}
