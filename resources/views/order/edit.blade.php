<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Services orders') }}
        </h2>
    </x-slot>
    @if ($errors->has('authorization'))
        <x-messages.alert-message />
    @endif
    <form action="{{ route('order.update', $order['id']) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="client_id" class="mt-2" :value="__('Applicant')" />
                            <x-text-input required readonly id="client_id" class="block mt-2 w-full" type="text"
                                name="client_id" :value="old('client', $order['client']['name'])" />
                            <x-input-error :messages="$errors->get('applicant')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="id" class="mt-2" :value="__('N°')" />
                            <x-text-input required readonly id="id" class="block mt-2 w-full" type="text"
                                name="id" :value="old('id', $order['id'])" />
                            <x-input-error :messages="$errors->get('id')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="created_at" class="mt-2" :value="__('Creation date')" />
                            <x-text-input required readonly id="created_at" class="block mt-2 w-full" type="text"
                                name="created_at" :value="old('created_at', $order['created_at'])" />
                            <x-input-error :messages="$errors->get('created_at')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="start_at" class="mt-2" :value="__('Start date')" />
                            <x-text-input required readonly id="start_at" class="block mt-2 w-full" type="text"
                                name="start_at" :value="old('start_at', $order['start_at'] ? $order['start_at'] : 'No iniciado')" />
                            <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="end_at" class="mt-2" :value="__('End date')" />
                            <x-text-input required readonly id="end_at" class="block mt-2 w-full" type="text"
                                name="end_at" :value="old('end_at', $order['end_at'] ? $order['end_at'] : 'No finalizado')" />
                            <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="status_id" class="mt-2" :value="__('Status')" />
                            <select required readonly id="status_id" name="status_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                <option value="" disabled selected class="text-gray-500 dark:text-gray-400"
                                    {{ is_null($order['status']['id']) ? 'selected' : '' }}>
                                    {{ __('Select an option') }}</option>
                                @foreach ($RST['status'] as $key => $status)
                                    <option value="{{ $key }}" class="text-black"
                                        {{ $order['status']['id'] == $key ? 'selected' : '' }}>
                                        {{ $status }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('status')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="type_id" class="mt-2" :value="__('Order type')" />
                            <select required readonly id="type_id" name="type_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                <option value="" disabled selected class="text-gray-500 dark:text-gray-400"
                                    {{ is_null($order['type']['id']) ? 'selected' : '' }}>
                                    {{ __('Select an option') }}</option>
                                @foreach ($RST['type'] as $key => $type)
                                    <option value="{{ $key }}" class="text-black"
                                        {{ $order['type']['id'] == $key ? 'selected' : '' }}>
                                        {{ $type }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('type')" class="mt-2" />
                        </div>
                        <div>
                            <x-input-label for="responsible_id" class="mt-2" :value="__('Supervisor')" />
                            <x-edit-select required :id_name="'responsible_id'" :users="$users"
                                :select="$order['responsible']" :excluedtitle="'Cliente'"></x-edit-select>
                            <x-input-error :messages="$errors->get('responsible')" class="mt-2" />
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="resolution_area_id" class="mt-2" :value="__('Resolution Areas')" />
                            <select required readonly id="resolution_area_id" name="resolution_area_id"
                                class="block mt-2 w-full text-black rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 appearance-none">
                                <option value="" disabled selected class="text-gray-500 dark:text-gray-400"
                                    {{ is_null($order['resolutionArea']['id']) ? 'selected' : '' }}>
                                    {{ __('Select an option') }}</option>
                                @foreach ($RST['resolutionAreas'] as $key => $resolutionArea)
                                    <option value="{{ $key }}" class="text-black"
                                        {{ $order['resolutionArea']['id'] == $key ? 'selected' : '' }}>
                                        {{ $resolutionArea }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error :messages="$errors->get('resolutionAreas')" class="mt-2" />
                        </div>

                        <div>
                            <x-input-label for="applicant_to_id" class="mt-2" :value="__('Applicant to')" />
                            <x-edit-select required :id_name="'applicant_to_id'" :users="$users"
                                :select="$order['applicantTo']"  :excluedtitle="'Cliente'"> </x-edit-select>
                            <x-input-error :messages="$errors->get('applicantTo')" class="mt-2" />
                        </div>
                    </div>

                    <div>
                        <x-input-label for="client_description" class="mt-2" :value="__('Client description')" class="mt-4" />
                        <x-textarea required readonly id="client_description" name="client_description" rows="4"
                            cols="65" style="resize: none;" class="mt-2 block w-full">
                            {{ old('client_description', $order['client_description']) }}
                        </x-textarea>
                        <x-input-error :messages="$errors->get('client_description')" class="mt-2" />
                    </div>

                    <div>
                        <x-input-label for="description" class="mt-2" :value="__('Activity')" class="mt-4" />
                        <x-textarea required id="description" name="description" rows="4" cols="65"
                            style="resize: none;" class="mt-2 block w-full">
                            {{ old('description', $order['description']) }}
                        </x-textarea>
                        <x-input-error :messages="$errors->get('description')" class="mt-2" />
                    </div>
                    <div class="flex items-center justify-between mt-4">
                        <x-link-button href="{{ route('order.index') }}" class="mr-2 justify-end">
                            {{ __('Volver') }}
                        </x-link-button>
                        <x-primary-button type="submit" class="w-full justify-center">
                            {{ __('Update order') }}
                        </x-primary-button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</x-app-layout>
