<x-app-layout>
    @vite(['resources/js/coloredRows.js'])
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-4 flex items-center justify-between">
                    <form action="{{ route('admin-secure.index') }}" method="GET" class="flex items-center">
                        <x-text-input id="search" class="block focus:ring-indigo-500 mt-1 w-64" type="text"
                            name="search" value="{{ request()->query('search') }}" />
                        <x-secondary-button class="ml-4" type="submit">{{ __('Buscar') }}</x-secondary-button>
                    </form>
                    <div class="flex justify-end space-x-1">
                        <a class="inline-flex items-center px-4 py-2 mx-1 bg-green-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-green-500 focus:outline-none focus:border-green-700 focus:ring focus:ring-green-200 disabled:opacity-25 transition ease-in-out duration-150 text-center break-words"
                            href="{{ Route('admin-secure.create') }}">
                            {{ __('Create User') }}
                        </a>
                        <a class="block px-2 py-1 text-white transition-all duration-500 ease-in-out transform hover:scale-105"
                            href="{{ route('admin-secure.index') }}"><svg xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                                class="w-8 h-8">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                            </svg></a>
                    </div>
                </div>

                <!-- Tabla de usuarios -->
                <div class="min-w-full divide-y overflow-x-auto  divide-gray-800 dark:divide-gray-700">
                    <table class="min-w-full bg">
                        <thead class="bg-white dark:bg-gray-700">
                            <tr>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                    Id
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                    {{__('Name')}}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                    {{__('Email')}}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                    {{__('Connected')}}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                    {{__('General management')}}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                    {{__('Rol')}}
                                </th>
                                <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white uppercase tracking-wider">
                                    {{ __('Select') }}
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-300 dark:divide-gray-700">
                            @foreach ($users as $user)
                                <tr class="mt-2 " id="{{ $user->id }}">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->id }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name . ' ' . $user->last_name }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->email }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-block mx-auto w-3 h-3 {{ $user->is_connected ? 'bg-green-500' : 'bg-red-500' }} rounded-full"></span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap overflow-hidden text-ellipsis">
                                        <span class="inline-block w-3 h-3 text-gray-900 dark:text-white rounded-full">{{ $user->GeneralManagement->general_management }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->jobTitle->title }}</span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            <input type="checkbox" class="rounded-full h-4 w-4 border border-gray-300 dark:border-gray-500">
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    {{ $users->onEachSide(5)->links('pagination::tailwind') }}

</x-app-layout>
