<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\Api\V1\VehicleController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });
});

// Protected routes
Route::prefix('v1')->middleware('auth:sanctum')->group(function () {
    // Auth routes
    Route::prefix('auth')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::post('refresh', [AuthController::class, 'refresh']);
        Route::get('me', [AuthController::class, 'me']);
        Route::post('change-password', [AuthController::class, 'changePassword']);
        Route::put('update-profile', [AuthController::class, 'updateProfile']);
    });

    // Profile routes
    Route::prefix('profile')->group(function () {
        Route::get('/', [ProfileController::class, 'show']);
        Route::put('/', [ProfileController::class, 'update']);
        Route::post('avatar', [ProfileController::class, 'uploadAvatar']);
        Route::delete('avatar', [ProfileController::class, 'removeAvatar']);
        Route::get('task-stats', [ProfileController::class, 'taskStats']);
    });

    // Users routes
    Route::get('users', [UsersController::class, 'index']);

    // Task routes
    Route::prefix('tasks')->group(function () {
        Route::get('/', [TaskController::class, 'index']);
        Route::post('/', [TaskController::class, 'store']);
        Route::get('my-tasks', [TaskController::class, 'myTasks']);
        Route::get('assigned-to-me', [TaskController::class, 'assignedToMe']);
        Route::get('{task}', [TaskController::class, 'show']);
        Route::put('{task}', [TaskController::class, 'update']);
        Route::delete('{task}', [TaskController::class, 'destroy']);
        Route::post('{task}/assign', [TaskController::class, 'assign']);
        Route::post('{task}/status', [TaskController::class, 'updateStatus']);
        Route::post('{task}/attachments', [TaskController::class, 'uploadAttachment']);
        Route::delete('{task}/attachments/{attachment}', [TaskController::class, 'deleteAttachment']);
    });

    // Vehicle routes
    Route::prefix('vehicles')->group(function () {

        // Vehicle Management Routes
        Route::get('/search', [VehicleController::class, 'search']);
        Route::post('/upload-images', [VehicleController::class, 'uploadImages']);

        Route::get('/', [VehicleController::class, 'index']);
        Route::post('/', [VehicleController::class, 'store']);
        Route::get('{vehicle}', [VehicleController::class, 'show']);
        Route::put('{vehicle}', [VehicleController::class, 'update']);
        Route::delete('{vehicle}', [VehicleController::class, 'destroy']);
    });
});
