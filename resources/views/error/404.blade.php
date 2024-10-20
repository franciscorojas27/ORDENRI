<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('404') }}
        </h2>
    </x-slot>

    <div class="min-h-screen flex items-center justify-center bg-gray-900 dark:bg-gray-100">
        <div class="text-center text-white dark:text-gray-900">
            <h1 class="text-[20rem] font-bold">
                404
            </h1>
            <h2 class="mt-6 text-6xl font-semibold">
                {{ __('Page Not Found') }}
            </h2>
            <p class="mt-2 text-4xl">
                {{ __("Sorry, we couldn't find the page you're looking for.") }}
            </p>
        </div>
    </div>
</x-app-layout>
