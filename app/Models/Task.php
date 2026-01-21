<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'work_date',
        'work_time',
        'status',
        'priority',
        'created_by',
        'due_date',
        'completed_at',
    ];

    protected function casts(): array
    {
        return [
            'work_date' => 'date',
            'due_date' => 'date',
            'completed_at' => 'datetime',
        ];
    }

    /**
     * Users assigned to this task.
     */
    public function assignedUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user')->withTimestamps();
    }

    /**
     * User who created this task.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Task attachments.
     */
    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }

    /**
     * Scope to filter tasks based on user role and vendor.
     * - Admin: sees all tasks
     * - Manager: sees all tasks from their vendor (via creator or assigned users)
     * - Regular users: see tasks they created OR tasks assigned to them
     */
    public function scopeForUserRole(Builder $query, ?\App\Models\User $user = null): Builder
    {
        $user = $user ?? auth()->user();

        if (! $user) {
            return $query->whereRaw('1 = 0'); // No user = no results
        }

        // Admin sees all tasks
        if ($user->role === 'admin') {
            return $query;
        }

        // Manager sees all tasks from their vendor
        // Tasks where creator's vendor_id matches OR assigned users' vendor_id matches
        if ($user->role === 'manager' && $user->vendor_id) {
            return $query->where(function ($q) use ($user) {
                $q->whereHas('creator', fn ($subQ) => $subQ->where('vendor_id', $user->vendor_id))
                    ->orWhereHas('assignedUsers', fn ($subQ) => $subQ->where('vendor_id', $user->vendor_id));
            });
        }

        // Regular users see tasks they created OR tasks assigned to them
        return $query->where(function ($q) use ($user) {
            $q->where('created_by', $user->id)
                ->orWhereHas('assignedUsers', fn ($subQ) => $subQ->where('users.id', $user->id));
        });
    }
}
