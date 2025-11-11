<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Task;
use App\Models\TaskAttachment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments']);

        // Search functionality
        if ($request->has('search')) {
            $search = $request->get('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }

        // Filter by priority
        if ($request->has('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        // Filter by assigned user
        if ($request->has('assigned_to')) {
            $query->whereHas('assignedUsers', function ($q) use ($request) {
                $q->where('users.id', $request->get('assigned_to'));
            });
        }

        // Filter by date range
        if ($request->has('date_from')) {
            $query->where('work_date', '>=', $request->get('date_from'));
        }
        if ($request->has('date_to')) {
            $query->where('work_date', '<=', $request->get('date_to'));
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return $this->successResponse('Tasks retrieved successfully', [
            'tasks' => $tasks->items(),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function store(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'work_date' => 'nullable|date',
            'work_time' => 'nullable',
            'priority' => 'required|in:low,medium,high,urgent',
            'assigned_to' => 'nullable|array',
            'assigned_to.*' => 'exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        $task = Task::create([
            'title' => $request->title,
            'description' => $request->description,
            'work_date' => $request->work_date,
            'work_time' => $request->work_time,
            'priority' => $request->priority,
            'created_by' => auth()->id(),
            'due_date' => $request->due_date,
        ]);

        // Assign users to task
        if ($request->has('assigned_to') && is_array($request->assigned_to)) {
            $task->assignedUsers()->sync($request->assigned_to);
        }

        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $this->successResponse('Task created successfully', [
            'task' => $task,
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $this->successResponse('Task retrieved successfully', [
            'task' => $task,
        ]);
    }

    public function update(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'title' => 'sometimes|string|max:255',
            'description' => 'nullable|string',
            'work_date' => 'sometimes|date',
            'work_time' => 'nullable',
            'priority' => 'sometimes|in:low,medium,high,urgent',
            'assigned_to' => 'sometimes|array',
            'assigned_to.*' => 'exists:users,id',
            'due_date' => 'nullable|date',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        $task->update($request->only([
            'title',
            'description',
            'work_date',
            'work_time',
            'priority',
            'due_date',
        ]));

        // Update assigned users if provided
        if ($request->has('assigned_to') && is_array($request->assigned_to)) {
            $task->assignedUsers()->sync($request->assigned_to);
        }

        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $this->successResponse('Task updated successfully', [
            'task' => $task,
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        // Delete associated attachments
        foreach ($task->attachments as $attachment) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        $task->delete();

        return $this->successResponse('Task deleted successfully');
    }

    public function assign(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'assigned_to' => 'required|array',
            'assigned_to.*' => 'exists:users,id',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        $task->assignedUsers()->sync($request->assigned_to);

        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $this->successResponse('Task assigned successfully', [
            'task' => $task,
        ]);
    }

    public function updateStatus(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|in:pending,running,completed,cancelled',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        $updateData = ['status' => $request->status];

        if ($request->status === 'completed') {
            $updateData['completed_at'] = now();
        } else {
            $updateData['completed_at'] = null;
        }

        $task->update($updateData);

        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $this->successResponse('Task status updated successfully', [
            'task' => $task,
        ]);
    }

    public function uploadAttachment(Request $request, Task $task): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'file' => 'required|file|max:10240',
            'file_name' => 'sometimes|string|max:255',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        $file = $request->file('file');
        $filePath = $file->store('task-attachments', 'public');
        $fileName = $request->file_name ?? $file->getClientOriginalName();
        $fileType = $file->getClientMimeType();

        $attachment = $task->attachments()->create([
            'file_path' => $filePath,
            'file_name' => $fileName,
            'file_type' => $fileType,
            'uploaded_by' => auth()->id(),
        ]);

        return $this->successResponse('Attachment uploaded successfully', [
            'attachment' => $attachment,
        ], 201);
    }

    public function deleteAttachment(Task $task, TaskAttachment $attachment): JsonResponse
    {
        if ($attachment->task_id !== $task->id) {
            return $this->errorResponse('Attachment not found for this task', [], 404);
        }

        Storage::disk('public')->delete($attachment->file_path);
        $attachment->delete();

        return $this->successResponse('Attachment deleted successfully');
    }

    public function myTasks(Request $request): JsonResponse
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->where('created_by', auth()->id());

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->has('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return $this->successResponse('My tasks retrieved successfully', [
            'tasks' => $tasks->items(),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function assignedToMe(Request $request): JsonResponse
    {
        $query = Task::with(['assignedUsers', 'creator', 'attachments'])
            ->whereHas('assignedUsers', function ($q) {
                $q->where('users.id', auth()->id());
            });

        // Apply filters
        if ($request->has('status')) {
            $query->where('status', $request->get('status'));
        }
        if ($request->has('priority')) {
            $query->where('priority', $request->get('priority'));
        }

        $tasks = $query->orderBy('created_at', 'desc')->paginate($request->get('per_page', 15));

        return $this->successResponse('Assigned tasks retrieved successfully', [
            'tasks' => $tasks->items(),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }
}
