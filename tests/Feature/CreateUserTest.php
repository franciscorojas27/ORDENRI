<?php

use App\Models\User;

test('Admin can enter the create user page', function () {
    $usuario = User::where('email', 'franciscoantonior30@gmail.com')->first();
    $this->assertNotNull($usuario);
    $this->actingAs($usuario);
    $response = $this->post('/ruta/protegida/confirmar-password', [
        'password' => 'contraseña_correcta',
    ]);
    $response->assertStatus(200);
    $response = $this->get('/admin-secure/users/create');
    $response->assertStatus(200);
});
test('User can create a new user', function () {
    
    $this->actingAs(User::factory()->create());

     $response= $this->post('/admin-secure/users', [
        'name' => 'Test User',
        'last_name' => 'Test Last Name',
        'job_title_id' => 1,
        'phone' => '04141234567',
        'coordination_management' => 'Coordination/Management Test',
        'general_management_id' => 1,
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $response->assertOk();
    $response->assertStatus(200);
});
