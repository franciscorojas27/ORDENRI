<?php

use App\Models\User;
use Database\Seeders\JobTitleSeeder;
use Database\Seeders\ResolutionAreaSeeder;
use Database\Seeders\GeneralManagementsSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;




test('Admin can enter the create user page', function () {
    // Crear usuario en el seeder o directamente aquí
    $usuario = User::create([
        'name' => 'Francisco Antonio',
        'last_name' => 'Apellido',
        'email' => 'franciscoantonior30@gmail.com',
        'password' => bcrypt('contraseña_correcta'),
        'job_title_id' => 1, // Asegúrate de que este ID existe
        'general_management_id' => 1, // Asegúrate de que este ID existe
        'phone' => '04141234567', // O otros campos necesarios
    ]);

    // Verificar que el usuario se haya creado
    $this->assertNotNull($usuario);

    // Autenticación del usuario
    $this->actingAs($usuario);

    // Realizar la solicitud para confirmar la contraseña
    $response = $this->post('/confirm-password', [
        'password' => 'contraseña_correcta',
    ]);
    $response->assertStatus(200);

    // Acceder a la página de creación de usuarios
    $response = $this->get('/admin-secure/users/create');
    $response->assertStatus(200);
});

test('User can create a new user', function () {
    // Crea un usuario y actúa como ese usuario
    $adminUser = User::factory()->create([
        'job_title_id' => 1, // Asegúrate de que este ID exista
        'general_management_id' => 1, // Asegúrate de que este ID exista
    ]);
    $this->actingAs($adminUser);

    // Realiza la solicitud para crear un nuevo usuario
    $response = $this->post('/admin-secure/users/create', [
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

    // Verifica que la respuesta sea exitosa
    $response->assertStatus(200);
});
