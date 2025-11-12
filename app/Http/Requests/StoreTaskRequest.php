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
            'description' => 'nullable|string',
            'work_date' => 'nullable|date',
            'work_time' => 'nullable',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|array',
            'assigned_to.*' => 'exists:users,id',
            'due_date' => 'nullable|date',
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
            'title.required' => 'Task title is required.',
            'title.max' => 'Task title must not exceed 255 characters.',
            'priority.required' => 'Priority is required.',
            'priority.in' => 'Priority must be one of: low, medium, high, urgent.',
            'assigned_to.*.exists' => 'One or more selected users do not exist.',
            'work_date.date' => 'Work date must be a valid date.',
            'due_date.date' => 'Due date must be a valid date.',
        ];
    }
}
