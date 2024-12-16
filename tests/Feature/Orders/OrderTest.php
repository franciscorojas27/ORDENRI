<?php

use App\Models\User;
use App\Models\Order;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Notification;

test('El usuario puede entrar a la ruta para crear la orden', function () {
    // $this->withoutMiddleware();
    $user = User::factory()->create([
        'job_title_id' => 4,
        'can_create_orders' => '1',
        'general_management_id' => 1,
        'resolution_area_id' => 1,
    ]);
    $this->actingAs($user);
    $response = $this->get(route('order.create'));

    $response->assertStatus(200);
});
test('El usuario puede crear una orden', function () {
    $user = User::factory()->create([
        'job_title_id' => 4,
        'can_create_orders' => '1',
        'general_management_id' => 1,
    ]);
    $this->actingAs($user);

    $response = $this->post(route('order.store'), [
        'user_id' => '1',
        'resolution_areas' => '2',
        'types' => '3',
        'description' => 'Test order description',
        'files' => [
            UploadedFile::fake()->image('test.jpg'),
        ],
    ]);
    $response->assertStatus(302);
    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('order.index'));
    // $this->fail('Failing the test intentionally.'); fuerza el error 

});
test('El usuario puede ver las ordenes', function () {

    $user = User::factory()->create([
        'job_title_id' => 2,
        'can_create_orders' => '1',
        'resolution_area_id' => 1,
        'general_management_id' => 1,
    ]);
    $this->actingAs($user);

    $order = Order::factory()->create();
    $response = $this->get(route('order.show', $order));
    $response->assertStatus(200);

});
test('El supervisor puede ver la pagina de edición de ordenes', function () {

    $user = User::factory()->create([
        'job_title_id' => 3,
        'can_create_orders' => '1',
        'resolution_area_id' => 1,
        'general_management_id' => 1,
    ]);
    $this->actingAs($user);

    $order = Order::factory()->create();
    $response = $this->get(route('order.edit', $order));
    $response->assertStatus(200);

});
test('El supervisor puede editar las ordenes', function () {
    Notification::fake();

    $supervisor = User::factory()->create([
        'job_title_id' => 3,
        'can_create_orders' => '1',
        'general_management_id' => 1,
    ]);

    $order = Order::factory()->create();

    $this->actingAs($supervisor);

    $response = $this->put(route('order.update', $order), [
        'status_id' => '1',
        'type_id' => '2',
        'resolution_area_id' => '3',
        'responsible_id' => '1',
        'created_at' => now()->format('Y-m-d H:i:s'),
        'applicant_to_id' => (string) $supervisor->id,
        'client_description' => 'Updated description',
        'description' => 'Updated description',
    ]);

    $response->assertStatus(302);
    $response->assertSessionHasNoErrors();
    $response->assertRedirect(route('order.edit', $order));

    Notification::assertCount(2);
});
test('El supervisor puede marcar la no conformidad con una orden', function () {

    $supervisor = User::factory()->create([
        'job_title_id' => 3,
        'can_create_orders' => '1',
        'general_management_id' => 1,
    ]);
    $this->actingAs($supervisor);
    $order = Order::factory()->create([
        'status_id' => 3
    ]);


    $response = $this->post(route('order.non-conformity', $order));
    $response->assertStatus(302);
    $response->assertRedirect(route('order.edit', $order));

});
