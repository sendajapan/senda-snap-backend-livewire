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

test('anyone can visit public shipment schedule export url', function () {
    $response = $this->get('/shipment-schedule/public/export');
    $response->assertSuccessful();
    $response->assertDownload('schedules.xlsx');
});

test('anyone can visit public shipment schedule import page', function () {
    $this->get('/shipment-schedule/public/import')
        ->assertStatus(200)
        ->assertSee('Import Shipment Schedule');
});
