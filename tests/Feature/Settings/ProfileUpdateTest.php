<?php

use App\Livewire\Settings\Profile;
use App\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;

test('profile page is displayed', function () {
    $this->actingAs($user = User::factory()->create());

    $this->get('/settings/profile')->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', 'test@example.com')
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    $user->refresh();

    expect($user->name)->toEqual('Test User');
    expect($user->email)->toEqual('test@example.com');
    expect($user->email_verified_at)->toBeNull();
});

test('email verification status is unchanged when email address is unchanged', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('name', 'Test User')
        ->set('email', $user->email)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});

test('password can be updated from profile page', function () {
    $user = User::factory()->create([
        'password' => bcrypt('current-password'),
    ]);

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('current_password', 'current-password')
        ->set('password', 'new-password-123')
        ->set('password_confirmation', 'new-password-123')
        ->call('updatePassword');

    $response->assertHasNoErrors();
    $response->assertDispatched('password-updated');

    expect(Hash::check('new-password-123', $user->fresh()->password))->toBeTrue();
});

test('current password must be correct to update password', function () {
    $user = User::factory()->create([
        'password' => bcrypt('current-password'),
    ]);

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->set('current_password', 'wrong-password')
        ->set('password', 'new-password-123')
        ->set('password_confirmation', 'new-password-123')
        ->call('updatePassword');

    $response->assertHasErrors(['current_password']);

    expect(Hash::check('current-password', $user->fresh()->password))->toBeTrue();
});

test('avatar can be uploaded', function () {
    $user = User::factory()->create();

    $this->actingAs($user);

    $avatar = UploadedFile::fake()->image('avatar.jpg', 100, 100);

    $response = Livewire::test(Profile::class)
        ->set('name', $user->name)
        ->set('email', $user->email)
        ->set('avatar', $avatar)
        ->call('updateProfileInformation');

    $response->assertHasNoErrors();
    $response->assertDispatched('profile-updated');

    expect($user->fresh()->avatar)->not->toBeNull();
});

test('avatar can be removed', function () {
    $user = User::factory()->create([
        'avatar' => 'avatars/test.jpg',
    ]);

    $this->actingAs($user);

    $response = Livewire::test(Profile::class)
        ->call('removeAvatar');

    $response->assertDispatched('profile-updated');

    expect($user->fresh()->avatar)->toBeNull();
});
