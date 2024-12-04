<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service order request') }}
        </h2>
    </x-slot>
    @vite('resources/js/dropFiles.js')
    <div class="py-12">
        <div class="max-w-2xl mx-auto sm:px-6 lg:px-8">
            <form action="{{ route('order.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('POST')
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <x-input-label for="client" class="mt-1" :value="__('Applicant')" />
                        <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                        <x-text-input id="client" class="block mt-1 w-full" type="text" name="client"
                            :value="old('client', Auth::user()->name . ' ' . Auth::user()->last_name)" readonly />
                        <x-input-error :messages="$errors->get('user_id')" class="mt-2" />
                        <x-input-label for="resolution_areas" class="mt-4" :value="__('Resolution Area')" />
                        <select id="resolution_areas" name="resolution_areas" required
                            class="block text-black mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value=""> >-- {{ __('Resolution Area') }} --< </option>
                                    @foreach ($resolution_areas as $resolution_area)
                            <option value="{{ $resolution_area->id }}">{{ $resolution_area->area }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('resolution_areas')" class="mt-2" />
                        <x-input-label for="types" class="mt-4" :value="__('Types of orders')" />
                        <select id="types" name="types" required
                            class="block text-black mt-1 w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value=""> >-- {{ __('Types of orders') }} --< </option>
                                    @foreach ($types as $type)
                            <option value="{{ $type->id }}">{{ $type->type }}</option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('types')" class="mt-2" />

                        <x-input-label for="file_input" class="mt-4" :value="__('Files (up to 3)')" />
                        <label for="file_input"
                            class=" relative flex flex-col items-center justify-center p-4 border-2 border-dashed border-gray-400 rounded-lg bg-gray-50 cursor-pointer hover:bg-gray-100"
                            id="dropArea">
                            <span class="text-gray-500">Arrastra tus archivos aquí o </span>
                            <span class="text-blue-500 font-bold">haz clic para seleccionar</span>
                            <input type="file" name="files[]" id="file_input" multiple
                                class="absolute inset-0 opacity-0 cursor-pointer">
                        </label>
                        <!-- Mostrar errores para cada archivo individual -->

                        <!-- El contenedor de vista previa -->
                        <div id="filePreview"
                            class="mt-4 p-4 bg-gray-400 dark:bg-gray-900 border border-gray-500 rounded-lg h-40 overflow-y-auto space-y-2"
                            style="display: none;">
                            <!-- Los archivos seleccionados aparecerán aquí -->
                        </div>
                        <x-input-error :messages="$errors->get('files')" class="mt-2" />
                        @foreach ($errors->get('files.*') as $fileErrors)
                            <ul class="list-disc list-inside text-red-600 dark:text-white">
                                @foreach ($fileErrors as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endforeach

                        <x-input-label for="description" class="mt-4" :value="__('Description')" />
                        <x-textarea id="description" name="description" rows="4" required
                            class="w-full max-w-sm sm:max-w-md md:max-w-lg lg:max-w-xl xl:max-w-2xl resize-none"
                            >{{ old('description') }}</x-textarea>


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
