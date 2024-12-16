<?php

use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Notification;

test('El analista puede cargar la pantalla de ordenes pendientes', function () {
    $user = User::factory()->create([
        'job_title_id' => 2,
        'can_create_orders' => '1',
        'general_management_id' => 1,
        'resolution_area_id' => 1,
    ]);
    $this->actingAs($user);
    $response = $this->get(route('order.group.index'));
    $response->assertStatus(200);
});
test('El analista puede aceptar una orden', function () {
    $user = User::factory()->create([
        'job_title_id' => 2,
        'can_create_orders' => '1',
        'general_management_id' => 1,
        'resolution_area_id' => 1,
    ]);
    $order = Order::create([
        'client_id' => 1,
        'resolution_area_id' => 1,
        'type_id' => 1,
        'description' => 'test description',
        'client_description' => 'test client description',
        'applicant_to_id' =>  $user->id,
        'responsible_id' => $user->id,
        'status_id' => 1
    ]);
    $this->actingAs($user);
    $response = $this->get(route('order.show',$order));
    $response->assertStatus(200);
    
    $response = $this->put(route('order.flow',$order),[
        'description' => 'test description'
    ]);
    $response->assertStatus(302);
    $response->assertRedirect(route('order.index'));

});
test('El analista puede ver la orden que a aceptado', function () {
    $user = User::factory()->create([
        'job_title_id' => 2,
        'can_create_orders' => '1',
        'general_management_id' => 1,
        'resolution_area_id' => 1,
    ]);
    $order = Order::create([
        'client_id' => 1,
        'resolution_area_id' => 1,
        'type_id' => 1,
        'status_id' => 2,
        'description' => 'test description',
        'client_description' => 'test client description',
        'applicant_to_id' =>  $user->id,
        'responsible_id' => $user->id,
    ]);
    $this->actingAs($user);
    $response = $this->get(route('order.group.show',$order));
    $response->assertStatus(200);
});
test('El analista puede finalizar una orden', function () {
    $user = User::factory()->create([
        'job_title_id' => 2,
        'can_create_orders' => '1',
        'general_management_id' => 1,
        'resolution_area_id' => 1,
    ]);
    $order = Order::create([
        'client_id' => 1,
        'resolution_area_id' => 1,
        'type_id' => 1,
        'description' => 'test description',
        'client_description' => 'test client description',
        'applicant_to_id' =>  $user->id,
        'responsible_id' => $user->id,
        'status_id' => 2
    ]);
    $this->actingAs($user);
    $response = $this->get(route('order.show',$order));
    $response->assertStatus(200);
    
    $response = $this->put(route('order.flow',$order),[
        'description' => 'test description'
    ]);

});