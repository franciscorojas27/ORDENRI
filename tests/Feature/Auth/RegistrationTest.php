<?php

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new users can register', function () {
    $this->withExceptionHandling();
    $response = $this->post('/register', [
        'name' => 'Test',
        'last_name' => 'User',
        'phone' => '04141234567',	
        'coordination_management' => 'Coordination',
        'general_management' => 1,
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);
    $this->assertAuthenticated();
    $response->assertRedirect(route('order.index', absolute: false));
});
