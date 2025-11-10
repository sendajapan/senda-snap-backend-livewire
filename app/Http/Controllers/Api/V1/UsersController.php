<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function index(): JsonResponse
    {
        $users = User::query()
            ->select(['id', 'name', 'email', 'phone', 'role', 'avis_id', 'avatar', 'created_at'])
            ->get();

        return $this->successResponse('Users retrieved successfully', [
            'users' => $users,
        ]);
    }
}
