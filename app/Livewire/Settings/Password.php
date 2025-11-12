<?php

namespace App\Livewire\Settings;

use App\Services\AuthService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rules\Password as PasswordRule;
use Illuminate\Validation\ValidationException;
use Livewire\Component;

class Password extends Component
{
    public string $current_password = '';

    public string $password = '';

    public string $password_confirmation = '';

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
}
