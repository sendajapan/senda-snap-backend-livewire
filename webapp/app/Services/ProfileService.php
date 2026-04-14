<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class ProfileService
{
    public function getProfile(User $user): array
    {
        $user->load(['assignedTasks', 'createdTasks']);

        // Calculate stats
        $assignedTasksCount = $user->assignedTasks()->count();
        $createdTasksCount = $user->createdTasks()->count();
        $completedTasksCount = $user->assignedTasks()->where('status', 'completed')->count();
        $pendingTasksCount = $user->assignedTasks()->where('status', 'pending')->count();

        $recentTasks = $user->assignedTasks()
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
            });

        return [
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
            'recent_tasks' => $recentTasks,
        ];
    }

    public function updateProfile(User $user, array $data): User
    {
        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['email'])) {
            // Reset email verification if email changed
            if ($user->email !== $data['email']) {
                $updateData['email_verified_at'] = null;
            }
            $updateData['email'] = $data['email'];
        }

        if (isset($data['phone'])) {
            $updateData['phone'] = $data['phone'];
        }

        // Handle avatar upload
        if (! empty($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }

            $avatarPath = $data['avatar']->store('avatars', 'public');
            $updateData['avatar'] = $avatarPath;
        }

        // Handle password update
        if (! empty($data['password'])) {
            // Verify current password if provided
            if (! empty($data['current_password'])) {
                if (! Hash::check($data['current_password'], $user->password)) {
                    throw new \InvalidArgumentException('Current password is incorrect');
                }
            }

            $updateData['password'] = Hash::make($data['password']);
        }

        if (! empty($updateData)) {
            $user->fill($updateData);

            // If email changed and email_verified_at needs to be reset
            if (isset($updateData['email']) && $user->isDirty('email')) {
                $user->email_verified_at = null;
            }

            $user->save();
        }

        return $user->fresh();
    }

    public function uploadAvatar(User $user, UploadedFile $avatar): User
    {
        // Delete old avatar if exists
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $avatarPath = $avatar->store('avatars', 'public');
        $user->update(['avatar' => $avatarPath]);

        return $user->fresh();
    }

    public function removeAvatar(User $user): User
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
            $user->update(['avatar' => null]);
        }

        return $user->fresh();
    }

    public function getTaskStats(User $user): array
    {
        return [
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
    }
}
