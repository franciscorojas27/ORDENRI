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
        @vite(['resources/css/app.css', 'resources/js/app.js','resources/js/switchColor.js'])
    </head>

    <body class=" font-sans text-gray-900 antialiased">
        <div
            class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#F5efd7] dark:bg-gray-900">
            <div class="relative text-center">
                <a href="/">
                    <x-application-logo class="h-80 w-80 fill-current text-gray-500" />
                </a>
                <h1 class="absolute inset-0 flex items-center justify-center text-xl text-black dark:text-white z-10 mt-48">Coordinacion de Red Inteligente</h1>
            </div>
            <div
                class="w-full sm:max-w-md px-6 py-4 bg-white dark:bg-gray-800 shadow-2xl overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
