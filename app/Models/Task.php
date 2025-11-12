<?php

namespace App\Models;

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

    public function assignedUsers(): BelongsToMany
    {
        //here task_user table is pivot table holds the foreign keys of both related tables. [ex: task_id, user_id]
        return $this->belongsToMany(User::class, 'task_user')->withTimestamps();

        /* Code snippets for future
        // Get all users assigned to a task
        $task = Task::find(1);
        $users = $task->users;

        // Get all tasks assigned to a user
        $user = User::find(2);
        $tasks = $user->tasks;

        // Attach a user to a task
        $task->users()->attach($userId);

        // Detach a user from a task
        $task->users()->detach($userId);

        // Sync users (replace all existing ones)
        $task->users()->sync([1, 2, 3]);
        */

    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(TaskAttachment::class);
    }
}
