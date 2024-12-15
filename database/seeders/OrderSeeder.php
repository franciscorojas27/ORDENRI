<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear 50 órdenes con estado pendiente
        // Order::factory()->count(10)->orderStatusPending()->create();

        // Crear 30 órdenes con estado iniciado
        // Order::factory()->count(10)->orderStatusStarted()->create();

        // Crear 20 órdenes con estado finalizado
        Order::factory()->count(60)->orderStatusEnd()->create();
    }
}
