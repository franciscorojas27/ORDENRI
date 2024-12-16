<?php
use App\Models\User;
use App\Models\Order;


test('Muestra las ordenes con el filtro', function () {
    $user = User::factory()->create(); 
    $this->actingAs($user); 

    Order::factory()->create(['created_at' => now()->month(5)->year(2024)]);
    Order::factory()->create(['created_at' => now()->month(6)->year(2024)]);

    $response = $this->get('/orders/consultation/index?month=5&year=2024');

    $response->assertStatus(200);

    $response->assertViewHas('orders', function ($orders) {
        return $orders->count() === 1 && $orders->first()->created_at->month === 5;
    });
});

test('Muestra la pantalla de ordenes sin el filtro', function () {
    $user = User::factory()->create(); 
    $this->actingAs($user);

    Order::factory()->create(['created_at' => now()->month(5)->year(2024)]);
    Order::factory()->create(['created_at' => now()->month(6)->year(2024)]);

    $response = $this->get(route('order.consultation.index'));

    $response->assertStatus(200);

});
test('Muestra los detalles de las ordenes que se consulto', function () {
    $user = User::factory()->create(); 
    $this->actingAs($user); 

    $order = Order::factory()->create();

    $response = $this->get(route('order.consultation.show', $order));

    $response->assertStatus(200);

    $response->assertViewHas('order', $order);
});

test('Descarga el pdf de la orden consultada', function () {
    $user = User::factory()->create(); 
    $this->actingAs($user); 

    $order = Order::factory()->create();

    $response = $this->get(route('order.consultation.download', $order));

    $response->assertStatus(200);

    $response->assertHeader('Content-Type', 'application/pdf');
});



