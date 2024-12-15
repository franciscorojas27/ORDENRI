<x-title-section :text_title="__('Orders of Service - Count')" />
<div class="mx-auto grid grid-cols-1 mt-6 mb-6 px-5 sm:grid-cols-2 md:grid-cols-3 gap-3">
    <x-charts.metrics-values :counts="$counts"></x-charts.metrics-values>
</div>

<div class="py-2">
    <x-title-section :text_title="__('Orders of Service - Metrics')" />
    <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
        <div class="bg-white p-4 text-center dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @include('dashboard.partials.cards', [
                    'title' => 'Órdenes de Soporte',
                    'meta' => $sla_goal_maintenance_support . ' H/M',
                    'metaColor' => 'text-blue-600 dark:text-blue-300',
                    'indicator' => $slaSupportAndMaintenanceTime . ' H/M',
                    'indicatorColor' => 'text-blue-600 dark:text-blue-300',
                    'progress' => $slaSupportAndMaintenancePercentage . '%',
                    'description' => 'El tiempo de respuesta tuvo un ' . $slaSupportAndMaintenancePercentage . '% de cumplimiento de la meta establecida.',
                ])

                @include('dashboard.partials.cards', [
                    'title' => 'Órdenes de Mantenimiento',
                    'meta' => $sla_goal_maintenance_support . ' H/M',
                    'metaColor' => 'text-blue-600 dark:text-blue-300',
                    'indicator' => $slaSupportAndMaintenanceTime . ' H/M',
                    'indicatorColor' => 'text-blue-600 dark:text-blue-300',
                    'progress' => $slaSupportAndMaintenancePercentage . '%',
                    'description' => 'El tiempo de respuesta tuvo un ' . $slaSupportAndMaintenancePercentage . '% de cumplimiento de la meta establecida.',
                ])

                @include('dashboard.partials.cards', [
                    'title' => 'Órdenes de Falla',
                    'meta' => $sla_goal_fault . ' H/M',
                    'metaColor' => 'text-red-600 dark:text-red-300',
                    'indicator' => $slaFaultTime . ' H/M',
                    'indicatorColor' => 'text-red-600 dark:text-red-300',
                    'progress' => $slaFaultPercentage . '%',
                    'description' => 'El tiempo de respuesta tuvo un ' . $slaFaultPercentage . '% de cumplimiento de la meta establecida.',
                ])
            </div>

        </div>
    </div>

    <!-- Percentage of fulfillment of indicators -->
    <x-title-section :text_title="__('Porcentaje de las ordenes del mes')" />
    <section class="flex justify-around flex-wrap">
        <canvas id="PieChart1" data-values="[{{$ordersCount[0]}}, {{$ordersCount[1]}} ]" class="mt-6 p-4 shadow-md rounded-md bg-white drop-shadow-md"
            width="400px" height= "400px">
        </canvas>

        <canvas id="PieChart2" data-values="[{{$supportMaintenanceCount}},{{$fautCount}}]" class="mt-6 p-4 shadow-md rounded-md bg-white drop-shadow-md"
            width="400px" height= "400px">
        </canvas>
    </section>
    <x-title-section :text_title="__('Created orders in the month')" />

    <h1 class="text-2xl my-2 font-bold mt-2">{{ __('Created orders') }}</h1>
    
    <label for="dayRange-1" class="text-gray-700 dark:text-gray-300">{{ __('Select the range of days:') }}</label>
    <select id="dayRange-1"
        class="text-gray-700 w-full dark:text-gray-300 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-300 dark:bg-gray-700">
        <option value="30">Final de mes 30 días</option>
        <option value="15">Primeros 15 días</option>
        <option value="7">Primeros 7 días</option>
    </select>

    <canvas class="shadow-md p-3 rounded-md border border-gray-300" data-values="[{{$monthYear[0]}},{{$monthYear[1]}}]" id="myChart" width="320" height="160">
    </canvas>

    <!-- Orders finished in the month -->
    <x-title-section :text_title="__('Orders finished in the month')" />
    <section class="bg-gray-100 dark:bg-gray-900 p-4 rounded-md shadow-md">
        <ul>
            @foreach ($orders as $order)
                <li
                    class="mb-2 flex items-center justify-between py-2 px-4 rounded-md bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-700">
                    <a href="{{ route('order.edit', $order) }}"
                        class="text-blue-500 hover:text-blue-700 dark:text-blue-300 dark:hover:text-blue-400 flex items-center">
                        <span class="font-semibold mr-2">{{ __('Order ID:') }}
                            {{ $order->id }}</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                        </svg>
                    </a>
                    <span class="text-gray-600 dark:text-gray-400">
                        {{ $order->created_at->format('d/m/Y') }}
                    </span>
                </li>
            @endforeach
        </ul>
    </section>
</div>
