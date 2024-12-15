<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Statistics') }}
        </h2>
    </x-slot>
    @vite(['resources/js/chartDashboard.js'])

    <div class="py-6 {{ !isset($counts) ? 'h-full' : '' }}">
        <div class="max-w-6xl mx-auto sm:px-4 lg:px-6">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg">
                <div class="p-4 text-gray-900 dark:text-gray-100 ">
                    <!-- Filter -->
                    @include('dashboard.partials.filter')
                    @if (session('ERROR_MESSAGE'))
                        <div class="bg-green-100 border-t-4 border-green-500 rounded-b text-green-900 px-4 py-3 shadow-md" role="alert">
                            <div class="flex">
                                <div>
                                    <p class="text-sm">{{ session('ERROR_MESSAGE') }}</p>
                                </div>
                            </div>
                        </div>
                        <script>
                            setTimeout(function() {
                                document.querySelector(".bg-green-100").remove();
                            }, 3000);
                        </script>
                    @endif
                    

                    @if (isset($counts))
                        <!-- body dashboard -->
                        @include('dashboard.partials.body')
                    @endif
                
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
