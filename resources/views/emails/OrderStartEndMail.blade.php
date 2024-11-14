<!DOCTYPE html>
<!DOCTYPE html>
<html lang="es">
    <head>
        <title>Detalles de la Orden</title>
    </head>

    <body>
        <h1>Orden #{{ $order->id }}</h1>
        <h2>Prototipo del sistema de gestion de ordenes de servicio CRI (Correo de prueba)</h2>
        @if ($order->status->status === 'Pendiente')
            <p>Orden creada por: {{ $order->client->name }} {{ $order->client->last_name }} el
                {{ $order->created_at->format('d/m/Y h:i A') }}, en el area de resolución:
                {{ $order->resolutionArea->area }}</p>
        @endif
        @if ($order->status->status === 'En Proceso')
            <p>La orden esta en proceso de resolución por el Analista: {{ $order->applicantTo->name }}</p>
        @endif
        @if ($order->status->status === 'Finalizada')
            <p>La orden ha sido finalizada por el Analista: {{ $order->applicantTo->name }} .
                {{ $order->applicantTo->last_name }}</p>
        @endif
        <a href="{{ route('order.show', $order) }}" class="text-blue-600 hover:underline">Ver detalles de la orden</a>
    </body>

</html>
