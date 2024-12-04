<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Service Order') }}
        </h2>
    </x-slot>
    @vite(['resources/js/modalShow.js'])
    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6  lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4">
                    <!-- Order id -->
                    <div>
                        <x-input-label for="id" class="mt-2" :value="__('N°')" />
                        <x-text-input required readonly id="id" class="block mt-2 w-full" type="text"
                            name="id" :value="old('id', $order->id)" />
                        <x-input-error :messages="$errors->get('id')" class="mt-2" />
                    </div>
                    <!-- client_id -->
                    <div>
                        <x-input-label for="client_id" class="mt-2" :value="__('Applicant')" />
                        <x-text-input required readonly id="client_id" class="block mt-2 w-full" type="text"
                            name="client_id" :value="old('client', $order->client->name . ' ' . $order->client->last_name)" />
                        <x-input-error :messages="$errors->get('applicant')" class="mt-2" />
                    </div>
                </div>
                <div class="grid grid-cols-2 gap-6">
                    <!-- Created At -->
                    <div>
                        <x-input-label for="created_at" class="mt-2" :value="__('Creation date')" />
                        <x-text-input required readonly id="created_at" class="block mt-2 w-full" type="text"
                            name="created_at" :value="old('created_at', $order->created_at)" />
                        <x-input-error :messages="$errors->get('created_at')" class="mt-2" />
                    </div>
                    <!-- Start At -->
                    <div>
                        <x-input-label for="start_at" class="mt-2" :value="__('Start date')" />
                        <x-text-input required readonly id="start_at" class="block mt-2 w-full" type="text"
                            name="start_at" :value="old('start_at', $order->start_at ? $order->start_at : 'No iniciado')" />
                        <x-input-error :messages="$errors->get('start_at')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- End At -->
                    <div>
                        <x-input-label for="end_at" class="mt-2" :value="__('End date')" />
                        <x-text-input required readonly id="end_at" class="block mt-2 w-full" type="text"
                            name="end_at" :value="old('end_at', $order->end_at ? $order->end_at : 'No finalizado')" />
                        <x-input-error :messages="$errors->get('end_at')" class="mt-2" />
                    </div>
                    <!-- Status id -->
                    <div>
                        <x-input-label for="status_id" class="mt-2" :value="__('Status')" />
                        <x-text-input required readonly id="status_id" class="block mt-2 w-full" type="text"
                            name="status_id" :value="old('status_id', $order->status->status ?? '')" />
                        <x-input-error :messages="$errors->get('status')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- type id -->
                    <div>
                        <x-input-label for="type_id" class="mt-2" :value="__('Order type')" />
                        <x-text-input required readonly id="type_id" class="block mt-2 w-full" type="text"
                            name="type_id" :value="old('type_id', $order->type->type ?? '')" />
                        <x-input-error :messages="$errors->get('type')" class="mt-2" />
                    </div>
                    <!-- Responsible id -->
                    <div>
                        <x-input-label for="responsible_id" class="mt-2" :value="__('Supervisor')" />
                        <x-text-input required readonly id="responsible_id" class="block mt-2 w-full" type="text"
                            name="responsible_id" :value="old(
                                'responsible',
                                $order->responsible
                                    ? $order->responsible->name . ' ' . $order->responsible->last_name
                                    : '',
                            )" />
                        <x-input-error :messages="$errors->get('responsible')" class="mt-2" />
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-6">
                    <!-- Resolution area id -->
                    <div>
                        <x-input-label for="resolution_area_id" class="mt-2" :value="__('Resolution Area')" />
                        <x-text-input required readonly id="resolution_area_id" class="block mt-2 w-full" type="text"
                            name="resolution_area_id" :value="old('resolution_area_id', $order->resolutionArea->area)" />
                        <x-input-error :messages="$errors->get('resolutionAreas')" class="mt-2" />
                    </div>
                    <!-- ApplicantTO id -->
                    <div>
                        <x-input-label for="applicant_to_id" class="mt-2" :value="__('Applicant to')" />
                        <x-text-input required readonly id="applicant_to_id" class="block mt-2 w-full" type="text"
                            name="applicant_to_id" :value="old(
                                'applicant_to_id',
                                $order->applicantTo
                                    ? $order->applicantTo->name . ' ' . $order->applicantTo->last_name
                                    : '',
                            )" />
                        <x-input-error :messages="$errors->get('applicantTo')" class="mt-2" />
                    </div>
                </div>
                <!-- Client Description -->
                <div>
                    <x-input-label for="client_description" class="mt-2" :value="__('Client description')" class="mt-4" />
                    <x-textarea required readonly id="client_description" name="client_description" rows="4"
                        cols="65" style="resize: none;" class="mt-2 block w-full">
                        {{ old('client_description', $order->client_description) }}
                    </x-textarea>
                    <x-input-error :messages="$errors->get('client_description')" class="mt-2" />
                </div>
                <!--  -->
                <form action="{{ route('order.flow', $order) }}" id="form-description" method="POST">
                    @csrf
                    @method('PUT')
                    <x-input-label for="description" class="mt-2" :value="__('Activity')" />

                    @if (Auth::user()->isClient())
                        <x-textarea required readonly id="description" name="description" rows="4" cols="65"
                            style="resize: none;" class="mt-2 block w-full">
                            {{ old('description', $order->description) }}
                        </x-textarea>
                    @else
                        <x-textarea required id="description" name="description" rows="4" cols="65"
                            style="resize: none;" class="mt-2 block w-full">
                            {{ old('description', $order->description) }}
                        </x-textarea>
                    @endif


                    <x-input-error :messages="$errors->get('description')" class="mt-2" />

                </form>
                <div class="flex items-center justify-between mt-4">
                    <x-link-button href="{{ $redirectRoute }}"
                        class="mr-2 justify-center
                        {{ ($order->status_id <= 2  && ($order->applicant_to_id == Auth::id() || Gate::allows('isGroupMember', Auth::user(), $order->applicantTo)))
                            ? ' w-25'
                            : ' w-full' }}">
                        {{ __('Return') }}
                    </x-link-button>
                    @canany(['isAnalyzer', 'isAdmin', 'isSupervisor'], Auth::user())
                        @if ($order->status_id == 1)
                            <x-primary-button type="submit" form="form-description" class="w-full justify-center">
                                {{ __('Accept order') }}
                            </x-primary-button>
                        @elseif (
                            $order->status_id == 2 && ($order->applicant_to_id == Auth::id() || Gate::allows('isGroupMember', Auth::user(), $order->applicantTo->id)))
                            <x-primary-button type="submit" id="finishButton" form="form-description"
                                class="w-full justify-center">
                                {{ __('Finish order') }}
                            </x-primary-button>
                        @endif
                    @endcanany
                </div>
            </div>
        </div>
    </div>
    <!-- Modal -->
    @include('modals.modal-finish-order')

</x-app-layout>
