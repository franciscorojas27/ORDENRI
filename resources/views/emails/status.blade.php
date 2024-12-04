@component('mail::message')
    {{ $message }}

    @component('mail::button', ['url' => route('order.show', $order)])
        Ver detalles de la orden
    @endcomponent

    Gracias por utilizar nuestro sistema de gestión de órdenes de servicio.
@endcomponent
