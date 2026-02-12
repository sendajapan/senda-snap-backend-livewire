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

test('anyone can visit public shipment schedule page without auth', function () {
    $this->get('/shipment-schedule/public')->assertStatus(200);
});

test('public shipment schedule page accepts name query param', function () {
    $this->get('/shipment-schedule/public?name=John')
        ->assertStatus(200)
        ->assertSee('John');
});
