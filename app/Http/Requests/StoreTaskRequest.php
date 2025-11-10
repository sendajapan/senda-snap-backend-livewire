<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTaskRequest extends FormRequest
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
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'work_date' => 'required|date',
            'work_time' => 'required|date_format:H:i',
            'priority' => 'required|in:low,medium,high,urgent',
            'vehicle_id' => 'required|exists:vehicles,id',
            'assigned_to' => 'required|exists:users,id',
            'due_date' => 'nullable|date|after_or_equal:work_date',
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
            'title.required' => 'The task title is required.',
            'description.required' => 'The task description is required.',
            'work_date.required' => 'The work date is required.',
            'work_date.date' => 'The work date must be a valid date.',
            'work_time.required' => 'The work time is required.',
            'work_time.date_format' => 'The work time must be in HH:MM format.',
            'priority.required' => 'The priority is required.',
            'priority.in' => 'The priority must be one of: low, medium, high, urgent.',
            'vehicle_id.required' => 'The vehicle is required.',
            'vehicle_id.exists' => 'The selected vehicle does not exist.',
            'assigned_to.required' => 'The assigned user is required.',
            'assigned_to.exists' => 'The selected user does not exist.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after_or_equal' => 'The due date must be on or after the work date.',
        ];
    }
}
