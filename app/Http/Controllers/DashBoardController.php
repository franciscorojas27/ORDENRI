<?php

namespace App\Http\Controllers;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\Status;
use Illuminate\Http\Request;
use App\Services\SlaCalculator;

class DashBoardController extends Controller
{
    private $SLA_GOAL_MAINTENANCE_SUPPORT;
    private $SLA_GOAL_FAULT;

    public function __construct()
    {
        $this->SLA_GOAL_MAINTENANCE_SUPPORT = config('sla.sla_values.sla_maintenance_support');
        $this->SLA_GOAL_FAULT = config('sla.sla_values.sla_fault');
    }

    public function index(Request $request)
    {

        if (!$request->query('month') && !$request->query('year')) {
            return view('dashboard.dashboard');
        }

        $month = $request->query('month');
        $year = $request->query('year');

        $ordersCount = [
            Order::whereMonth('created_at', $month)
                ->whereYear('created_at', $year)
                ->count(),
            Order::whereMonth('end_at', $month)
                ->whereYear('end_at', $year)
                ->count()
        ];
        if ($ordersCount[0] === 0 || $ordersCount[1] === 0) {

            session()->flash('ERROR_MESSAGE', 'No se encontraron ordenes para el mes y año especificados.');
            return view('dashboard.dashboard');
        }


        $supportAndMaintenances = Order::where('status_id', 3)
            ->whereMonth('end_at', $month)
            ->whereYear('end_at', $year)
            ->whereIn('type_id', [1, 2])
            ->whereNotNull('end_at')
            ->get();

        $faults = Order::where('status_id', 3)
            ->whereMonth('end_at', $month)
            ->whereYear('end_at', $year)
            ->where('type_id', '3')
            ->whereNotNull('end_at')
            ->get();
            

        $slaCalculator = new SlaCalculator();

        $slaFault = 0;
        foreach ($faults as $fault) {
            $slaFault += $slaCalculator->calculateSla($fault);
        }
        $countSlaFaults = $faults->count();

        $slaSupportAndMaintenance = 0;
        foreach ($supportAndMaintenances as $order) {
            $slaSupportAndMaintenance += $slaCalculator->calculateSla($order);
        }
        $countSupportAndMaintenances = $supportAndMaintenances->count();


        $supportAndMaintenanceValues = $slaCalculator->calculateAverageSla($slaSupportAndMaintenance, $countSupportAndMaintenances, $this->SLA_GOAL_MAINTENANCE_SUPPORT);

        $faultValues = $slaCalculator->calculateAverageSla($slaFault, $countSlaFaults, $this->SLA_GOAL_FAULT);

        $counts = Order::join('statuses as s', 's.id', '=', 'orders.status_id')
            ->whereMonth('orders.created_at', $month)
            ->whereYear('orders.created_at', $year)
            ->selectRaw('s.status, COUNT(*) as count')
            ->groupBy('s.status')
            ->pluck('count', 's.status')
            ->toArray();

        $statusList = Status::whereIn('id', [1, 2, 3])->pluck('status')->toArray();
        foreach ($statusList as $status) {
            if (!array_key_exists($status, $counts)) {
                $counts[$status] = 0;
            }
        }

        $orders = collect($supportAndMaintenances)->merge($faults)->sortByDesc('id');

        return view('dashboard.dashboard', [
            'counts' => $counts,
            'orders' => $orders,
            'sla_goal_fault' => $this->SLA_GOAL_FAULT,
            'sla_goal_maintenance_support' => $this->formatTime($this->SLA_GOAL_MAINTENANCE_SUPPORT),
            'slaSupportAndMaintenanceTime' => $this->formatTime($supportAndMaintenanceValues[0]),
            'slaSupportAndMaintenancePercentage' => $supportAndMaintenanceValues[1],
            'slaFaultTime' => $this->formatTime($faultValues[0]),
            'slaFaultPercentage' => $faultValues[1],
            'ordersCount' => $ordersCount,
            'fautCount' => $countSlaFaults,
            'supportMaintenanceCount' => $countSupportAndMaintenances,
            'monthYear' => [$month, $year],
        ])->render();
    }
    /**
     * Convierte un número decimal de horas a una cadena en el formato HH:MM.
     *
     * @param float $decimalHours
     * @return string
     */
    public function formatTime($decimalHours)
    {
        $hours = floor($decimalHours);
        $minutes = round(($decimalHours - $hours) * 60);

        $carbonTime = Carbon::today()->addHours($hours)->addMinutes($minutes);

        $formattedTime = $carbonTime->format('H:i');

        return $formattedTime;
    }
}
