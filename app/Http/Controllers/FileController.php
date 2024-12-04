<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
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
    public function deleteFile(Order $order, File $file)
    {
        if ($file->order_id !== $order->id) {
            abort(403, 'No autorizado a eliminar este archivo');
        }

        if (Storage::exists($file->file_path)) {
            Storage::delete($file->file_path);
        }

        $file->delete();

        return redirect()->route('order.show', $order)
            ->with('success', 'Archivo eliminado con éxito');
    }

}
