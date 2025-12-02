<?php

declare(strict_types=1);

use App\Models\User;

it('skips image upload when user email contains test', function (): void {
    /** @var \App\Models\User $user */
    $user = User::factory()->create([
        'email' => 'test1@example.com',
    ]);

    $response = $this->actingAs($user, 'sanctum')
        ->postJson('/api/v1/vehicles/upload-images', [
            'vehicle_id' => 123,
        ]);

    $response
        ->assertOk()
        ->assertJsonFragment([
            'message' => 'Images will not be uploaded by tester',
        ]);
});


