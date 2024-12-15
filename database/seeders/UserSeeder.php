<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(count: 19)->create();
        $user = User::create([
            'name' => 'Administrador',
            'last_name' => 'del sistema',
            'resolution_area_id' => 1,
            'job_title_id' => 4,
            'phone' => '04121234567',
            'ip_address' => '127.0.0.1',
            'password_may_expire' => true,
            'coordination_management' => true,
            'last_connection' => now(),
            'general_management_id' => 1,
            'email' => 'admin@admin.com',
            'password_may_expire_at' => now()->addDays(30),
            'password' => Hash::make('12345678'),
        ]);
    }
}
