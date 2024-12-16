<?php
use App\Models\File;
use App\Models\User;
use App\Models\Order;
use Illuminate\Support\Facades\Storage;

test('El usuario puede eliminar el archivo si está autorizado', function () {
    $user = User::factory()->create();

    $order = Order::factory()->create();
    $file = File::factory()->create([
        'order_id' => $order->id,
        'file_path' => 'path/to/file.txt',
        'file_name' => 'file',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'size' => 1024,
        'original_name' => 'file.txt'
    ]);

    Storage::fake('local');
    Storage::put($file->file_path, 'Contenido del archivo');

    $this->actingAs($user);

    $response = $this->delete(route('order.files.delete', ['order' => $order->id, 'file' => $file->id]));

    $response->assertRedirect(route('order.edit', $order->id));

    Storage::assertMissing($file->file_path);

    $this->assertDatabaseMissing('files', ['id' => $file->id]);
});

test('El usuario no puede eliminar el archivo si no está autorizado', function () {
    $user = User::factory()->create();

    $order = Order::factory()->create();
    $file = File::factory()->create([
        'order_id' => $order->id,
        'file_path' => 'path/to/file.txt',
        'file_name' => 'file',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'size' => 1024,
        'original_name' => 'file.txt'
    ]);

    $this->actingAs($user);

    $response = $this->delete(route('order.files.delete', ['order' => $order->id, 'file' => $file->id]));

    $response->assertStatus(403);
});

test('El usuario no puede eliminar el archivo si no existe', function () {
    $user = User::factory()->create();

    $order = Order::factory()->create();
    $file = File::factory()->create([
        'order_id' => $order->id,
        'file_path' => 'path/to/file.txt',
        'file_name' => 'file',
        'mime_type' => 'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        'size' => 1024,
        'original_name' => 'file.txt'
    ]);

    $this->actingAs($user);

    $response = $this->delete(route('order.files.delete', ['order' => $order->id, 'file' => $file->id]));

    $response->assertStatus(403);
});