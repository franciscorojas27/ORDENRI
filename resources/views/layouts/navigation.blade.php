<nav x-data="{ open: false }"
    class="bg-[#fOede7] dark:bg-gray-800 border-b border-gray-500 md:border-none dark:border-gray-700">
    <!-- Primary Navigation Menu -->
    <div class="w-full px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex">
                <!-- Logo -->
                <div class="flex items-center sm:block md:hidden":class="{
                    'md:hidden sm:block': sideNav,
                    'sm:block md:block': !sideNav
                 }">
                    <a href="{{ route('order.index') }}">
                        <x-application-logo
                            class="block  h-6 w-auto fill-current text-gray-800 dark:text-gray-200 sm:h-full " />
                    </a>
                </div>
                <div class="hidden
                md:flex lg:flex lg:items-center">
                    <button @click="toggleSideNav()"
                        class="flex text-black dark:text-white  dark:hover:bg-gray-800 items-center rounded-full shadow-lg transform hover:scale-105 transition-transform duration-200 top-4 left-4 z-50">
                        <svg class="w-10 justify-center  h-10 " data-slot="icon" fill="none" stroke-width="1.5"
                            stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"
                            aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                        </svg>
                    </button>
                    @isset($header)
                        <header class="max-w-7xl py-2 px-4 sm:px-6 lg:px-8 text-sm max-860:hidden">
                            {{ $header }}
                        </header>
                    @endisset

                </div>
            </div>

            <!-- Settings Dropdown -->
            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button
                            class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-semibold rounded-md text-black dark:text-white bg-[#fOede7] dark:bg-gray-800 hover:text-gray-700 dark:hover:text-gray-300 focus:outline-none transition ease-in-out duration-150">
                            <div>
                                {{ Auth::user()->jobTitle->title . ' | ' . Auth::user()->name . ' ' . Auth::user()->last_name }}
                            </div>

                            <div class="ms-1">
                                <svg class="fill-current h-4 w-4" xmlns="http://www.w3.org/2000/svg"
                                    viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                        clip-rule="evenodd" />
                                </svg>
                            </div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            {{ __('Profile') }}
                        </x-dropdown-link>

                    </x-slot>
                </x-dropdown>

                <form class="ml-2" method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="text-white bg-red-600 hover:bg-red-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 py-1 px-2 rounded-md text-xs font-medium">
                        {{ __('Log Out') }}
                    </button>
                </form>

            </div>

            <!-- Hamburger -->
            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = ! open"
                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 dark:text-gray-500 hover:text-gray-500 dark:hover:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-900 focus:outline-none focus:bg-gray-100 dark:focus:bg-gray-900 focus:text-gray-500 dark:focus:text-gray-400 transition duration-150 ease-in-out">
                    <svg class="h-6 w-6" stroke="currentColor" fill="none" viewBox="0 0 24 24">
                        <path :class="{ 'hidden': open, 'inline-flex': !open }" class="inline-flex"
                            stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                        <path :class="{ 'hidden': !open, 'inline-flex': open }" class="hidden" stroke-linecap="round"
                            stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Responsive Navigation Menu -->
    <div :class="{ 'block': open, 'hidden': !open }" class="hidden sm:hidden">
        <div class="pt-2 pb-3 space-y-1">
            <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                {{ __('Dashboard') }}
            </x-responsive-nav-link>
        </div>

        <!-- Responsive Settings Options -->
        <div class="pt-4 pb-1 border-t border-gray-200 dark:border-gray-600">
            <div class="px-4">
                <div class="font-medium text-base text-gray-800 dark:text-gray-200">
                    {{ Auth::user()->jobTitle->title . ' | ' . Auth::user()->name }}</div>
                <div class="font-medium text-sm text-gray-500">{{ Auth::user()->email }}</div>
            </div>

            <div class="mt-3 space-y-1">
                <x-responsive-nav-link :href="route('profile.edit')">
                    {{ __('Profile') }}
                </x-responsive-nav-link>
                <x-responsive-nav-link :href="route('order.index')">
                    {{ __('Orders') }}
                </x-responsive-nav-link>
                <x-responsive-nav-div>
                    <div class="flex items-center sm:ml-auto">
                        <!-- Switch para el menú responsive -->
                        <label for="theme-toggle-responsive"
                            class="mr-2 dark:text-gray-300 text-sm">{{ __('Dark Mode') }}</label>
                        <label class="inline-flex relative items-center cursor-pointer">
                            <input id="theme-toggle-responsive" type="checkbox" class="sr-only peer" />
                            <div
                                class="w-14 h-8 bg-gray-300 rounded-full peer dark:bg-gray-600 peer-checked:bg-blue-600 transition-all duration-300 ease-in-out">
                            </div>
                            <span
                                class="absolute left-1 top-1 w-6 h-6 bg-white rounded-full shadow-md peer-checked:translate-x-6 peer-checked:bg-white transition-all duration-300 ease-in-out"></span>
                        </label>
                    </div>
                </x-responsive-nav-div>
                <!-- Authentication -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <x-responsive-nav-link :href="route('logout')"
                        onclick="event.preventDefault();
                                        this.closest('form').submit();">
                        {{ __('Log Out') }}
                    </x-responsive-nav-link>
                </form>
            </div>
        </div>
    </div>
</nav>
