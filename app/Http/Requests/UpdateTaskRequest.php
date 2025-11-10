<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'work_date' => 'sometimes|date',
            'work_time' => 'sometimes|date_format:H:i',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'vehicle_id' => 'sometimes|exists:vehicles,id',
            'assigned_to' => 'sometimes|exists:users,id',
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
            'title.string' => 'The task title must be a string.',
            'title.max' => 'The task title may not be greater than 255 characters.',
            'description.string' => 'The task description must be a string.',
            'work_date.date' => 'The work date must be a valid date.',
            'work_time.date_format' => 'The work time must be in HH:MM format.',
            'priority.in' => 'The priority must be one of: low, medium, high, urgent.',
            'vehicle_id.exists' => 'The selected vehicle does not exist.',
            'assigned_to.exists' => 'The selected user does not exist.',
            'due_date.date' => 'The due date must be a valid date.',
            'due_date.after_or_equal' => 'The due date must be on or after the work date.',
        ];
    }
}
