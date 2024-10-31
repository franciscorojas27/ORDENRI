<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

class MusicController extends Controller
{
    public function index()
    {
        // Obtiene una lista de canciones desde el almacenamiento privado
        $files = Storage::disk('local')->files('audio');
        $songs = array_map(function ($file) {
            return basename($file); // Obtén solo el nombre del archivo
        }, $files);

        return view('music.index', compact('songs'));
    }

    public function streamAudio($filename)
    {
        // Verifica si el archivo existe en el almacenamiento privado
        if (!Storage::disk('local')->exists("audio/{$filename}")) {
            abort(404, 'Archivo no encontrado');
        }

        // Crea una respuesta transmitida (streaming) para el archivo de audio
        return new StreamedResponse(function () use ($filename) {
            $fileStream = Storage::disk('local')->readStream("audio/{$filename}");
            fpassthru($fileStream);
            fclose($fileStream);
        }, 200, [
            "Content-Type" => "audio/mpeg",
            "Content-Disposition" => 'inline; filename="' . $filename . '"',
        ]);
    }
}
