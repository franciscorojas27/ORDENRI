<table class="min-w-[700px]  w-full text-sm text-left select-text text-gray-900 dark:text-gray-100">
    <thead class="text-xs dark:text-white uppercase bg-blue-500 text-white dark:bg-gray-700">
        <tr>
            <th scope="col" class="px-6 py-3">N° orden</th>
            <th scope="col" class="px-6 py-3">Tipo</th>
            <th scope="col" class="px-6 py-3">Area de resolución</th>
            <th scope="col" class="px-6 py-3">Fecha de creación</th>
            <th scope="col" class="px-6 py-3">Descripción</th>
            <th scope="col" class="px-6 py-3">Estado</th>
            <th scope="col" class="px-6 py-3"></th>
            @canany(['isAdmin', 'isSupervisor'], Auth::user())
                <th class="px-3 py-3" scope="col" aria-label=" {{ __('Actions') }} "></th>
            @endcanany
        </tr>
    </thead>
    <tbody>
        @foreach ($orders as $order)
            <tr class="bg-white dark:bg-gray-800 border-b dark:border-gray-700 mb-2">
                <td class="px-6 py-4">{{ $order->id }}</td>
                <td class="px-6 py-4">{{ $order->type->type }}</td>
                <td class="px-6 py-4">{{ $order->resolutionArea->area }}</td>
                <td class="px-6 py-4">
                    {{ $order->created_at->format('d/m/Y') }}<br>{{ $order->created_at->format('H:i') }}
                </td>
                <td class="px-6 py-4">{{ Str::words($order->client_description, 15) }}</td>
                <td class="px-6 py-4">{{ $order->status->status }}</td>
                <td class="px-6 py-4">
                    <a href="{{ Auth::user()->isSupervisor() || Auth::user()->isAdmin() ? route('order.edit', $order) : $route($order) }}"
                        class="text-white bg-blue-500 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 py-2 px-4 rounded-md">
                        {{ __('Details') }}
                    </a>
                </td>
                @canany(['isAdmin', 'isSupervisor'], Auth::user())
                    <td class="px-3 py-4">
                        @if (request()->routeIs('order.consultation.index'))
                            <a class="mr-5 flex justify-center" href="{{ route('order.consultation.download', $order) }}"
                                target="_blank">
                                <svg data-slot="icon" fill="none" stroke-width="1.5" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24"
                                    height="24">

                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3">
                                    </path>
                                </svg>
                            </a>
                        @else
                            <form id="delete-order-{{ $order->id }}"
                                action="{{ route('order.destroy', $order) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button class="open-modal-button" data-form-id="delete-order-{{ $order->id }}"
                                    type="button">
                                    Eliminar
                                </x-danger-button>
                            </form>
                        @endif
                    </td>
                @endcanany
            </tr>
        @endforeach
    </tbody>
</table>
{{ $slot }}
