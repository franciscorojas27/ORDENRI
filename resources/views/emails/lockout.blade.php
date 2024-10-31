<!DOCTYPE html>
<html>
<head>
    <title>Confirmación de Pedido</title>
</head>
<body>
    <h1>Gracias por tu pedido!</h1>
    <p>Detalles de tu pedido:</p>
    @foreach ($orders as $order)
        <ul>
            <li>N° de orden: {{ $order->id }}</li>
            <li>Tipo: {{ $order->type->type }}</li>
            <li>Área de resolución: {{ $order->resolutionArea->area }}</li>
            <li>Fecha de creación: {{ $order->created_at->format('d/m/Y H:i') }}</li>
            <li>Descripción: {{ $order->client_description }}</li>
            <li>Estado: {{ $order->status->status }}</li>
        </ul>
    @endforeach
</body>
</html>
