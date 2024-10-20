<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Create account') }}
        </h2>
    </x-slot>
    <div class="flex items-center justify-center min-h-screen py-12">
        <div class="max-w-2xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700">
                    <div class="flex justify-center">
                        <x-register-layout :register="false" :job_titles="$job_titles" :general_managements="$general_managements"></x-register-layout>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
