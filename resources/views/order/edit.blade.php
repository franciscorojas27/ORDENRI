<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Services orders') }}
        </h2>
    </x-slot>
    @if ($errors->has('authorization'))
        <x-messages.alert-message />
    @endif
    <form id={{ $order->id }} action="{{ route('order.update', $order) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Order id -->
                        <div>
                            <x-input-label for="order_id" class="mt-2" :value="__('N°')" />
                            <x-text-input required readonly id="order_id" class="block mt-2 w-full" type="text"
                                name="order_id" :value="old('order_id', $order->id)" />
                        </div>
                        <!-- Client Values-->
                        <div>
                            <x-input-label for="name" class="mt-2" :value="__('Applicant')" />
                            <x-text-input required readonly id="name" class="block mt-2 w-full" type="text"
                                name="name" :value="old('name', $order->client->name . ' ' . $order->client->last_name)" />
                        </div>

                    </div>
                    <div class="grid grid-cols-2 gap-6">
                        <!-- Created At -->
                        <div>
                            <x-input-label for="created_at" class="mt-2" :value="__('Creation date')" />
                            <x-text-input required id="created_at" class="block mt-2 w-full" type="text"
                                name="created_at" :value="old('created_at', $order->created_at)" />
                            <x-input-error :messages="$errors->get('created_at')" class="mt-2" />
                        </div>
                        <!-- Start At -->
                        <div>
                            <x-input-label for="start_at" class="mt-2" :value="__('Start date')" />
                            <x-text-input required id="start_at" class="block mt-2 w-full" type="text"
                                name="start_at" :value="old('start_at', $order->start_at ? $order->start_at : 'No iniciado')" />
                            <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- End At -->
                        <div>
                            <x-input-label for="end_at" class="mt-2" :value="__('End date')" />
                            <x-text-input required id="end_at" class="block mt-2 w-full" type="text"
                                name="end_at" :value="old('end_at', $order->end_at ? $order->end_at : 'No finalizado')" />
                            <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                        </div>
                        <!-- Status order id -->
                        <div x-data="{ open: false }" class="flex items-center w-full">
                            <!-- Select -->
                            <div class="flex flex-col {{ $order->status->id == 3 ? 'w-3/4' : 'w-full' }}">
                                <x-input-label for="status_id" :value="__('Status')" class="mt-2" />
                                <select required id="status_id" name="status_id"
                                    class="block w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                    <option value="" disabled selected class="text-gray-500 dark:text-gray-400"
                                        {{ is_null($order->status->id) ? 'selected' : '' }}>
                                        {{ __('Select an option') }}
                                    </option>
                                    @foreach ($statuses as $status)
                                        <option value="{{ $status->id }}" class="text-black"
                                            {{ $order->status->id == $status->id ? 'selected' : '' }}>
                                            {{ $status->status }}
                                        </option>
                                    @endforeach
                                </select>
                                <x-input-error :messages="$errors->get('status')" class="mt-2" />
                            </div>

                            @if ($order->status->id == 3)
                                <!-- Dropdown Button -->
                                <div class=" ml-4 mt-6 relative">
                                    <!-- Botón -->
                                    <button @click="open = !open" type="button"
                                        class="bg-indigo-600 text-white px-4 py-2 rounded-md shadow-sm hover:bg-indigo-700 focus:outline-none">
                                        Conformidad
                                    </button>

                                    <!-- Menú desplegable -->
                                    <div x-show="open" class="absolute bg-white shadow-lg rounded-md mt-2 w-48 z-50"
                                        style="top: 100%; left: -70px;">
                                        <!-- Botón de envío asociado al formulario -->
                                        <button form="conformity" type="submit" class="w-full h-full text-black">
                                            {{ __('Execute') }}
                                        </button>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <!-- Type order id -->
                        <div>
                            <x-input-label for="type_id" class="mt-2" :value="__('Order type')" />
                            <select required readonly id="type_id" name="type_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                <option value="" disabled selected class="text-gray-500 dark:text-gray-400"
                                    {{ is_null($order->type->id) ? 'selected' : '' }}>
                                    {{ __('Select an option') }}</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type->id }}" class="text-black"
                                        {{ $order->type->id == $type->id ? 'selected' : '' }}>
                                        {{ $type->type }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                        <!-- Responsible id -->
                        <div>
                            <x-input-label for="responsible_id" class="mt-2" :value="__('Supervisor')" />
                            <select name="responsible_id" id="responsible_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                <option value="" disabled {{ is_null($order->responsible_id) ? 'selected' : '' }}
                                    class="text-gray-500">
                                    {{ __('Select an option') }}
                                </option>
                                @foreach ($supervisors as $supervisor)
                                    <option value="{{ $supervisor->id }}"
                                        {{ $order->responsible_id == $supervisor->id ? 'selected' : '' }}
                                        class="text-black">
                                        {{ $supervisor->name . ' ' . $supervisor->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('responsible')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <!-- Resolution area -->
                            <x-input-label for="resolution_area_id" class="mt-2" :value="__('Resolution Areas')" />
                            <select required readonly id="resolution_area_id" name="resolution_area_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                <option value="" disabled selected class="text-gray-500 dark:text-gray-400"
                                    {{ is_null($order->resolutionArea->id) ? 'selected' : '' }}>
                                    {{ __('Select an option') }}</option>
                                @foreach ($resolutionAreas as $resolutionArea)
                                    <option value="{{ $resolutionArea->id }}" class="text-black"
                                        {{ $order->resolutionArea->id == $resolutionArea->id ? 'selected' : '' }}>
                                        {{ $resolutionArea->area }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('resolutionAreas')" class="mt-2" />
                        </div>
                        <!-- ApplicantTo id (supervisor)-->
                        <div>
                            <x-input-label for="applicant_to_id" class="mt-2" :value="__('Applicant to')" />
                            <select name="applicant_to_id" id="applicant_to_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-500 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                <option value="" disabled
                                    {{ is_null($order->applicant_to_id) ? 'selected' : '' }} class="text-gray-500">
                                    {{ __('Select an option') }}
                                </option>
                                @foreach ($applicantToList as $applicantTo)
                                    <option value="{{ $applicantTo->id }}"
                                        {{ $order->applicant_to_id == $applicantTo->id ? 'selected' : '' }}
                                        class="text-black">
                                        {{ $applicantTo->name . ' ' . $applicantTo->last_name }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('applicant_to_id')" class="mt-2" />
                        </div>

                    </div>
                    <!-- Files -->
                    <div class="mt-4">
                        <x-input-label for="files" :value="__('Files')" />
                        <ul class="mt-2 dark:text-white  w-full list-disc list-inside flex flex-col items-start">
                            @forelse ($order->files as $file)
                                <li class="w-full">
                                    <a href="{{ route('order.file.download', [$order, $file]) }}" target="_blank"
                                        class="text-blue-500 dark:text-blue-400 hover:underline w-1/2">
                                        {{ $file->original_name }}
                                    </a>
                                    <button type="submit" form="delete-file-{{ $file->id }}"
                                        class="text-red-500 ml-2">
                                        {{ __('Eliminar') }}
                                    </button>
                                </li>
                            @empty
                                <li class="w-full">{{ __('No files uploaded') }}</li>
                            @endforelse
                        </ul>
                        <x-input-error :messages="$errors->get('files')" class="mt-2" />
                    </div>
                    <!-- Client Description -->
                    <div>
                        <x-input-label for="client_description" class="mt-2" :value="__('Client description')" class="mt-4" />
                        <x-textarea required readonly id="client_description" name="client_description"
                            rows="4" cols="65" style="resize: none;" class="mt-2 block w-full">
                            {{ old('client_description', $order->client_description) }}
                        </x-textarea>
                        <x-input-error :messages="$errors->get('client_description')" class="mt-2" />
                    </div>
                    <!-- Description -->
                    <div>
                        <x-input-label for="description" class="mt-2" :value="__('Activity')" class="mt-4" />
                        <x-textarea required id="description" name="description" rows="4" cols="65"
                            style="resize: none;" class="mt-2 block w-full">
                            {{ old('description', $order->description) }}
                        </x-textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <!-- Button submit -->
                    <div class="flex items-center justify-between mt-4">
                        <x-link-button href="{{ route('order.index') }}" class="mr-2 justify-end">
                            {{ __('Volver') }}
                        </x-link-button>
                        <x-primary-button form="{{ $order->id }}" type="submit" class="w-full justify-center">
                            {{ __('Update order') }}
                        </x-primary-button>
                    </div>

                </div>
            </div>
        </div>
    </form>
    <!-- Formulario de eliminación -->
    <form id="conformity" action="{{ route('order.non-conformity', $order) }}" method="POST"
        style="display: none;"
        onsubmit="return confirm('{{ __('Are your sure to mark this order as non-conformity?') }}')">
        @csrf
        @method('POST')
    </form>
    @if ($order->files->isNotEmpty())
        @foreach ($order->files as $file)
            <form id="delete-file-{{ $file->id }}" action="{{ route('order.files.delete', [$order, $file]) }}"
                method="POST" style="display: none;"
                onsubmit="return confirm('{{ __('Are you sure you want to delete this file?') }}')">
                @csrf
                @method('DELETE')
            </form>
        @endforeach
    @endif

</x-app-layout>
