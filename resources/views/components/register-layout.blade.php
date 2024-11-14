@props(['register' => true,'job_titles', 'resolution_areas', 'general_managements'])
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
        <x-input-label for="name" :value="__('Name')" class="text-black mt-2" />
        <x-text-input id="name"
            class="block mt-1 w-full bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
        <x-input-error :messages="$errors->get('name')" class="mt-2 text-red-600" />
    </div>
    <div class="w-1/2">
        <x-input-label for="last_name" :value="__('Last name')" class="text-black mt-2" />
        <x-text-input id="last_name"
            class="block mt-1 w-full bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
            type="text" name="last_name" :value="old('last_name')" required autocomplete="family-name" />
        <x-input-error :messages="$errors->get('last_name')" class="mt-2 text-red-600" />
    </div>
</div>

@if (request()->routeIs('admin-secure.create'))
    <!-- Job title -->
    <div>
        <x-input-label for="job_title" :value="__('Job title')" class="text-black mt-2" />
        <select id="job_title" name="job_title"
            class="block w-full mt-1 bg-white border-gray-300 focus:border-indigo-500 focus:ring rounded-md focus:ring-indigo-200 focus:ring-opacity-50"
            required>
            <option value="">-- Seleccione Titulo de trabajo --</option>
            @foreach ($job_titles as $Job_Title)
                <option value="{{ $Job_Title->id }}" {{ old('job_title') == $Job_Title->id ? 'selected' : '' }}>
                    {{ $Job_Title->title }}</option>
            @endforeach
        </select>
        <x-input-error :messages="$errors->get('job_titles')" class="mt-2 text-red-600" />
    </div>
@endif

<!-- Resolution area -->
<div>
    <x-input-label for="resolution_area" :value="__('Resolution area')" class="text-black mt-2" />
    <select id="resolution_area" name="resolution_area"
        class="block w-full mt-1 bg-white border-gray-300 focus:border-indigo-500 focus:ring rounded-md focus:ring-indigo-200 focus:ring-opacity-50"
        required>
        <option value="">-- Seleccione area resulotoria --</option>
        @foreach ($resolution_areas as $resolution_area)
            <option value="{{ $resolution_area->id }}"
                {{ old('resolution_area') == $resolution_area->id ? 'selected' : '' }}>{{ $resolution_area->area }}
            </option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('resolution_areas')" class="mt-2 text-red-600" />
</div>

<!-- Coordination/Management -->
<div>
    <x-input-label for="coordination_management" :value="__('Coordination/Management')" class="text-black mt-2" />
    <x-text-input id="coordination_management"
        class="block mt-1 w-full bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        type="text" name="coordination_management" :value="old('coordination_management')" required />
    <x-input-error :messages="$errors->get('coordination_management')" class="mt-2 text-red-600" />
</div>

<!-- General Management -->
<div>
    <x-input-label for="general_management" :value="__('General management')" class="text-black mt-2" />
    <select id="general_management" name="general_management"
        class="block rounded-md w-full mt-1 bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        required>
        <option value="">-- Seleccione Gerencia general --</option>
        @foreach ($general_managements as $general_management)
            <option value="{{ $general_management->id }}"
                {{ old('general_management') == $general_management->id ? 'selected' : '' }}>
                {{ $general_management->general_management }}</option>
        @endforeach
    </select>
    <x-input-error :messages="$errors->get('general_management_id')" class="mt-2 text-red-600" />
</div>

<!-- Email Address -->
<div>
    <x-input-label for="email" :value="__('Email')" class="text-black mt-2" />
    <x-text-input id="email"
        class="block mt-1 w-full bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        type="email" name="email" :value="old('email')" required autocomplete="username" />
    <x-input-error :messages="$errors->get('email')" class="mt-2 text-red-600" />
</div>

<!-- Phone -->
<div>
    <x-input-label for="phone" :value="__('Phone')" class="text-black mt-2" />
    <x-text-input id="phone"
        class="block mt-1 w-full bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        type="tel" name="phone" :value="old('phone')" required autocomplete="tel" />
    <x-input-error :messages="$errors->get('phone')" class="mt-2 text-red-600" />
</div>

<!-- Password -->
<div>
    <x-input-label for="password" :value="__('Password')" class="text-black mt-2" />
    <x-text-input id="password"
        class="block mt-1 w-full bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        type="password" name="password" required autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password')" class="mt-2 text-red-600" />
</div>

<!-- Confirm Password -->
<div>
    <x-input-label for="password_confirmation" :value="__('Confirm Password')" class="text-black mt-2" />
    <x-text-input id="password_confirmation"
        class="block mt-1 w-full bg-white border-gray-300 focus:border-indigo-500 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
        type="password" name="password_confirmation" required autocomplete="new-password" />
    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2 text-red-600" />
</div>


<div class="flex items-center justify-between mt-6">
    @if ($register)
        <a class="text-sm text-gray-600 hover:text-gray-900" href="{{ route('login') }}">
            {{ __('Already registered?') }}
        </a>
    @endif
    <button type="submit"
        class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
            <svg class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd"
                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                    clip-rule="evenodd" />
            </svg>
        </span>
        @if ($register)
            {{ __('Register') }}
        @else
            {{ __('Create account') }}
        @endif
    </button>
</div>
</form>

