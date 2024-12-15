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
    <div class="lg:py-4 ">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div
                    class="bg-mejor-color border-8 m-4 p-6 dark:bg-mejor-color-dark dark:border-gray-700 rounded-lg shadow-lg flex flex-wrap gap-6">
                    <form action="{{ route('order.consultation.index') }}" method="GET"
                        class="flex flex-wrap gap-4 w-full" id="Form-Filter">
                        <x-filter-select id="month" name="month" label="Month" :options="collect(range(1, 12))->map(function ($month) {
                            return ['value' => $month, 'label' => __(strftime('%B', mktime(0, 0, 0, $month, 1)))];
                        })"
                            :selected="request('month')" placeholder="Month" />

                        <x-filter-select id="year" name="year" label="Year" :options="collect(range(date('Y'), 2015))->map(function ($year) {
                            return ['value' => $year, 'label' => $year];
                        })"
                            :selected="request('year')" placeholder="Year" />

                        <x-filter-select id="applicant_to" name="applicant_to" label="Supervisor" :isRequired="false"
                            :options="$responsible->map(function ($responsible) {
                                return [
                                    'value' => $responsible->id,
                                    'label' => $responsible->name . ' ' . $responsible->last_name,
                                ];
                            })" :selected="request('applicant_to')" placeholder="Supervisor" />

                        <x-filter-select id="responsible_to" name="responsible_to" label="Responsible" :isRequired="false"
                            :options="$supervisor->map(function ($supervisor) {
                                return [
                                    'value' => $supervisor->id,
                                    'label' => $supervisor->name . ' ' . $supervisor->last_name,
                                ];
                            })" :selected="request('responsible_to')" placeholder="Responsible" />

                        {{-- Button submit filter --}}
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
                {{-- table orders consultation --}}
                @if (isset($orders) && $orders->isNotEmpty())
                    <div class="overflow-x-auto">
                        <x-table-order :orders="$orders" :route="$getRedirectRoute">
                        </x-table-order>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-app-layout>
