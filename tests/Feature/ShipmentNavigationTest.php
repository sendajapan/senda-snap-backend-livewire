<?php

use App\Models\User;

test('authenticated users can visit shipment schedule page', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/shipment-schedule')->assertStatus(200);
});

test('authenticated users can visit shipping companies page', function () {
    $this->actingAs(User::factory()->create());

    $this->get('/shipping-companies')->assertStatus(200);
});
