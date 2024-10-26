<!DOCTYPE html>
<html lang="es" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orden de Servicio #{{ $order->id }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])  <!-- Mantén esto en la sección de head -->
    <style>
        body {
            font-family: 'Arial', sans-serif;
            font-size: 14px;
            color: #333;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f8f9fa;
        }
        .bg-header {
            background-color: #007bff;
            color: white;
        }
    </style>
</head>
<body class="bg-gray-50 text-gray-800">

    <div class="header bg-header p-6 text-center">
        <h1 class="text-3xl font-semibold">Orden de Servicio</h1>
        <p class="text-lg mt-1">Número de Orden: {{ $order->id }}</p>
        <p class="text-lg">Fecha: {{ $order->created_at->format('d/m/Y h:i A') }}</p>
    </div>

    <div class="content mx-8 mt-8">
        <section class="mb-6">
            <h3 class="text-2xl font-semibold border-b pb-2 mb-3">Detalles del Solicitante</h3>
            <p><span class="font-semibold">Nombre:</span> {{ $order->client->name . " " . $order->client->last_name }}</p>
            <p><span class="font-semibold">Email:</span> {{ $order->client->email }}</p>  <!-- Cambiado de "Dirección" a "Email" -->
            <p><span class="font-semibold">Teléfono:</span> {{ $order->client->phone }}</p>
        </section>

        <section class="mb-6">
            <h3 class="text-2xl font-semibold border-b pb-2 mb-3">Detalles de la Orden</h3>
            <table class="table-auto w-full text-left">
                <thead>
                    <tr>
                        <th class="px-4 py-2 font-semibold">N° orden</th>
                        <th class="px-4 py-2 font-semibold">Tipo</th>
                        <th class="px-4 py-2 font-semibold">Área de Resolución</th>
                        <th class="px-4 py-2 font-semibold">Fecha de Creación</th>
                        <th class="px-4 py-2 font-semibold">Descripción</th>
                        <th class="px-4 py-2 font-semibold">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b hover:bg-gray-50">
                        <td class="px-4 py-2">{{ $order->id }}</td>
                        <td class="px-4 py-2">{{ $order->type->type }}</td>
                        <td class="px-4 py-2">{{ $order->resolutionArea->area }}</td>
                        <td class="px-4 py-2">{{ $order->created_at->format('d/m/Y H:i') }}</td>
                        <td class="px-4 py-2">{{ $order->client_description }}</td>
                        <td class="px-4 py-2">{{ $order->status->status }}</td>
                    </tr>
                </tbody>
            </table>
        </section>
    </div>
    
</body>
</html>
