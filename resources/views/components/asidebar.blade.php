<aside class="w-50 bg-white text-gray-800 dark:bg-gray-800 dark:text-white h-screen shadow-lg" 
       x-data="{ open: {{ in_array(Route::currentRouteName(), ['menu.submenu1', 'menu.submenu2', 'menu.submenu3']) ? '1' : 'null' }} }">
    <!-- Sidebar Header -->
    <div class="flex items-center justify-center h-17 border-b border-gray-200 dark:border-gray-700">
        <a href="{{ route('dashboard') }}">
            <x-application-logo class="h-16 w-auto fill-current text-gray-800 dark:text-white" />
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="mt-3">
        <a href="{{ route('order.index') }}"
           class="block px-4 py-3 mb-2 rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('order.index') ? 'bg-blue-600 text-white' : '' }}">
            Cola de ordenes
        </a>
        @cannot('isClient', Auth::user())
            <a href="{{ route('order.group.index') }}"
               class="block px-4 py-3 mb-2 rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('order.group.index') ? 'bg-blue-600 text-white' : '' }}">
                Ordenes Pendientes
            </a>
        @endcannot
        <a href="{{ route('order.consultation.index') }}"
           class="block px-4 py-3 mb-2 rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('order.consultation.index') ? 'bg-blue-600 text-white' : '' }}">
            Consulta de ordenes
        </a>
        @can('isAdmin', Auth::user())
            <a href="{{ route('admin-secure.index') }}"
               class="block px-4 py-3 mb-2 rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('admin-secure.index') ? 'bg-blue-600 text-white' : '' }}">
                Administrador
            </a>
        @endcan
        @cannot('isClient', Auth::user())
            <a href="{{ route('dashboard') }}"
               class="block px-4 py-3 mb-2 rounded-md transition duration-200 hover:bg-blue-600 hover:text-white {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white' : '' }}">
                Panel
            </a>
        @endcannot
    </nav>
</aside>
