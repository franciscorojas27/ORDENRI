<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    
    
    /**
     * Ejecuta los seeders de la base de datos.
     *
     * Crea 19 usuarios, y un usuario con email admin@admin.com, contraseña 12345678
     * y nombre Administrador del sistema.
     *
     * @return void
     */
    public function run(): void
    {
        User::factory(count: 19)->create();
        $user = User::create([
            'name' => 'Administrador',
            'last_name' => 'del sistema',
            'resolution_area_id' => 1,
            'job_title_id' => 4,
            'can_create_orders' => 1,
            'phone' => '04121234567',
            'ip_address' => '127.0.0.1',
            'password_may_expire' => true,
            'coordination_management' => true,
            'last_connection' => now(),
            'general_management_id' => 1,
            'email' => 'admin@admin.com',
            'password_may_expire_at' => now()->addDays(30),
            'password' => Hash::make(config('custom.default_admin_password',123456789)),
        ]);
    }
}
