<?php

declare(strict_types=1);

namespace App\Services;

use App\Models\Notice;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Collection;

class NoticeService
{
    /**
     * Get all active notices.
     */
    public function getActiveNotices(): Collection
    {
        return Notice::active()->orderBy('created_at', 'desc')->get();
    }

    /**
     * List all notices with pagination.
     */
    public function list(array $filters = [], int $perPage = 15): LengthAwarePaginator
    {
        $query = Notice::with('creator')->orderBy('created_at', 'desc');

        if (isset($filters['search']) && $filters['search']) {
            $query->where('message', 'like', '%'.$filters['search'].'%');
        }

        if (isset($filters['is_active'])) {
            $query->where('is_active', $filters['is_active']);
        }

        return $query->paginate($perPage);
    }

    /**
     * Get notice by ID.
     */
    public function getById(int $id): Notice
    {
        return Notice::findOrFail($id);
    }

    /**
     * Create a new notice.
     */
    public function create(array $data): Notice
    {
        $data['created_by'] = auth()->id();

        return Notice::create($data);
    }

    /**
     * Update a notice.
     */
    public function update(Notice $notice, array $data): Notice
    {
        $notice->update($data);

        return $notice->fresh();
    }

    /**
     * Delete a notice.
     */
    public function delete(Notice $notice): bool
    {
        return $notice->delete();
    }
}
