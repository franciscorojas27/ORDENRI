<aside x-show="sideNav" style=" transition: none; transform: translate-x-0; opacity: 1;"
    class="overflow-y-auto hidden md:block bg-[#33ccff] dark:bg-gray-900 h-screen z-40 w-64 text-[#E8F5FF]
    dark:text-white shadow-2xl drop-shadow-md">
    <!-- Sidebar Header -->
    <div
        class="flex flex-col items-center justify-center h-17 border-b-2 mr-4 ml-4 pb-3 border-gray-600  dark:border-white mt-2">

        <a href="{{ route('order.index') }}">
            <x-application-logo class="h-16  w-auto fill-current text-[#121212] dark:text-white" />
        </a>

        <h2 class="text-center text-black font-bold dark:text-white w-40">Coordinacion de Red Inteligente</h2>
    </div>
    <!-- Navigation Links -->
    <nav class="mt-3">
        @can('canCreateOrder', Auth::user())
            <a href="{{ route('order.create') }}"
                class="bg-green-500 dark:bg-white hover:bg-white hover:text-black text-white dark:text-black m-4 font-bold py-2 px-4 rounded flex items-center">
                <svg class="h-5 w-5 m-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z"
                        clip-rule="evenodd" />
                </svg>
                {{ __('Create Order') }}
            </a>
        @endcan
        <a href="{{ route('order.index') }}"
            class="flex items-center px-5 py-3 mb-2 ml-4 mr-4 font-bold text-black  dark:text-white rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('order.index') ? 'bg-blue-600 text-white' : '' }}">
            <!-- Ícono -->
            <svg class="w-6 h-6 mr-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M3.75 12h16.5m-16.5 3.75h16.5M3.75 19.5h16.5M5.625 4.5h12.75a1.875 1.875 0 0 1 0 3.75H5.625a1.875 1.875 0 0 1 0-3.75Z">
                </path>
            </svg>
            <!-- Texto -->
            {{ __('Queue Orders') }}
        </a>

        @cannot('isClient', Auth::user())
            <a href="{{ route('order.group.index') }}"
                class="flex items-center px-5 py-3 mb-2 ml-4 mr-4 font-bold text-black dark:text-white rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('order.group.index') ? 'bg-blue-600 text-white' : '' }}">
                <!-- Ícono -->
                <svg class="w-6 h-6 mr-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="m7.875 14.25 1.214 1.942a2.25 2.25 0 0 0 1.908 1.058h2.006c.776 0 1.497-.4 1.908-1.058l1.214-1.942M2.41 9h4.636a2.25 2.25 0 0 1 1.872 1.002l.164.246a2.25 2.25 0 0 0 1.872 1.002h2.092a2.25 2.25 0 0 0 1.872-1.002l.164-.246A2.25 2.25 0 0 1 16.954 9h4.636M2.41 9a2.25 2.25 0 0 0-.16.832V12a2.25 2.25 0 0 0 2.25 2.25h15A2.25 2.25 0 0 0 21.75 12V9.832c0-.287-.055-.57-.16-.832M2.41 9a2.25 2.25 0 0 1 .382-.632l3.285-3.832a2.25 2.25 0 0 1 1.708-.786h8.43c.657 0 1.281.287 1.709.786l3.284 3.832c.163.19.291.404.382.632M4.5 20.25h15A2.25 2.25 0 0 0 21.75 18v-2.625c0-.621-.504-1.125-1.125-1.125H3.375c-.621 0-1.125.504-1.125 1.125V18a2.25 2.25 0 0 0 2.25 2.25Z">
                    </path>
                </svg>
                <!-- Texto -->
                {{ __('Pending Orders') }}
            </a>
        @endcannot
        <a href="{{ route('order.consultation.index') }}"
            class="flex items-center px-5 py-3 mb-2 ml-4 mr-4 font-bold text-black dark:text-white rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('order.consultation.index') ? 'bg-blue-600 text-white' : '' }}">
            <!-- Ícono -->
            <svg class="w-6 h-6 mr-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"></path>
            </svg>
            <!-- Texto -->
            {{ __('Orders Consultation') }}
        </a>

        @can('isAdmin', Auth::user())
            <a href="{{ route('admin-secure.index') }}"
                class="flex items-center px-5 py-3 mb-2 ml-4 mr-4 font-bold text-black dark:text-white rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('admin-secure.index') ? 'bg-blue-600 text-white' : '' }}">
                <!-- Ícono -->
                <svg class="w-6 h-6 mr-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M21.75 6.75a4.5 4.5 0 0 1-4.884 4.484c-1.076-.091-2.264.071-2.95.904l-7.152 8.684a2.548 2.548 0 1 1-3.586-3.586l8.684-7.152c.833-.686.995-1.874.904-2.95a4.5 4.5 0 0 1 6.336-4.486l-3.276 3.276a3.004 3.004 0 0 0 2.25 2.25l3.276-3.276c.256.565.398 1.192.398 1.852Z">
                    </path>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4.867 19.125h.008v.008h-.008v-.008Z"></path>
                </svg>
                <!-- Texto -->
                {{ __('Administrator') }}
            </a>
        @endcan
        {{-- @cannot('isClient', Auth::user())
            <a href="#"
                class="flex items-center px-5 py-3 mb-2 ml-4 mr-4 font-bold text-[#121212] dark:text-gray-600 rounded-md transition duration-200 cursor-not-allowed">
                <svg class="w-6 h-6 mr-2" data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25M9 16.5v.75m3-3v3M15 12v5.25m-4.5-15H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z">
                    </path>
                </svg>
                {{__('Indicators')}}
            </a>
        @endcannot --}}
        @cannot('isClient', Auth::user())
            <a href="{{ route('dashboard') }}"
                class="flex items-center px-5 py-3 mb-2 ml-4 mr-4 font-bold text-black dark:text-white rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : '' }}">
                <!-- Ícono -->
                <svg class="w-6 h-6 mr-2" fill="none" stroke-width="1.5" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M7.5 14.25v2.25m3-4.5v4.5m3-6.75v6.75m3-9v9M6 20.25h12A2.25 2.25 0 0 0 20.25 18V6A2.25 2.25 0 0 0 18 3.75H6A2.25 2.25 0 0 0 3.75 6v12A2.25 2.25 0 0 0 6 20.25Z">
                    </path>
                </svg>
                <!-- Texto -->
                {{ __('Statistics') }}
            </a>
        @endcannot

        <div
            class="flex items-center px-5 py-3 mb-2 ml-4 mr-4  font-bold border-t-2 border-gray-800 dark:border-white pt-2 text-[#E8F5FF] dark:text-white transition  duration-200 ">
            <!-- Switch para el menú principal -->
            <label for="theme-toggle-main"
                class="mr-2 text-sm text-[#121212] dark:text-white">{{ __('Dark Mode') }}</label>
            <label class="relative inline-flex items-center cursor-pointer">
                <input id="theme-toggle-main" type="checkbox" class="sr-only peer" />
                <div
                    class="w-14 h-8 transition-all duration-300 ease-in-out bg-gray-200 rounded-full peer dark:bg-white peer-checked:bg-blue-600">
                </div>
                <span
                    class="absolute w-6 h-6 transition-all duration-300 ease-in-out bg-white rounded-full shadow-md left-1 top-1 peer-checked:translate-x-6 peer-checked:bg-white"></span>
            </label>
        </div>
        <img src="{{ asset('Server_isAlive.gif') }}" alt="Server is alive" desc="Server is alive">
        <h2 class="mr-4 ml-4 fixed bottom-0 text-sm text-black dark:text-white">© 2024
            {{ config('app.name', 'Laravel') }}</h2>
    </nav>
</aside>
