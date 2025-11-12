<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

class UsersController extends Controller
{
    public function __construct(
        protected UserService $userService
    ) {}

    public function index(): JsonResponse
    {
        $filters = [
            'select' => ['id', 'name', 'email', 'phone', 'role', 'avis_id', 'avatar', 'created_at'],
        ];

        $users = $this->userService->list($filters);

        return $this->successResponse('Users retrieved successfully', [
            'users' => UserResource::collection($users),
        ]);
    }
}
