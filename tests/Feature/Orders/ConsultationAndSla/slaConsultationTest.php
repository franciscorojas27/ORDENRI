<?php
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Artisan;

test('Muestra el dashboard con no ordenes para el mes y año especificados', function () {
    $user = User::factory()->create();
    $this->actingAs($user);


    $response = $this->get('/dashboard?month=11&year=2024');

    $response->assertSessionHas('ERROR_MESSAGE', 'No se encontraron ordenes para el mes y año especificados.');
    $response->assertStatus(200);
});

test('Muestra el dashboard con ordenes para el mes y año especificados', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $response = $this->get('/dashboard?month=12&year=2024');


    $response->assertStatus(200);
});

