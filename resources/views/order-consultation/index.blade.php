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
                                <button type="submit" aroal-label="Filter"
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
                        <x-table-order :orders="$orders" :route="$getRedirectRoute">
                        </x-table-order>
                    @endif
                </div>
            </div>
        </div>
    </div>

</x-app-layout>
