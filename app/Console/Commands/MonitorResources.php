<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonitorResources extends Command
{
    protected $signature = 'monitor:resources';
    protected $description = 'Monitorea la cantidad de usuarios, uso de memoria, espacio en disco y memoria GPU.';

    public function handle()
    {
        while (true) {
            // Contar usuarios
            $userCount = DB::table('users')->count();

            // Obtener uso de memoria del sistema
            $memoryUsage = $this->getSystemMemoryUsage();

            // Obtener uso de disco
            $diskTotal = disk_total_space("/") / 1024 / 1024; // Total en MB
            $diskFree = disk_free_space("/") / 1024 / 1024; // Libre en MB
            $diskUsed = $diskTotal - $diskFree;

            // Obtener uso de GPU
            $gpuMemoryUsed = $this->getGPUMemoryUsage();

            // Loggear los resultados
            Log::info("Cantidad de usuarios: $userCount, Uso de RAM: " . number_format($memoryUsage['used'], 2) . ' MB / ' . number_format($memoryUsage['total'], 2) . ' MB, Espacio en disco: ' . number_format($diskUsed, 2) . ' MB / ' . number_format($diskTotal, 2) . ' MB, GPU Memory Usage: ' . number_format($gpuMemoryUsed, 2) . ' MB');

            // Esperar 10 segundos antes de la siguiente verificación
            sleep(10);
        }
    }

    protected function getSystemMemoryUsage()
    {
        // Para Linux
        if (PHP_OS_FAMILY === 'Linux') {
            $output = shell_exec('free -m'); // Obtener el uso de memoria en MB
            $lines = explode("\n", $output);
            $memoryInfo = preg_split('/\s+/', $lines[1]);

            return [
                'total' => (int)$memoryInfo[1], // Memoria total
                'used' => (int)$memoryInfo[2],   // Memoria usada
            ];
        }

        // Para Windows
        if (PHP_OS_FAMILY === 'Windows') {
            $output = shell_exec('powershell -command "Get-Process | Measure-Object -Property WS -Sum | Select-Object -ExpandProperty Sum"');
            $usedMemory = (int)$output / 1024 / 1024; // Convertir a MB
            return ['total' => 0, 'used' => $usedMemory]; // Solo el usado, total no se puede obtener de esta manera
        }

        return ['total' => 0, 'used' => 0]; // Valor por defecto si no es ni Linux ni Windows
    }

    protected function getGPUMemoryUsage()
    {
        // Aquí implementa la lógica para obtener el uso de la memoria GPU según tu sistema
        // Esto varía según el sistema operativo y las herramientas disponibles
        // Puedes usar comandos específicos o bibliotecas para acceder a esta información
        return 0; // Placeholder
    }
}
