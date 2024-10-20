<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <title>Dropdown con Animación</title>
</head>

<body class="flex items-center justify-center h-screen bg-gray-700 dark:bg-slate-600 dark:on">
  <header class="fixed top-0 left-0 w-full bg-white dark:bg-gray-800 shadow-md z-10">
    <div class="container mx-auto px-4 py-2">
        <div class="flex items-center justify-between">
            <a href="#" class="text-2xl font-bold text-gray-800 dark:text-white">
                Dropdown con Animación
            </a>
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                <button @click="open = !open" class="px-4 py-2 text-white bg-blue-500 rounded">
                    Menu
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-2" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-2"
                    x-cloak style="display: none;" class="absolute right-0 bg-gray-300 shadow-lg rounded-md w-48 mt-2">
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 1</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 2</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 3</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 4</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 5</a>
                </div>
          </div>
    </div>
</header>  
  {{-- <header class="fixed top-0 left-0 w-full bg-white dark:bg-gray-800 shadow-md z-10">
    <div class="container mx-auto px-4 py-2">
        <div class="flex items-center justify-between">
            <a href="#" class="text-2xl font-bold text-gray-800 dark:text-white">
                Dropdown con Animación
            </a>
            <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                <button @click="open = !open" class="px-4 py-2 text-white bg-blue-500 rounded">
                    Menu
                </button>
                <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-x-0" x-transition:leave-end="opacity-0 translate-x-full"
                    x-cloak style="display: none;" class="absolute right-0 bg-gray-300 shadow-lg rounded-md w-48 mt-2">
                    <a href="#"   class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 1</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 2</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 3</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 4</a>
                    <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 5</a>
                </div>
            </div>
        </div>
    </div>
</header> --}}
  {{-- <header class="fixed top-0 left-0 w-full bg-white dark:bg-gray-800 shadow-md z-10">
        <div class="container mx-auto px-4 py-2">
            <div class="flex items-center justify-between">
                <a href="#" class="text-2xl font-bold text-gray-800 dark:text-white">
                    Dropdown con Animación
                </a>
                <div class="relative" x-data="{ open: false }" @click.outside="open = false" @close.stop="open = false">
                    <button @click="open = !open" class="px-4 py-2 text-white bg-blue-500 rounded">
                        Menu
                    </button>
                    <div x-show="open" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-full" x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100 translate-y-0" x-transition:leave-end="opacity-0 translate-y-full"
                        x-cloak style="display: none;" class="mt-2 absolute bg-gray-300 shadow-lg rounded-md w-48 right-0">
                        <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 1</a>
                        <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 2</a>
                        <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 3</a>
                        <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 4</a>
                        <a href="#" class="block px-4 py-2 rounded-md shadow-md hover:shadow-lg hover:bg-blue-500 mt-1">Link 5</a>
                    </div>
                </div>
            </div>
        </div>
    </header> --}}
</body>

</html>
