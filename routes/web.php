<?php

use App\Http\Controllers\AdminManualController;
use App\Http\Controllers\ApiDocsController;
use App\Http\Controllers\PrivacyPolicyController;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use App\Livewire\Tasks\AllTasks;
use App\Livewire\Tasks\TodayTasks;
use App\Livewire\Users\Index as UsersIndex;
use App\Livewire\Vehicles\Index as VehiclesIndex;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Public Admin Manual (no authentication required)
Route::get('admin-manual', [AdminManualController::class, 'index'])->name('admin.manual');

// Public Privacy Policy (no authentication required)
Route::get('privacy-policy', [PrivacyPolicyController::class, 'index'])->name('privacy.policy');

Route::view('dashboard', 'dashboard')
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {
    // API Documentation
    Route::get('api-docs', [ApiDocsController::class, 'index'])->name('api.docs');

    // Users Management
    Route::get('users', UsersIndex::class)->name('users.index');
    Route::get('users/create', fn () => view('livewire.users.create'))->name('users.create');
    Route::get('users/{user}/edit', fn ($user) => view('livewire.users.edit', ['user' => $user]))->name('users.edit');

    // Tasks Management
    Route::redirect('tasks', 'tasks/today')->name('tasks.index');
    Route::get('tasks/today', TodayTasks::class)->name('tasks.today');
    Route::get('tasks/all', AllTasks::class)->name('tasks.all');
    Route::get('tasks/create', fn () => view('livewire.tasks.create'))->name('tasks.create');
    Route::get('tasks/{task}/edit', fn ($task) => view('livewire.tasks.edit', ['task' => $task]))->name('tasks.edit');
    Route::get('tasks/{task}', fn ($task) => view('livewire.tasks.show', ['task' => $task]))->name('tasks.show');

    // Vehicles Management
    Route::get('vehicles', VehiclesIndex::class)->name('vehicles.index');
    Route::get('vehicles/create', fn () => view('livewire.vehicles.create'))->name('vehicles.create');
    Route::get('vehicles/{vehicle}/edit', fn ($vehicle) => view('livewire.vehicles.edit', ['vehicle' => $vehicle]))->name('vehicles.edit');
    Route::get('vehicles/{vehicle}', fn ($vehicle) => view('livewire.vehicles.show', ['vehicle' => $vehicle]))->name('vehicles.show');

    // Settings routes
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');
});
