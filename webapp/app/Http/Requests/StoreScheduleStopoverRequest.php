<?php

declare(strict_types=1);

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScheduleStopoverRequest extends FormRequest
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
        // schedule_id is optional if provided via route parameter
        return [
            'schedule_id' => ['sometimes', 'required', 'integer', 'exists:schedules,id'],
            'port_id' => ['required', 'integer', 'exists:ports,id'],
            'stopover_eta' => ['nullable', 'date'],
            'stopover_etd' => ['nullable', 'date'],
            'status' => ['sometimes', 'string', 'in:Waiting,In Transit,Arrived,Completed,Cancelled'],
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
            'schedule_id.required' => 'Schedule ID is required.',
            'schedule_id.exists' => 'Selected schedule does not exist.',
            'port_id.required' => 'Port is required.',
            'port_id.exists' => 'Selected port does not exist.',
            'stopover_eta.date' => 'Stopover ETA must be a valid date.',
            'stopover_etd.date' => 'Stopover ETD must be a valid date.',
        ];
    }
}
