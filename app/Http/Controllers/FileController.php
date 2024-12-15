<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Descarga un archivo subido a una orden.
     *
     * @param  \App\Models\Order  $order  La orden a la que pertenece el archivo.
     * @param  \App\Models\File  $file  El archivo a descargar.
     * @return \Symfony\Component\HttpFoundation\StreamedResponse  El archivo descargable.
     */
    public function download(Order $order, File $file)
    {
        if ($file->order_id !== $order->id) {
            abort(403, 'No autorizado a acceder a este archivo');
        }

        if (!Storage::exists($file->file_path)) {
            abort(404, 'Archivo no encontrado');
        }

        return Storage::download($file->file_path, $file->original_name);
    }
    /**
     * Elimina un archivo de una orden.
     *
     * @param  \App\Models\Order  $order  La orden a la que pertenece el archivo.
     * @param  \App\Models\File  $file  El archivo a eliminar.
     * @return \Illuminate\Http\RedirectResponse  La respuesta HTTP que redirige al usuario a la vista de la orden.
     */
    public function deleteFile(Order $order, File $file)
    {
        if ($file->order_id !== $order->id || !Storage::exists($file->file_path)) {
            abort(403, 'No autorizado a eliminar este archivo');
        }

        Storage::delete($file->file_path);
        $file->delete();

        return redirect()->route('order.edit', $order)
            ->with('success', value: 'Archivo eliminado con éxito');
    }

}
