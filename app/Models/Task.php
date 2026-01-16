<?php

namespace App\Models;

use App\Models\Concerns\BelongsToVendor;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use BelongsToVendor;
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
        'vendor_id',
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
}
