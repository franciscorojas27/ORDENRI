@props(['register' => true,'job_titles', 'general_managements'])
@if ($register)
<form method="POST" action="{{ route('register') }}" class="w-full max-w-md">
@else
<form method="POST" action="{{ route('admin-secure.store') }}" class="w-full max-w-md">
@endif
    @csrf
    @method('POST')
    <!-- Name -->
    <div class="flex space-x-4">
        <div class="w-1/2">
            <x-input-label for="name" :value="__('Name')" class="text-white" />
            <x-text-input id="name" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-400" />
        </div>
        <div class="w-1/2">
            <x-input-label for="last_name" :value="__('Last name')" class="text-white" />
            <x-text-input id="last_name" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-red-400" />
        </div>
    </div>

    <!-- Job Title -->
    <div>
        <x-input-label for="job_title" :value="__('Job title')" class="text-white" />
        <select id="job_title" name="job_title" class="block w-full mt-1 bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring rounded-md focus:ring-indigo-200 focus:ring-opacity-50" required>
            <option value="">-- Seleccione Título del trabajo --</option>
            @foreach ($job_titles as $job_title)
                <option value="{{ $job_title->id }}" {{ old('job_title') == $job_title->id ? 'selected' : '' }}>{{ $job_title->title }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('job_title_id')" class="mt-2 text-red-400" />
    </div>

    <!-- Coordination/Management -->
    <div>
        <x-input-label for="coordination_management" :value="__('Coordination/Management')" class="text-white" />
        <x-text-input id="coordination_management" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="text" name="coordination_management" :value="old('coordination_management')" required />
        <x-input-error :messages="$errors->get('coordination_management')" class="mt-2 text-red-400" />
    </div>

    <!-- General Management -->
    <div>
        <x-input-label for="general_management" :value="__('General management')" class="text-white" />
        <select id="general_management" name="general_management" class="block rounded-md w-full mt-1 bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" required>
            <option value="">-- Seleccione Gerencia general --</option>
            @foreach ($general_managements as $general_management)
                <option value="{{ $general_management->id }}" {{ old('general_management') == $general_management->id ? 'selected' : '' }}>{{ $general_management->general_management }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('general_management_id')" class="mt-2 text-red-400" />
    </div>

    <!-- Email Address -->
    <div>
        <x-input-label for="email" :value="__('Email')" class="text-white" />
        <x-text-input id="email" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="email" name="email" :value="old('email')" required autocomplete="username" />
        <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-400" />
    </div>

    <!-- Phone -->
    <div>
        <x-input-label for="phone" :value="__('Phone')" class="text-white" />
        <x-text-input id="phone" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
        <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-400" />
    </div>

    <!-- Password -->
    <div>
        <x-input-label for="password" :value="__('Password')" class="text-white" />
        <x-text-input id="password" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-400" />
    </div>
    
    <!-- Confirm Password -->
    <div>
        <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-white" />
        <x-text-input id="password_confirmation" class="block mt-1 w-full bg-gray-700 text-white border-gray-600 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" type="password" name="password_confirmation" required autocomplete="new-password" />
        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-400" />
    </div>
    

    <div class="flex items-center justify-between mt-6">
        @if($register)
        <a class="text-sm text-gray-400 hover:text-gray-300" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>
        @endif
        <button type="submit" class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd" />
                </svg>
            </span>
            @if ($register)
            {{ __('Register') }}
            @else
            {{__('Create account')}}    
            @endif
        </button>
    </div>
</form>