<?php

use App\Models\User;

test('guests are redirected from users management', function () {
    $this->get('/users')->assertRedirect('/login');
});

test('authenticated users can view users management without a forced dark html class', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->get('/users');

    $response->assertSuccessful();
    $response->assertSee(__('Users Management'));

    $locale = str_replace('_', '-', app()->getLocale());
    $response->assertSee('<html lang="'.$locale.'">', false);
    $response->assertDontSee('<html lang="'.$locale.'" class="dark">', false);
    $response->assertDontSee('id="particle-canvas"', false);
});
