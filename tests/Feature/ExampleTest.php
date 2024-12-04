<?php

use App\Models\User;
use Database\Seeders\JobTitleSeeder;
use Database\Seeders\ResolutionAreaSeeder;
use Database\Seeders\GeneralManagementsSeeder;

it('can do log in', function () {
    $this->seed(JobTitleSeeder::class);
    $this->seed(ResolutionAreaSeeder::class);
    $this->seed(GeneralManagementsSeeder::class);
    
    $user = User::factory()->create([
        'password' => bcrypt('123456789'),
    ]);

    $response = $this->post('/login', [
        'email' => $user->email,
        'password' => '123456789',
    ]);

    $response->assertStatus(302);
});
