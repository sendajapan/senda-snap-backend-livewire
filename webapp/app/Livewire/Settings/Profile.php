<?php

declare(strict_types=1);

namespace App\Livewire\Settings;

use App\Models\User;
use App\Services\AuthService;
use App\Services\ProfileService;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public string $name = '';

    public string $email = '';

    public ?UploadedFile $avatar = null;

    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

    /**
     * Mount the component.
     */
    public function mount(): void
    {
        $user = Auth::user();
        $this->name = $user->name;
        $this->email = $user->email;
    }

    /**
     * Update the profile information for the currently authenticated user.
     */
    public function updateProfileInformation(ProfileService $profileService): void
    {
        $user = Auth::user();

        $validated = $this->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => [
                'required',
                'string',
                'lowercase',
                'email',
                'max:255',
                Rule::unique(User::class)->ignore($user->id),
            ],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        $updateData = [
            'name' => $validated['name'],
            'email' => $validated['email'],
        ];

        if ($this->avatar) {
            $updateData['avatar'] = $this->avatar;
        }

        $profileService->updateProfile($user, $updateData);

        $this->avatar = null;
        $this->dispatch('profile-updated', name: $user->fresh()->name);
    }

    /**
     * Update the password for the currently authenticated user.
     */
    public function updatePassword(AuthService $authService): void
    {
        try {
            $validated = $this->validate([
                'current_password' => ['required', 'string', 'current_password'],
                'password' => ['required', 'string', PasswordRule::defaults(), 'confirmed'],
            ]);
        } catch (ValidationException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');

            throw $e;
        }

        try {
            $authService->changePassword(
                Auth::user(),
                $validated['current_password'],
                $validated['password']
            );
        } catch (\InvalidArgumentException $e) {
            $this->reset('current_password', 'password', 'password_confirmation');
            throw ValidationException::withMessages(['current_password' => 'The current password is incorrect.']);
        }

        $this->reset('current_password', 'password', 'password_confirmation');

        $this->dispatch('password-updated');
    }

    /**
     * Remove the avatar for the currently authenticated user.
     */
    public function removeAvatar(ProfileService $profileService): void
    {
        $profileService->removeAvatar(Auth::user());

        $this->dispatch('profile-updated', name: Auth::user()->fresh()->name);
    }

    /**
     * Send an email verification notification to the current user.
     */
    public function resendVerificationNotification(): void
    {
        $user = Auth::user();

        if ($user->hasVerifiedEmail()) {
            $this->redirectIntended(default: route('dashboard', absolute: false));

            return;
        }

        $user->sendEmailVerificationNotification();

        Session::flash('status', 'verification-link-sent');
    }
}
