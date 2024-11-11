<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                @if (session('message'))
                    {{ __('Services orders') }}: {{ session('message') }}
                @else
                    {{ __('Services orders') }}
                @endif
            </h2>
            @can('canCreateOrder', Auth::user())
                <a href="{{ route('order.create') }}"
                    class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    {{ __('Create Order') }}
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="overflow-x-auto select-none">
                    @if (request()->routeIs('order.index'))
                        <div
                            class="bg-mejor-color border-8 m-4 p-6 dark:bg-mejor-color-dark dark:border-gray-700 w-lg rounded-lg shadow-lg  flex flex-wrap gap-6">
                            <!-- Resolution Area -->
                            <div class="flex-1 min-w-[200px]">
                                <form action="{{ route('order.index') }}" method="GET">
                                    <x-input-label for="resolution_area"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                        :value="__('Resolution Area')" />
                                    <div class="relative">
                                        <select id="resolution_area" name="resolution_area"
                                            class="block py-3 pl-10 pr-3 w-full text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800"
                                            onchange="this.form.submit()">
                                            <option value="" class="text-gray-500 dark:text-gray-400" disabled
                                                selected>-- {{ __('Select an option') }} --</option>
                                            @foreach ($resolution_areas->sortBy('area') as $resolution_area)
                                                <option value="{{ $resolution_area->id }}"
                                                    {{ request('resolution_area') == $resolution_area->id ? 'selected' : '' }}>
                                                    {{ $resolution_area->area }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 6h16M4 12h16m-7 6h7" />
                                            </svg>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Type -->
                            <div class="flex-1 min-w-[200px]">
                                <form action="{{ route('order.index') }}" method="GET">
                                    <x-input-label for="type"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                        :value="__('Types')" />
                                    <div class="relative">
                                        <select id="type" name="type"
                                            class="block py-3 pl-10 pr-3 w-full text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800"
                                            onchange="this.form.submit()">
                                            <option value="" class="text-gray-500 dark:text-gray-400" disabled
                                                selected>-- {{ __('Select an option') }} --</option>
                                            @foreach ($types->sortBy('type') as $type)
                                                <option value="{{ $type->id }}"
                                                    {{ request('type') == $type->id ? 'selected' : '' }}>
                                                    {{ $type->type }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 6h16M4 12h16m-7 6h7" />
                                            </svg>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Status -->
                            <div class="flex-1 min-w-[200px]">
                                <form action="{{ route('order.index') }}" method="GET">
                                    <x-input-label for="status"
                                        class="block text-sm font-medium text-gray-700 dark:text-gray-300"
                                        :value="__('Status')" />
                                    <div class="relative">
                                        <select id="status" name="status"
                                            class="block py-3 pl-10 pr-3 w-full text-base text-black bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-700 focus:outline-none focus:ring-0 focus:border-indigo-500 dark:bg-gray-800"
                                            onchange="this.form.submit()">
                                            <option class="text-gray-500 dark:text-gray-400" disabled selected
                                                value="">-- {{ __('Select an option') }} --</option>
                                            @foreach ($statuses->sortBy('status') as $status)
                                                <option value="{{ $status->id }}"
                                                    {{ request('status') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->status }}
                                                </option>
                                            @endforeach
                                        </select>
                                        <div
                                            class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                            <svg class="w-5 h-5 text-gray-500 dark:text-gray-400"
                                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M4 6h16M4 12h16m-7 6h7" />
                                            </svg>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            <!-- Filter Button -->
                            <div class="flex justify-end flex-none">
                                <a class="p-4 text-white transition-all duration-500 ease-in-out transform hover:scale-105"
                                    href="{{ route('order.index') }}">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="w-8 h-8">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                    </svg>
                                </a>
                            </div>
                        </div>
                    @endif
                    <x-table-order :orders="$orders" :route="$getRedirectRoute">
                    </x-table-order>
                </div>
            </div>
        </div>
    </div>
    {{ $orders->onEachSide(5)->links('pagination::tailwind') }}
</x-app-layout>
