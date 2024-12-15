<?php

namespace App\Services;

use Carbon\Carbon;

class SlaCalculator
{
    /**
     * Calcular el SLA para una orden
     *
     * @param \App\Models\Order $order
     * @return string
     */
    public function calculateSla($order)
    {
        switch ($order->type_id) {
            case 1: // Mantenimiento
            case 2: // Soporte
                return $this->calculateBusinessHoursSla($order);

            case 3: // Falla
                return $this->calculateFailureSla($order);

            default:
                return 'Tipo de orden no válido';
        }
    }

    /**
     * Calcular el SLA para mantenimiento o soporte (sin contar fines de semana)
     *
     * @param \App\Models\Order $order
     * @return string
     */
    private function calculateBusinessHoursSla($order)
    {
        $start = Carbon::parse($order->created_at);
        $end = Carbon::parse($order->end_at);

        $totalBusinessHours = 0;

        while ($start < $end) {

            if (!$start->isWeekend()) {

                $currentStart = max($start, $start->copy()->setTime(8, 0));

                $currentEnd = min($end, $start->copy()->setTime(16, 30));

                if ($currentStart < $currentEnd) {
                    $totalBusinessHours += $currentStart->diffInMinutes($currentEnd) / 60;
                }
            }

            $start->addDay()->setTime(8, 0);
        }

        return $totalBusinessHours;
    }

    /**
     * Calcular el SLA para falla (24 horas, contando fines de semana)
     *
     * @param \App\Models\Order $order
     * @return string
     */
    private function calculateFailureSla($order)
    {
        $start = Carbon::parse($order->created_at);
        $end = Carbon::parse($order->end_at);

        $diffInHours = $start->diffInHours($end);
        return $diffInHours;

    }
    /**
     * Calcular el promedio del SLA y su porcentaje en comparación con una referencia.
     *
     * @param float $totalSla El valor total del SLA para todas las  ordenes.
     * @param int $count El numero de  ordenes para calcular el promedio.
     * @param float|int $reference El valor de referencia del SLA para calcular el porcentaje.
     * @return array|string Devuelve un array con el promedio del SLA y el porcentaje
     *                      formateados, o un mensaje si no se encontraron  ordenes.
     */
    public static function calculateAverageSla($totalSla, $count, $reference)
    {
        if ($count > 0) {
            $averageSla = $totalSla / $count;

            $percentage = ($reference / $averageSla) * 100;

            if ($percentage >= 100) {
                $percentage = 100;
            }

            return [
                number_format($averageSla, 2),   
                number_format($percentage, 2)    
            ];
        }

        return [0,0]; 
    }




}