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

    <body class="dark font-sans text-gray-900 antialiased">
        <div
            class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div>
                <a href="/">
                    <x-application-logo class="h-80 w-80 fill-current text-gray-500" />
                </a>
            </div>
            <div
                class="w-full sm:max-w-md  px-6 py-4 bg-white dark:bg-gray-800 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
    </body>
    <script>
        // Función para aplicar el tema guardado
        const applyTheme = () => {
            const theme = localStorage.getItem('theme'); // Obtener el tema guardado
            const rootElement = document.documentElement; // Apunta al <html>

            if (theme === 'dark') {
                rootElement.classList.add('dark'); // Activa el modo oscuro
            } else {
                rootElement.classList.remove('dark'); // Desactiva el modo oscuro
            }
        };

        // Llamada a la función para aplicar el tema guardado cuando la página se carga
        applyTheme();

        // Alternar entre los temas cuando se haga clic en el botón
        const themeToggle = document.getElementById('theme-toggle');
        themeToggle.addEventListener('click', () => {
            const rootElement = document.documentElement;
            if (rootElement.classList.contains('dark')) {
                rootElement.classList.remove('dark'); // Desactiva el modo oscuro
                localStorage.setItem('theme', 'light'); // Guarda el tema claro
            } else {
                rootElement.classList.add('dark'); // Activa el modo oscuro
                localStorage.setItem('theme', 'dark'); // Guarda el tema oscuro
            }
        });

        // Detecta la preferencia del sistema si no se ha guardado una preferencia
        if (!localStorage.getItem('theme') && window.matchMedia('(prefers-color-scheme: dark)').matches) {
            document.documentElement.classList.add('dark'); // Activa el modo oscuro si el sistema lo prefiere
        }
    </script>

</html>
