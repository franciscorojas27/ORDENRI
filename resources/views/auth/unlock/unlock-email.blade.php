<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600 dark:text-gray-400">
        {{ __('Your account is blocked. Please enter your email address and we will send you an unlock link.') }}
    </div>

    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('unlockUser.send') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required
                autofocus />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
            <div class="flex items-center justify-end mt-4">
            </div>
            <div class="flex items-center justify-end mt-4">
                <x-primary-button class="mr-2">
                    {{ __('Send Unlock User Link') }}
                </x-primary-button>
                <a href="{{ route('login') }}"
                    class="text-green-500 hover:text-blue-500 hover:underline-offset-1 dark:hover:underline-offset-1 dark:text-gray-400 dark:hover:text-white">{{ __('Return') }}
                </a>
            </div>
        </div>
    </form>
</x-guest-layout>
