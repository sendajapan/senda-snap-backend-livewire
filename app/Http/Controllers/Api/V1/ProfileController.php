<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\UserResource;
use App\Services\ProfileService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(
        protected ProfileService $profileService
    ) {}

    public function show(): JsonResponse
    {
        $profileData = $this->profileService->getProfile(auth()->user());

        return $this->successResponse('Profile retrieved successfully', $profileData);
    }

    public function update(UpdateProfileRequest $request): JsonResponse
    {
        $data = $request->validated();

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar');
        }

        try {
            $user = $this->profileService->updateProfile(auth()->user(), $data);

            return $this->successResponse('Profile updated successfully', [
                'user' => new UserResource($user),
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Current password is incorrect', [
                'current_password' => ['The current password is incorrect.'],
            ], 422);
        }
    }

    public function uploadAvatar(Request $request): JsonResponse
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = $this->profileService->uploadAvatar(auth()->user(), $request->file('avatar'));

        return $this->successResponse('Avatar uploaded successfully', [
            'avatar_url' => $user->avatar_url,
        ]);
    }

    public function removeAvatar(): JsonResponse
    {
        $user = $this->profileService->removeAvatar(auth()->user());

        return $this->successResponse('Avatar removed successfully', [
            'avatar_url' => $user->avatar_url,
        ]);
    }

    public function taskStats(): JsonResponse
    {
        $stats = $this->profileService->getTaskStats(auth()->user());

        return $this->successResponse('Task statistics retrieved successfully', $stats);
    }
}
