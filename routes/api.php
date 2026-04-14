<?php

use App\Http\Controllers\Api\V1\AuthController;
use App\Http\Controllers\Api\V1\PortController;
use App\Http\Controllers\Api\V1\ProfileController;
use App\Http\Controllers\Api\V1\ScheduleController;
use App\Http\Controllers\Api\V1\ScheduleStopoverController;
use App\Http\Controllers\Api\V1\ShippingCompanyController;
use App\Http\Controllers\Api\V1\TaskController;
use App\Http\Controllers\Api\V1\UsersController;
use App\Http\Controllers\Api\V1\VehicleController;
use App\Http\Controllers\Api\V1\VendorController;
use Illuminate\Support\Facades\Route;

// Public routes
Route::prefix('v1')->group(function () {
    Route::prefix('auth')->group(function () {
        Route::post('register', [AuthController::class, 'register']);
        Route::post('login', [AuthController::class, 'login']);
        Route::post('forgot-password', [AuthController::class, 'forgotPassword']);
        Route::post('reset-password', [AuthController::class, 'resetPassword']);
    });

    Route::prefix('public')->group(function () {
        Route::get('schedules', [ScheduleController::class, 'indexPublic']);
        Route::get('schedules/{schedule}', [ScheduleController::class, 'showPublic']);
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
        Route::get('stats', [TaskController::class, 'stats']);
        Route::get('debug', [TaskController::class, 'debug']);
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
        Route::get('/search', [VehicleController::class, 'search']);
        Route::post('/yard', [VehicleController::class, 'yardVehicles']);
        Route::post('/upload-images', [VehicleController::class, 'uploadImages']);
    });

    // Port routes
    Route::prefix('ports')->group(function () {
        Route::get('/', [PortController::class, 'index']);
        Route::post('/', [PortController::class, 'store']);
        Route::get('{port}', [PortController::class, 'show']);
        Route::put('{port}', [PortController::class, 'update']);
        Route::delete('{port}', [PortController::class, 'destroy']);
    });

    // Shipping Company routes
    Route::prefix('shipping-companies')->group(function () {
        Route::get('/', [ShippingCompanyController::class, 'index']);
        Route::post('/', [ShippingCompanyController::class, 'store']);
        Route::get('{shippingCompany}', [ShippingCompanyController::class, 'show']);
        Route::put('{shippingCompany}', [ShippingCompanyController::class, 'update']);
        Route::delete('{shippingCompany}', [ShippingCompanyController::class, 'destroy']);
    });

    // Vendor routes
    Route::prefix('vendors')->group(function () {
        Route::get('/', [VendorController::class, 'index']);
        Route::post('/', [VendorController::class, 'store']);
        Route::get('{vendor}', [VendorController::class, 'show']);
        Route::put('{vendor}', [VendorController::class, 'update']);
        Route::delete('{vendor}', [VendorController::class, 'destroy']);
    });

    // Schedule routes
    Route::prefix('schedules')->group(function () {
        Route::get('/', [ScheduleController::class, 'index']);
        Route::post('/', [ScheduleController::class, 'store']);
        Route::get('{schedule}', [ScheduleController::class, 'show']);
        Route::put('{schedule}', [ScheduleController::class, 'update']);
        Route::delete('{schedule}', [ScheduleController::class, 'destroy']);

        // Stopover routes nested under schedules
        Route::prefix('{schedule}/stopovers')->group(function () {
            Route::post('/', [ScheduleStopoverController::class, 'store']);
        });
    });

    // Stopover routes (standalone)
    Route::prefix('stopovers')->group(function () {
        Route::get('{stopover}', [ScheduleStopoverController::class, 'show']);
        Route::put('{stopover}', [ScheduleStopoverController::class, 'update']);
        Route::delete('{stopover}', [ScheduleStopoverController::class, 'destroy']);
    });
});
