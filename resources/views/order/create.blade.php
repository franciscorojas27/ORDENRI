<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service order request') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('order.store') }}" method="POST">
                @csrf
                @method('POST')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <x-input-label for="client" class="mt-1" :value="__('Applicant')" />
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <x-text-input id="client" class="block mt-1 w-full" type="text" name="client"
                            :value="old('client', Auth::user()->name)" readonly  />
                        <x-input-error :messages="$errors->get('client')" class="mt-2" />
                        <x-input-label for="resolution_areas" class="mt-4" :value="__('Resolution Area')" />
                        <select id="resolution_areas" name="resolution_areas"
                            class="block text-black mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                            <option value=""> >-- {{ __('Resolution Area') }} --< </option>
                                    @foreach ($resolution_areas as $resolution_area)
                            <option value="{{ $resolution_area->id }}">{{ $resolution_area->area }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('resolution_areas')" class="mt-2" />

                        <x-input-label for="types" class="mt-4" :value="__('Types of orders')" />
                        <select id="types" name="types"
                            class="block text-black mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50"
                            >
                            <option value=""> >-- {{ __('Types of orders') }} --< </option>
                                    @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('types')" class="mt-2" />
                        <x-input-label for="description" class="mt-4" :value="__('Description')" />
                        <x-textarea id="description" name="description" rows="4" cols="65"
                            style="resize: none;"></x-textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                        <x-order-button class="mt-4 justify-center w-full">
                            {{ __('Submit Order') }}
                        </x-order-button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
