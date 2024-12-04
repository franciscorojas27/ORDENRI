<?php

use App\Models\User;
use Database\Seeders\JobTitleSeeder;
use Database\Seeders\ResolutionAreaSeeder;
use Database\Seeders\GeneralManagementsSeeder;



test('login screen can be rendered', function () {
    $response = $this->get('/login');

    $response->assertStatus(200);
});

test('users can authenticate using the login screen', function () {
    $this->seed(JobTitleSeeder::class);
    $this->seed(ResolutionAreaSeeder::class);
    $this->seed(GeneralManagementsSeeder::class);
    $user = User::factory()->create([
        'password' => bcrypt('password'),
    ]);

    $response = $this->post('/login', [
        'userid' => explode('@', $user->email)[0],
        'password' => 'password',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('order.index', absolute: false));
});

test('users can not authenticate with invalid password', function () {
    
    $user = User::factory()->create();

    $this->post('/login', [
        'email' => $user->email,
        'password' => 'wrong-password',
    ]);

    $this->assertGuest();
});

test('users can logout', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post('/logout');

    $this->assertGuest();
    $response->assertRedirect('/login');
});
