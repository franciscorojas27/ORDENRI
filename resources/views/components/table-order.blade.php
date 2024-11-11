<table class="min-w-[700px] w-full text-sm text-left select-text text-gray-900 dark:text-gray-100">
    <thead class="text-xs dark:text-gray-400 uppercase bg-blue-600  dark:bg-gray-700">
        <tr>
            <th scope="col" class="px-6 py-3">N° orden</th>
            <th scope="col" class="px-6 py-3">Tipo</th>
            <th scope="col" class="px-6 py-3">Area de resolucion</th>
            <th scope="col" class="px-6 py-3">Fecha de creacion</th>
            <th scope="col" class="px-6 py-3">Descripcion</th>
            <th scope="col" class="px-6 py-3">Estado</th>
            <th scope="col" class="px-6 py-3"></th>
            @canany(['isAdmin', 'isSupervisor'], Auth::user())
                <th scope="col" class="px-3 py-3" aria-label="Acciones"> </th>
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
                        {{__('Details')}}
                    </a>    
                </td>
                @canany(['isAdmin', 'isSupervisor'], Auth::user())
                    <td class="px-3 py-4">
                        @if (request()->routeIs('order.consultation.index'))
                            <form id="delete-order-{{ $order->id }}">
                                <a href="{{ route('order.consultation.download', $order) }}" target="_blank"
                                    class="text-white bg-green-500 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 py-2 px-4 rounded-md">
                                    {{__('Print')}}
                                </a>
                            </form>
                        @else
                            <form id="delete-order-{{ $order->id }}" action="{{ route('order.destroy', $order) }}"
                                method="POST">
                                @csrf
                                @method('DELETE')
                                <x-danger-button
                                    onclick="confirm('¿Seguro que deseas eliminar esta orden?') || event.stopImmediatePropagation()">
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
