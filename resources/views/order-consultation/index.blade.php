<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            @if (session('message'))
            {{ __('Service Order Consultation') }}: {{ session('message') }}
            @else
            {{ __('Service Order Consultation') }}
            @endif
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto select-none">
                    <div
                        class="bg-mejor-color border-8 m-4 p-6 dark:bg-mejor-color-dark dark:border-gray-700 rounded-lg shadow-lg flex flex-wrap gap-6">
                        <form action="{{ route('order.consultation.index') }}" method="GET"
                            class="flex flex-wrap gap-4 w-full" id="Form-Filter">
                            <div class="flex-1 min-w-[200px]">
                                <x-input-label for="month"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    :value="__('Month')" />
                                <div class="relative">
                                    <select required id="month" name="month"
                                        class="block w-full py-3 pl-10 pr-3 text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800">
                                        <option value="" class="text-gray-500 dark:text-gray-400" disabled
                                            selected>-- {{ __('Selecciona un mes') }} --</option>
                                        @foreach (range(1, 12) as $month)
                                            <option value="{{ $month }}">
                                                {{ strftime('%B', mktime(0, 0, 0, $month, 1)) }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="flex-1 min-w-[200px]">
                                <x-input-label for="year"
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                    :value="__('Year')" />
                                <div class="relative">
                                    <select required id="year" name="year"
                                        class="block w-full py-3 pl-10 pr-3 text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800">
                                        <option value="" class="text-gray-500 dark:text-gray-400" disabled
                                            selected>-- {{ __('Selecciona un año') }} --</option>
                                        @foreach (range(date('Y'), date('Y') - 5) as $year)
                                            <option value="{{ $year }}">{{ $year }}</option>
                                        @endforeach
                                    </select>
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 6h16M4 12h16m-7 6h7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>

                            <div class="flex justify-end flex-none">
                                <button type="submit"
                                    class="p-4 text-white transition-all duration-500 ease-in-out transform hover:scale-105">
                                    <svg class="h-10 w-10 text-gray-500" viewBox="0 0 24 24" fill="none"
                                        stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                        stroke-linejoin="round">
                                        <circle cx="11" cy="11" r="8" />
                                        <line x1="21" y1="21" x2="16.65" y2="16.65" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                    @if (isset($orders) && $orders->isNotEmpty())
                        <table
                            class="min-w-[700px] w-full text-sm text-left select-text text-gray-900 dark:text-gray-100">
                            <thead class="text-xs dark:text-gray-400 uppercase bg-blue-600  dark:bg-gray-700">
                                <tr>
                                    <th scope="col" class="px-6 py-3">N° orden</th>
                                    <th scope="col" class="px-6 py-3">Tipo</th>
                                    <th scope="col" class="px-6 py-3">Area de resolucion</th>
                                    <th scope="col" class="px-6 py-3">Fecha de creacion</th>
                                    <th scope="col" class="px-6 py-3">Descripcion</th>
                                    <th scope="col" class="px-6 py-3">Estado</th>
                                    <th scope="col" class="px-6 py-3"></th>
                                    @canany(['isAdmin', 'isSupervisor'], Auth::user())
                                        <th scope="col" class="px-3 py-3"> </th>
                                    @endcanany
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($orders as $order)
                                    <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 mb-2">
                                        <td class="px-6 py-4">{{ $order->id }}</td>
                                        <td class="px-6 py-4">{{ $order->type->type }}</td>
                                        <td class="px-6 py-4">{{ $order->resolutionArea->area }}</td>
                                        <td class="px-6 py-4">
                                            {{ $order->created_at->format('d/m/Y') }}<br>{{ $order->created_at->format('H:i') }}
                                        </td>
                                        <td class="px-6 py-4">{{ $order->client_description }}</td>
                                        <td class="px-6 py-4">{{ $order->status->status }}</td>
                                        <td class="px-6 py-4">
                                            <a href="{{ route('order.show', $order) }}"
                                                class="text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 py-2 px-4 rounded-md">
                                                Ver
                                            </a>
                                        </td>
                                        <td class="px-3 py-4">
                                            <form id="delete-order-{{ $order->id }}">
                                                <a href="{{ route('order.consultation.download', $order) }}"
                                                    target="_blank"
                                                    class="text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 py-2 px-4 rounded-md">
                                                    Imprimir
                                                </a>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
