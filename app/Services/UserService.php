<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserService
{
    public function list(array $filters = []): Collection
    {
        $query = User::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('email', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        if (! empty($filters['select'])) {
            $query->select($filters['select']);
        }

        return $query->orderBy($filters['sort_by'] ?? 'created_at', $filters['sort_direction'] ?? 'desc')->get();
    }

    public function getPaginated(array $filters = [], int $perPage = 10)
    {
        $query = User::query();

        if (! empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('email', 'like', "%{$filters['search']}%");
            });
        }

        if (! empty($filters['role'])) {
            $query->where('role', $filters['role']);
        }

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }

    public function getById(int $userId): User
    {
        return User::findOrFail($userId);
    }

    public function create(array $data): User
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'role' => $data['role'] ?? 'client',
            'phone' => $data['phone'] ?? null,
            'avis_id' => $data['avis_id'] ?? null,
        ];

        if (! empty($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            $userData['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        return User::create($userData);
    }

    public function update(User $user, array $data): User
    {
        $updateData = [];

        if (isset($data['name'])) {
            $updateData['name'] = $data['name'];
        }

        if (isset($data['email'])) {
            $updateData['email'] = $data['email'];
        }

        if (isset($data['role'])) {
            $updateData['role'] = $data['role'];
        }

        if (isset($data['phone'])) {
            $updateData['phone'] = $data['phone'];
        }

        if (isset($data['avis_id'])) {
            $updateData['avis_id'] = $data['avis_id'];
        }

        if (! empty($data['password'])) {
            $updateData['password'] = Hash::make($data['password']);
        }

        if (! empty($data['avatar']) && $data['avatar'] instanceof UploadedFile) {
            // Delete old avatar if exists
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            $updateData['avatar'] = $data['avatar']->store('avatars', 'public');
        }

        if (! empty($updateData)) {
            $user->update($updateData);
        }

        return $user->fresh();
    }

    public function delete(User $user): bool
    {
        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        return $user->delete();
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
        $user->load(['assignedTasks', 'createdTasks']);

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
