<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('User Administrator') }}
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-100 dark:bg-gray-900">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div  class="bg-gray-50  dark:bg-gray-800 shadow-lg sm:rounded-lg p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-6">
                    <form action="{{route('admin-secure.update', $user)}}" method="POST" id="user-form" class="contents">
                        @csrf
                        @method('PUT')
                        <!-- Name -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input required id="name" class="block mt-2 w-full" type="text" name="name"
                                :value="old('name', $user->name)" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <!-- Last Name -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="last_name" :value="__('Last name')" />
                            <x-text-input id="last_name" class="block mt-2 w-full" type="text" name="last_name"
                                :value="old('last_name', $user->last_name)" />
                            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
                        </div>
                        <!-- user id -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="user_id" :value="__('User ID')" />
                            <x-text-input readonly id="user_id" class="block mt-2 w-full" type="text"
                                name="user_id" :value="old('user_id', $user->id)" />
                            <x-input-error :messages="$errors->get('id')" class="mt-2" />
                        </div>
                        <!-- Email -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input required id="email" class="block mt-2 w-full" type="email"
                                name="email" :value="old('email', $user->email)" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>

                        <!-- Last Connection -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="last_connection" :value="__('Last connection')" />
                            <x-text-input readonly id="last_connection" class="block w-full" type="text"
                                name="last_connection" :value="old('last_connection', $user->last_connection)" />
                            <x-input-error :messages="$errors->get('last_connection')" class="mt-2" />
                        </div>

                        <!-- Phone -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" class="block mt-2 w-full" type="tel" name="phone"
                                :value="old('phone', $user->phone)" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>

                        <!-- Creation Date -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="created_at" :value="__('Creation date')" />
                            <x-text-input readonly id="created_at" class="block mt-2 w-full" type="text"
                                name="created_at" :value="old('created_at', $user->created_at)" />
                            <x-input-error :messages="$errors->get('created_at')" class="mt-2" />
                        </div>
                        <!-- Expiration Date -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="password_may_expire_at" :value="__('Expiration date')" />
                            <x-text-input readonly id="password_may_expire_at" class="block mt-2 w-full" type="text"
                                name="password_may_expire_at" :value="old('password_may_expire_at', $user->password_may_expire_at)" />
                            <x-input-error :messages="$errors->get('password_may_expire_at')" class="mt-2" />
                        </div>
                        <!-- ip address -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="ip_address" :value="__('Ip address')" />
                            <x-text-input readonly id="ip_address" class="block mt-2 w-full" type="text"
                                name="ip_address" :value="old('ip_address', $user->ip_address)" />
                            <x-input-error :messages="$errors->get('ip_address')" class="mt-2" />
                        </div>

                        <!-- User Type -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="job_title_id" :value="__('User type')" />
                            <select name="job_title_id" id="job_title_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled {{ is_null($user->jobTitle->id) ? 'selected' : '' }}>
                                    {{ __('Select an option') }}</option>
                                @foreach ($jobTitles as $jobTitle)
                                    <option value="{{ $jobTitle->id }}"
                                        {{ $user->jobTitle->id == $jobTitle->id ? 'selected' : '' }}>
                                        {{ $jobTitle->title }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('job_title_id')" class="mt-2" />
                        </div>

                        <!-- Coordination/Management -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="coordination_management" :value="__('Coordination/Management')" />
                            <x-text-input readonly id="coordination_management" class="block mt-2 w-full" type="text"
                                name="coordination_management" :value="old('coordination_management', $user->coordination_management)" />
                            <x-input-error :messages="$errors->get('coordination_management')" class="mt-2" />
                        </div>

                        <!-- General Management -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="general_management_id" :value="__('General management')" />
                            <select name="general_management_id" id="general_management_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                                <option value="" disabled
                                    {{ is_null($user->generalManagement->id) ? 'selected' : '' }}>
                                    {{ __('Select an option') }}</option>
                                @foreach ($generalManagements as $generalManagement)
                                    <option value="{{ $generalManagement->id }}"
                                        {{ $user->generalManagement->id == $generalManagement->id ? 'selected' : '' }}>
                                        {{ $generalManagement->general_management }}</option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('general_management_id')" class="mt-2" />
                        </div>

                        <!-- Key Type -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="password_may_expire" :value="__('Key type')" />
                            <select id="password_may_expire"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                name="password_may_expire">
                                <option value="0"
                                    {{ old('password_may_expire', $user->password_may_expire) == '0' ? 'selected' : '' }}>
                                    No caduca</option>
                                <option value="1"
                                    {{ old('password_may_expire', $user->password_may_expire) == '1' ? 'selected' : '' }}>
                                    Caduca</option>
                            </select>
                        </div>

                        <!-- Belongs to Group -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="group" :value="__('Belongs to group')" />
                            <select id="group"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                name="group">
                                <option value="0" {{ old('group', $user->group) == '0' ? 'selected' : '' }}>No
                                </option>
                                <option value="1" {{ old('group', $user->group) == '1' ? 'selected' : '' }}>Sí
                                </option>
                            </select>
                        </div>

                        <!-- Blocked -->
                        <div
                            class="bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 p-4 shadow-md rounded-lg">
                            <x-input-label for="is_blocked" :value="__('Blocker user')" />
                            <select id="is_blocked"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                                name="is_blocked">
                                <option value="0"
                                    {{ old('is_blocked', $user->is_blocked) == '0' ? 'selected' : '' }}>No</option>
                                <option value="1"
                                    {{ old('is_blocked', $user->is_blocked) == '1' ? 'selected' : '' }}>Sí</option>
                            </select>
                        </div>
                    </form>

                    <div class="flex flex-wrap justify-end gap-4 mt-4 col-span-full">
                    
                        <button type="submit" form="user-form"
                            class="inline-flex justify-center items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:outline-none focus:border-gray-700 dark:focus:border-gray-300 focus:ring focus:ring-gray-200 dark:focus:ring-gray-800 transition ease-in-out duration-150 flex-none">
                            {{ __('Save') }}
                        </button>

                        <form action="{{ route('admin-secure.reset', $user) }}" method="POST" class="flex-none">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                class="inline-flex justify-center items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-500 focus:outline-none focus:border-blue-700 focus:ring focus:ring-blue-200 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Reset Password') }}
                            </button>
                        </form>

                        <form action="{{ route('admin-secure.delete', $user) }}" method="POST" class="flex-none">
                            @csrf
                            @method('PUT')
                            <button type="submit"
                                onclick="event.preventDefault(); if(confirm('¿Estás seguro de que deseas eliminar este usuario?')) { this.closest('form').submit(); }"
                                class="inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Delete User') }}
                            </button>
                        </form>
                        <a href="{{route('admin-secure')}}" class="flex-none inline-flex justify-center items-center px-4 py-2 bg-red-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-red-500 focus:outline-none focus:border-red-700 focus:ring focus:ring-red-200 disabled:opacity-25 transition ease-in-out duration-150">
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </div>
        </div>
</x-app-layout>
