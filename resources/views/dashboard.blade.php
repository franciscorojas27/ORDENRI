<x-app-layout>
    @vite(['resources/js/chartDashboard.js'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
                        {{-- <img src="{{ asset('Server_isAlive.gif') }}" alt="Server is alive" desc="Server is alive"> --}}

                        <x-charts.metrics-values :counts="$counts"></x-charts.metrics-values>
                    </div>
                    <h1 class="text-3xl my-2 font-bold mt-4">{{ __('Closed Orders') }}</h1>
                    <label for="dayRange-1" class="text-gray-700  dark:text-gray-300">Selecciona el rango de
                        días:</label>
                    <select id="dayRange-1"
                        class="text-gray-700 w-full dark:text-gray-300 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-300 dark:bg-gray-700">
                        <option value="30">Últimos 30 días</option>
                        <option value="15">Últimos 15 días</option>
                        <option value="7">Últimos 7 días</option>
                    </select>

                    <canvas class="shadow-lg p-4 rounded-md border border-gray-300" id="myChart" width="400"
                        height="200" data-url="/api/metrics"></canvas>
                    <h1 class="text-3xl my-2 font-bold mt-4">{{ __('Created orders') }}</h1>
                    <label for="dayRange-2" class="text-gray-700 justify-start dark:text-gray-300">Selecciona el
                        rango de
                        días:</label>
                    <select id="dayRange-2"
                        class="text-gray-700 w-full dark:text-gray-300 border border-gray-300 rounded-md p-2 focus:outline-none focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-300 dark:bg-gray-700 transition duration-150 ease-in-out"
                        style="appearance: none; -moz-appearance: none; -webkit-appearance: none;">
                        <option value="30">Últimos 30 días</option>
                        <option value="15">Últimos 15 días</option>
                        <option value="7">Últimos 7 días</option>
                    </select>
                    <canvas id="myChart2" class="shadow-lg p-4 rounded-md border border-gray-300" width="400"
                        height="200" data-url="/api/metrics"></canvas>
                </div>
            </div>
        </div>
        {{-- <audio id="miAudio" loop controls preload="auto">
            <source src="{{ asset('/a.mp3') }}" type="audio/mpeg">
        </audio>
        <script>
            window.onload = function() {
                var audio = document.getElementById('miAudio');
                audio.addEventListener('canplaythrough', function() {
                    audio.play();
                });
            };
        </script> --}}

    </div>
</x-app-layout>
