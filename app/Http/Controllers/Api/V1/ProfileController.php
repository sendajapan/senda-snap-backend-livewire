<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function show(): JsonResponse
    {
        $user = auth()->user();
        $user->load(['assignedTasks', 'createdTasks']);

        // Calculate stats
        $assignedTasksCount = $user->assignedTasks()->count();
        $createdTasksCount = $user->createdTasks()->count();
        $completedTasksCount = $user->assignedTasks()->where('status', 'completed')->count();
        $pendingTasksCount = $user->assignedTasks()->where('status', 'pending')->count();

        return $this->successResponse('Profile retrieved successfully', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'avatar_url' => $user->avatar_url,
                'email_verified_at' => $user->email_verified_at,
                'created_at' => $user->created_at,
                'updated_at' => $user->updated_at,
            ],
            'stats' => [
                'assigned_tasks' => $assignedTasksCount,
                'created_tasks' => $createdTasksCount,
                'completed_tasks' => $completedTasksCount,
                'pending_tasks' => $pendingTasksCount,
            ],
            'recent_tasks' => $user->assignedTasks()
                ->with(['vehicle', 'creator'])
                ->latest()
                ->take(5)
                ->get()
                ->map(function ($task) {
                    return [
                        'id' => $task->id,
                        'title' => $task->title,
                        'status' => $task->status,
                        'priority' => $task->priority,
                        'work_date' => $task->work_date,
                        'vehicle' => $task->vehicle ? [
                            'id' => $task->vehicle->id,
                            'serial_number' => $task->vehicle->serial_number,
                            'make' => $task->vehicle->make,
                            'model' => $task->vehicle->model,
                        ] : null,
                        'creator' => [
                            'id' => $task->creator->id,
                            'name' => $task->creator->name,
                        ],
                    ];
                }),
        ]);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $user = auth()->user();
        $data = $request->validated();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $avatarPath;
        }

        // Handle password update
        if (! empty($data['password'])) {
            // Verify current password
            if (! Hash::check($data['current_password'], $user->password)) {
                return $this->errorResponse('Current password is incorrect', [
                    'current_password' => ['The current password is incorrect.'],
                ], 422);
            }

            $data['password'] = Hash::make($data['password']);
        }

        // Remove current_password from data as it's not a fillable field
        unset($data['current_password']);

        // Update user
        $user->update(array_filter($data));

        return $this->successResponse('Profile updated successfully', [
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
                'role' => $user->role,
                'avatar_url' => $user->avatar_url,
                'updated_at' => $user->updated_at,
            ],
        ]);
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = auth()->user();

        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $avatarPath = $request->file('avatar')->store('avatars', 'public');
        $user->update(['avatar' => $avatarPath]);

        return $this->successResponse('Avatar uploaded successfully', [
            'avatar_url' => $user->avatar_url,
        ]);
    }

    public function removeAvatar(): JsonResponse
    {
        $user = auth()->user();

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return $this->successResponse('Avatar removed successfully', [
            'avatar_url' => $user->avatar_url,
        ]);
    }

    public function taskStats(): JsonResponse
    {
        $user = auth()->user();

        $stats = [
            'assigned_tasks' => [
                'total' => $user->assignedTasks()->count(),
                'pending' => $user->assignedTasks()->where('status', 'pending')->count(),
                'running' => $user->assignedTasks()->where('status', 'running')->count(),
                'completed' => $user->assignedTasks()->where('status', 'completed')->count(),
                'cancelled' => $user->assignedTasks()->where('status', 'cancelled')->count(),
            ],
            'created_tasks' => [
                'total' => $user->createdTasks()->count(),
                'pending' => $user->createdTasks()->where('status', 'pending')->count(),
                'running' => $user->createdTasks()->where('status', 'running')->count(),
                'completed' => $user->createdTasks()->where('status', 'completed')->count(),
                'cancelled' => $user->createdTasks()->where('status', 'cancelled')->count(),
            ],
            'priority_breakdown' => [
                'low' => $user->assignedTasks()->where('priority', 'low')->count(),
                'medium' => $user->assignedTasks()->where('priority', 'medium')->count(),
                'high' => $user->assignedTasks()->where('priority', 'high')->count(),
                'urgent' => $user->assignedTasks()->where('priority', 'urgent')->count(),
            ],
        ];

        return $this->successResponse('Task statistics retrieved successfully', $stats);
    }
}
