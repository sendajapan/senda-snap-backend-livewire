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
            'description' => 'nullable|string',
            'work_date' => 'sometimes|date',
            'work_time' => 'nullable',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'assigned_to' => 'sometimes|array',
            'assigned_to.*' => 'exists:users,id',
            'due_date' => 'nullable|date',
            // attachments
            'attachments_update' => 'sometimes|boolean',
            'attachments' => 'sometimes|array',
            'attachments.*' => 'file|max:10240',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'title.max' => 'Task title must not exceed 255 characters.',
            'priority.in' => 'Priority must be one of: low, medium, high, urgent.',
            'assigned_to.*.exists' => 'One or more selected users do not exist.',
            'work_date.date' => 'Work date must be a valid date.',
            'due_date.date' => 'Due date must be a valid date.',
            'attachments.array' => 'Attachments must be an array of files.',
            'attachments.*.file' => 'Each attachment must be a file.',
            'attachments.*.max' => 'Each attachment must not be larger than 10MB.',
        ];
    }
}
