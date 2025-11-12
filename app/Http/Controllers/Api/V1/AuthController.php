<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Services\AuthService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function __construct(
        protected AuthService $authService
    ) {}

    public function register(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'sometimes|in:admin,manager,employee,client',
            'phone' => 'nullable|string|max:20',
        ]);

        if ($validator->fails()) {
            $messages = implode(' ', $validator->errors()->all());

            return $this->errorResponse($messages ?: 'Validation failed', $validator->errors()->toArray(), 422);
        }

        $result = $this->authService->register($request->only(['name', 'email', 'password', 'role', 'phone']));

        return $this->successResponse('User registered successfully', [
            'user' => new UserResource($result['user']),
            'token' => $result['token'],
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        // check first if got email and password or not, don't want error suddenly
        $missing = [];
        if (! $request->filled('email')) {
            $missing[] = 'email';
        }
        if (! $request->filled('password')) {
            $missing[] = 'password';
        }
        if (! empty($missing)) {
            return $this->errorResponse(
                'The following field(s) are required: '.implode(', ', $missing).'.',
                array_combine($missing, array_map(fn ($f) => ["The {$f} field is required."], $missing)),
                422
            );
        }

        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            $messages = implode(' ', $validator->errors()->all());

            return $this->errorResponse($messages ?: 'Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $result = $this->authService->login($request->only('email', 'password'));

            return $this->successResponse('Login successful', [
                'user' => new UserResource($result['user']),
                'token' => $result['token'],
            ]);
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Invalid credentials', [], 401);
        } catch (\Throwable $e) {
            // always return json response, don't show html error page
            return $this->errorResponse('Unable to process login request.', [
                'exception' => [$e->getMessage()],
            ], 500);
        }
    }

    public function logout(Request $request): JsonResponse
    {
        $this->authService->logout($request->user());

        return $this->successResponse('Logout successful');
    }

    public function refresh(Request $request): JsonResponse
    {
        $token = $this->authService->refreshToken($request->user());

        return $this->successResponse('Token refreshed successfully', [
            'token' => $token,
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        return $this->successResponse('User retrieved successfully', [
            'user' => new UserResource($request->user()),
        ]);
    }

    public function updateProfile(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        $data = $request->only(['name', 'phone']);
        if ($request->hasFile('avatar')) {
            $data['avatar'] = $request->file('avatar');
        }

        $user = $this->authService->updateProfile($request->user(), $data);

        return $this->successResponse('Profile updated successfully', [
            'user' => new UserResource($user),
        ]);
    }

    public function changePassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $this->authService->changePassword(
                $request->user(),
                $request->current_password,
                $request->password
            );

            return $this->successResponse('Password changed successfully');
        } catch (\InvalidArgumentException $e) {
            return $this->errorResponse('Current password is incorrect', [], 400);
        }
    }

    public function forgotPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors()->toArray(), 422);
        }

        try {
            $this->authService->sendResetLink($request->email);

            return $this->successResponse('Password reset link sent to your email');
        } catch (\RuntimeException $e) {
            return $this->errorResponse('Unable to send password reset link', [], 400);
        }
    }

    public function resetPassword(Request $request): JsonResponse
    {
        $validator = Validator::make($request->all(), [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return $this->errorResponse('Validation failed', $validator->errors(), 422);
        }

        try {
            $this->authService->resetPassword(
                $request->token,
                $request->email,
                $request->password
            );

            return $this->successResponse('Password reset successfully');
        } catch (\RuntimeException $e) {
            return $this->errorResponse('Unable to reset password', [], 400);
        }
    }
}
