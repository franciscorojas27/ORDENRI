<div
    class="bg-white dark:bg-gray-900 border border-gray-300 dark:border-gray-700 m-4 p-6 rounded-lg shadow-lg flex flex-wrap gap-6 justify-between">
    <form action="{{ route('dashboard') }}" method="GET" class="flex flex-wrap gap-4 w-full"
        id="Form-Filter">
        <!-- Select Month -->
        <x-filter-select id="month" name="month" label="Month" :colorBackGround="'bg-gray-900'" :options="collect(range(1, 12))->map(function ($month) {
            return ['value' => $month, 'label' => __(strftime('%B', mktime(0, 0, 0, $month, 1)))];
        })" :selected="request('month')"
            placeholder="Month" />

        <!-- Select Year -->
        <x-filter-select id="year" name="year" label="Year" :colorBackGround="'bg-gray-900'" :options="collect(range(date('Y'), 2015))->map(function ($year) {
            return ['value' => $year, 'label' => $year];
        })"
            :selected="request('year')" placeholder="Year" />

        <!-- Submit Button -->
        <div class="flex items-center gap-4">
            <button type="submit" aria-label="Filter"
                class="px-4 py-2 rounded-lg bg-gray-800 dark:bg-gray-700 text-white dark:text-gray-200 
                                           hover:bg-gray-700 dark:hover:bg-gray-600 
                                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 
                                           transition-transform duration-300 ease-in-out transform hover:scale-105">
                <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                    stroke-linecap="round" stroke-linejoin="round">
                    <circle cx="11" cy="11" r="8" />
                    <line x1="21" y1="21" x2="16.65" y2="16.65" />
                </svg>
            </button>
        </div>
    </form>
</div>
