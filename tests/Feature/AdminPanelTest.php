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

    $response = $this->post('/admin-secure/users', [
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
test('Actualiza un usuario existente', function () {
    $user = User::factory()->create(
        [
            'job_title_id' => 4,
            'general_management_id' => 1,
        ]
    );

    $this->session(['auth.password_confirmed_at' => time()]);
    $response = $this->actingAs($user)->put(route('admin-secure.update', $user), [
        'name' => 'Test',
        'last_name' => 'Update',
        'userid' => '1',
        'email' => 'test@example.com',
        'job_title_id' => 1,
        'phone' => '584124567890',
        'last_connection' => now(),
        'created_at' => now(),
        'password_may_expire' => true,
        'password_may_expire_at' => now()->addDays(30),
        'ip_address' => '192.168.0.1',
        'is_blocked' => false,
        'group' => false,
        'coordination_management' => 'Coordination',
        'general_management_id' => 1,
    ]);

    $user->refresh();
    $this->assertEquals('test@example.com', $user->email);

    $response->assertRedirect(route('admin-secure.edit', $user));
});

test('Marca un usuario como eliminado', function () {
    $user = User::factory()->create([
        'job_title_id' => 4,
        'general_management_id' => 1,
    ]);

    $this->session(['auth.password_confirmed_at' => time()]);

    $response = $this->actingAs($user)->delete(route('admin-secure.delete', $user));

    $user->refresh();

    $this->assertEquals(1, $user->is_deleted);

    $response->assertRedirect(route('admin-secure.index'));
});


test('Restablece la contraseña de un usuario', function () {
    $user = User::factory()->create([
        'job_title_id' => 4,
        'general_management_id' => 1,
    ]);

    $this->session(['auth.password_confirmed_at' => time()]);

    $response = $this->actingAs($user)->patch(route('admin-secure.reset', $user));

    $response->assertRedirect(route('admin-secure.edit', $user));
});
