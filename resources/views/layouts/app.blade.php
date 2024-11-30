<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js', 'resources/js/switchColor.js'])

    </head>

    <body class="font-sans antialiased overflow-x-hidden">
        <div class="grid grid-cols-[auto_1fr] h-screen bg-[#F5efd7] dark:bg-gray-950" x-data="sidebarData()"
            x-init="init" x-cloak>

            <!-- Sidebar -->
            <aside class="h-full z-10">
                <x-sidebar></x-sidebar>
            </aside>

            <!-- Main Content -->
            <main class="flex flex-col overflow-hidden">

                <!-- Header (fijo en la parte superior) -->
                <header class="fixed top-0 left-0 md:left-64 right-0 z-4 bg-white dark:bg-gray-900 shadow-sm shadow-b "                    :class="{
                        'md:left-64': sideNav,
                        /* Cuando sideNav está abierto */
                        'md:left-0': !sideNav /* Cuando sideNav está oculto */
                    }">
                    @include('layouts.navigation')

                    @isset($header)
                        <header class="bg-white dark:bg-gray-900 shadow sm:hidden">
                            <div class="max-w-7xl mx-auto py-2 px-4 sm:px-6 lg:px-8">
                                {{ $header }}
                            </div>
                        </header>
                    @endisset
                </header>

                <!-- Contenedor principal con margen superior para el header fijo -->
                <div class="flex-1 overflow-y-auto mt-16 pt-20 md:pt-2">
                    <!-- Aquí va el contenido del slot -->
                    {{ $slot }}
                    <!-- Footer (en la parte inferior) -->
                    <x-footer-app></x-footer-app>
                </div>

            </main>

        </div>
    </body>

