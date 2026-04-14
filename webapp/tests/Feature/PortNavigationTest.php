<?php

use App\Models\User;

test('authenticated users can visit ports page', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/ports')->assertStatus(200);
});

test('authenticated users can visit shipping companies page', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/shipping-companies')->assertStatus(200);
});
