<?php

declare(strict_types=1);

use App\Models\User;

it('shows REST API routes on api-docs page', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)
        ->get('/api-docs')
        ->assertOk()
        ->assertSee('/api/v1/auth/login');
});
