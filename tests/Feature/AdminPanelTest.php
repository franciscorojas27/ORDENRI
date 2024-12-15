<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

test('El administrador puede entrar en la pagina de crear usuario', function () {
    $usuario = User::factory()->create([
        'password' => Hash::make('contraseña_correcta'),
        'job_title_id' => 4, 
        'general_management_id' => 1, 
    ]);

    $this->assertNotNull($usuario);

    $this->actingAs($usuario);

    $this->session(['auth.password_confirmed_at' => time()]);

    $response = $this->get('/admin-secure/users/create');

    $response->assertStatus(200);
});


test('El administrador puede crear un nuevo usuario', function () {
    $adminUser = User::factory()->create([
        'job_title_id' => 4,
        'general_management_id' => 1, 
    ]);
    $this->actingAs($adminUser);

    $this->session(['auth.password_confirmed_at' => time()]);

    $response = $this->post('/admin-secure/users', [ // Cambié la ruta a /admin-secure/users
        'name' => 'Test',
        'last_name' => 'Test',
        'job_title_id' => 1,
        'phone' => '04141234567',
        'coordination_management' => 'Coordination',
        'general_management' => 1,
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $response->assertRedirect('/admin-secure/users');  
});

