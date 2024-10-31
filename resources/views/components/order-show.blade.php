@props(['order'])

<div class="grid grid-cols-2 gap-4">
    <div>
        <x-input-label for="id" class="mt-2" :value="__('N°')" />
        <x-text-input required readonly id="id" class="block mt-2 w-full" type="text"
            name="id" :value="old('id', $order->id)" />
    </div>
    <div>
        <x-input-label for="client_id" class="mt-2" :value="__('Applicant')" />
        <x-text-input required readonly id="client_id" class="block mt-2 w-full" type="text"
            name="client_id" :value="old('client', $order->client->name . ' ' . $order->client->last_name)" />
    </div>
</div>
<div class="grid grid-cols-2 gap-6">
    <div>
        <x-input-label for="created_at" class="mt-2" :value="__('Creation date')" />
        <x-text-input required readonly id="created_at" class="block mt-2 w-full" type="text"
            name="created_at" :value="old('created_at', $order->created_at)" />
    </div>

    <div>
        <x-input-label for="start_at" class="mt-2" :value="__('Start date')" />
        <x-text-input required readonly id="start_at" class="block mt-2 w-full" type="text"
            name="start_at" :value="old('start_at', $order->start_at ? $order->start_at : 'No iniciado')" />
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div>
        <x-input-label for="end_at" class="mt-2" :value="__('End date')" />
        <x-text-input required readonly id="end_at" class="block mt-2 w-full" type="text"
            name="end_at" :value="old('end_at', $order->end_at ? $order->end_at : 'No finalizado')" />
    </div>
    <div>
        <x-input-label for="status_id" class="mt-2" :value="__('Status')" />
        <x-text-input required readonly id="status_id" class="block mt-2 w-full" type="text"
            name="status_id" :value="old('status_id', $order->status->status ?? '')" />
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div>
        <x-input-label for="type_id" class="mt-2" :value="__('Order type')" />
        <x-text-input required readonly id="type_id" class="block mt-2 w-full" type="text"
            name="type_id" :value="old('type_id', $order->type->type ?? '')" />
        <x-input-error :messages="$errors->get('type')" class="mt-2" />
    </div>

    <div>
        <x-input-label for="responsible_id" class="mt-2" :value="__('Supervisor')" />
        <x-text-input required readonly id="responsible_id" class="block mt-2 w-full" type="text"
            name="responsible_id" :value="old(
                'responsible',
                $order->responsible
                    ? $order->responsible->name . ' ' . $order->responsible->last_name
                    : '',
            )" />
    </div>
</div>

<div class="grid grid-cols-2 gap-6">
    <div>
        <x-input-label for="resolution_area_id" class="mt-2" :value="__('Resolution Areas')" />
        <x-text-input required readonly id="resolution_area_id" class="block mt-2 w-full" type="text"
            name="resolution_area_id" :value="old('resolution_area_id', $order->resolutionArea->area)" />
    </div>

    <div>
        <x-input-label for="applicant_to_id" class="mt-2" :value="__('Applicant to')" />
        <x-text-input required readonly id="applicant_to_id" class="block mt-2 w-full" type="text"
            name="applicant_to_id" :value="old(
                'applicant_to_id',
                $order->applicantTo
                    ? $order->applicantTo->name . ' ' . $order->applicantTo->last_name
                    : '',
            )" />
    </div>
</div>

<div>
    <x-input-label for="client_description" class="mt-2" :value="__('Client description')" class="mt-4" />
    <x-textarea required readonly id="client_description" name="client_description" rows="4"
        cols="65" style="resize: none;" class="mt-2 block w-full">
        {{ old('client_description', $order->client_description) }}
    </x-textarea>
</div>

<div>
    <x-input-label for="description" class="mt-2" :value="__('Activity')" class="mt-4" />
    <x-textarea required {{ request()->routeIs('order.show') ? 'readonly' : '' }} id="description" name="description" rows="4" cols="65"
        style="resize: none;" class="mt-2 block w-full">
        {{ old('description', $order->description) }}
    </x-textarea>
</div>

{{slot}}