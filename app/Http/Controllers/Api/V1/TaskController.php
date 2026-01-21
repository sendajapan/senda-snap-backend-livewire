<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Http\Resources\TaskAttachmentResource;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Models\TaskAttachment;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TaskController extends Controller
{
    public function __construct(
        protected TaskService $taskService
    ) {
    }

    public function index(Request $request): JsonResponse
    {
        $user = auth()->user();

        // Debug logging for production issues
        Log::info('TaskController@index', [
            'user_id' => $user?->id,
            'user_email' => $user?->email,
            'user_vendor_id' => $user?->vendor_id,
            'user_role' => $user?->role,
            'total_tasks_in_db' => Task::count(),
            'tasks_with_user_vendor' => $user?->vendor_id ? Task::where('vendor_id', $user->vendor_id)->count() : null,
        ]);

        // we only use from_date and to_date for filtering tasks
        $filters = [
            'date_from' => $request->get('from_date'),
            'date_to' => $request->get('to_date'),
        ];

        $tasks = $this->taskService->list($filters, $request->get('per_page', 100));

        return $this->successResponse('Tasks retrieved successfully', [
            'tasks' => TaskResource::collection($tasks->items()),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function store(StoreTaskRequest $request): JsonResponse
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $assignedUserIds = $request->get('assigned_to', []);

        $task = $this->taskService->create($data, $assignedUserIds);

        // if got files then upload them too
        if ($request->hasFile('attachments')) {
            $this->taskService->addAttachments($task, $request->file('attachments'), auth()->id());
        }

        return $this->successResponse('Task created successfully', [
            'task' => new TaskResource($task->fresh(['assignedUsers', 'creator', 'attachments'])),
        ], 201);
    }

    public function show(Task $task): JsonResponse
    {
        // Use service method to ensure vendor scoping
        $task = $this->taskService->getTaskById($task->id);
        $task->load(['assignedUsers', 'creator', 'attachments']);

        return $this->successResponse('Task retrieved successfully', [
            'task' => new TaskResource($task),
        ]);
    }

    public function update(UpdateTaskRequest $request, Task $task): JsonResponse
    {
        // Use service method to ensure vendor scoping
        $task = $this->taskService->getTaskById($task->id);

        $data = $request->validated();
        $assignedUserIds = $request->has('assigned_to') ? $request->get('assigned_to') : null;

        $task = $this->taskService->update($task, $data, $assignedUserIds);

        // if want to update attachments, check the flag first
        if ($request->boolean('attachments_update')) {
            $files = $request->hasFile('attachments') ? $request->file('attachments') : [];
            $this->taskService->replaceAttachments($task, $files, auth()->id());
        }

        return $this->successResponse('Task updated successfully', [
            'task' => new TaskResource($task->fresh(['assignedUsers', 'creator', 'attachments'])),
        ]);
    }

    public function destroy(Task $task): JsonResponse
    {
        $user = auth()->user();

        // Only admin or manager can delete tasks
        if (!in_array($user->role, ['admin', 'manager'])) {
            return $this->errorResponse('Unauthorized. Only admin or manager can delete tasks.', [], 403);
        }

        // Use service method to ensure vendor scoping
        $task = $this->taskService->getTaskById($task->id);
        $this->taskService->delete($task);

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

        // Use service method to ensure vendor scoping
        $task = $this->taskService->getTaskById($task->id);
        $task = $this->taskService->assign($task, $request->assigned_to);

        return $this->successResponse('Task assigned successfully', [
            'task' => new TaskResource($task),
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

        // Use service method to ensure vendor scoping
        $task = $this->taskService->getTaskById($task->id);
        $task = $this->taskService->updateStatus($task, $request->status);

        return $this->successResponse('Task status updated successfully', [
            'task' => new TaskResource($task),
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

        // Use service method to ensure vendor scoping
        $task = $this->taskService->getTaskById($task->id);

        $file = $request->file('file');
        $fileName = $request->get('file_name');

        $attachment = $this->taskService->uploadAttachment($task, $file, auth()->id(), $fileName);

        return $this->successResponse('Attachment uploaded successfully', [
            'attachment' => new TaskAttachmentResource($attachment),
        ], 201);
    }

    public function deleteAttachment(Task $task, TaskAttachment $attachment): JsonResponse
    {
        // Use service method to ensure vendor scoping
        $task = $this->taskService->getTaskById($task->id);

        if ($attachment->task_id !== $task->id) {
            return $this->errorResponse('Attachment not found for this task', [], 404);
        }

        $this->taskService->deleteAttachment($attachment);

        return $this->successResponse('Attachment deleted successfully');
    }

    public function myTasks(Request $request): JsonResponse
    {
        $filters = [
            'status' => $request->get('status'),
            'priority' => $request->get('priority'),
        ];

        $tasks = $this->taskService->getMyTasks(auth()->id(), $filters, $request->get('per_page', 15));

        return $this->successResponse('My tasks retrieved successfully', [
            'tasks' => TaskResource::collection($tasks->items()),
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
        $filters = [
            'status' => $request->get('status'),
            'priority' => $request->get('priority'),
        ];

        $tasks = $this->taskService->getAssignedTasks(auth()->id(), $filters, $request->get('per_page', 15));

        return $this->successResponse('Assigned tasks retrieved successfully', [
            'tasks' => TaskResource::collection($tasks->items()),
            'pagination' => [
                'current_page' => $tasks->currentPage(),
                'last_page' => $tasks->lastPage(),
                'per_page' => $tasks->perPage(),
                'total' => $tasks->total(),
            ],
        ]);
    }

    public function stats(): JsonResponse
    {
        // Apply vendor scoping for stats
        $query = Task::forCurrentVendor();

        $stats = [
            'pending' => (clone $query)->where('status', 'pending')->count(),
            'running' => (clone $query)->where('status', 'running')->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
        ];

        return $this->successResponse('Task statistics retrieved successfully', [
            'stats' => $stats,
        ]);
    }

    public function debug(Request $request): JsonResponse
    {
        $user = auth()->user();

        if (!$user) {
            return $this->errorResponse('User not authenticated', [], 401);
        }

        $userVendorId = $user->vendor_id;
        $totalTasks = Task::count();
        $tasksWithUserVendor = $userVendorId ? Task::where('vendor_id', $userVendorId)->count() : null;
        $tasksWithoutVendor = Task::whereNull('vendor_id')->count();
        $scopedQuery = Task::forCurrentVendor();
        $scopedCount = $scopedQuery->count();

        // Get vendor distribution
        $vendorDistribution = Task::selectRaw('vendor_id, COUNT(*) as count')
            ->groupBy('vendor_id')
            ->get()
            ->map(fn($item) => [
                'vendor_id' => $item->vendor_id,
                'count' => $item->count,
            ]);

        return $this->successResponse('Debug information retrieved successfully', [
            'user' => [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
                'vendor_id' => $userVendorId,
            ],
            'tasks' => [
                'total_in_database' => $totalTasks,
                'with_user_vendor_id' => $tasksWithUserVendor,
                'without_vendor_id' => $tasksWithoutVendor,
                'scoped_count' => $scopedCount,
                'vendor_distribution' => $vendorDistribution,
            ],
        ]);
    }
}
