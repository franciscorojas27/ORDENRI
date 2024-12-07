<!DOCTYPE html>
<html lang="es">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Orden de Servicio #{{ $order->id }}</title>
        <style>
            /* Estilos generales */
            body {
                font-family: 'Arial', sans-serif;
                background-color: #f4f4f4;
                color: #333;
                margin: 0;
                padding: 0;
                line-height: 1.4;
                font-size: 12px;
                /* Tamaño más pequeño para asegurar que todo entre */
            }

            .container {
                width: 100%;
                max-width: 800px;
                margin: 0 auto;
                padding: 15px;
                background-color: white;
                border-radius: 8px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
                page-break-after: always;
            }

            /* Título principal */
            .title {
                text-align: center;
                font-size: 20px;
                font-weight: bold;
                margin-bottom: 10px;
            }

            .details {
                margin-bottom: 15px;
            }

            .details h3 {
                font-size: 16px;
                font-weight: bold;
                margin-bottom: 5px;
                border-bottom: 2px solid #333;
                padding-bottom: 3px;
            }

            .details p {
                margin: 4px 0;
                font-size: 12px;
            }

            /* Tabla de detalles de la orden */
            .table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 15px;
            }

            .table th,
            .table td {
                padding: 6px;
                text-align: left;
                border: 1px solid #ddd;
                font-size: 12px;
            }

            .table th {
                background-color: #f0f0f0;
                font-weight: bold;
            }

            .status {
                padding: 4px 8px;
                color: white;
                font-weight: bold;
                border-radius: 5px;
            }

            .status.active {
                background-color: #4caf50;
            }

            .status.inactive {
                background-color: #f44336;
            }

            /* Pie de página */
            .footer {
                text-align: right;
                font-size: 10px;
                margin-top: 10px;
                color: #777;
            }

            /* Asegura que todo se ajuste dentro de una página */
            .container {
                max-height: 100%;
                overflow: hidden;
            }

            /* Elimina el salto de página innecesario */
            .details,
            .table,
            .footer {
                page-break-inside: avoid;
            }

            .container {
                page-break-after: always;
            }
        </style>
    </head>

    <body>

        <div class="container">
            <div class="title">
                <h1>Orden de Servicio #{{ $order->id }}</h1>
                <p>Fecha: {{ $order->created_at->format('d/m/Y h:i A') }}</p>
            </div>

            <div class="details">
                <h3>Detalles del Solicitante</h3>
                <p><strong>Nombre:</strong> {{ $order->client->name . ' ' . $order->client->last_name }}</p>
                <p><strong>Email:</strong> {{ $order->client->email }}</p>
                <p><strong>Teléfono:</strong> {{ $order->client->phone }}</p>
            </div>
            <!-- Datos del Responsable -->
            @if ($order->responsible)
                <div class="details">
                    <h3>Responsable de la Orden</h3>
                    <p><strong>Nombre:</strong> {{ $order->responsible->name . ' ' . $order->responsible->last_name }}
                    </p>
                    <p><strong>Email:</strong> {{ $order->responsible->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $order->responsible->phone }}</p>
                </div>
            @endif

            <!-- Datos del Supervisor -->
            @if ($order->supervisor)
                <div class="details">
                    <h3>Supervisor de la Orden</h3>
                    <p><strong>Nombre:</strong> {{ $order->supervisor->name . ' ' . $order->supervisor->last_name }}</p>
                    <p><strong>Email:</strong> {{ $order->supervisor->email }}</p>
                    <p><strong>Teléfono:</strong> {{ $order->supervisor->phone }}</p>
                </div>
            @endif
            <div class="details">
                <h3>Detalles de la Orden</h3>
                <table class="table">
                    <tr>
                        <th>N° Orden</th>
                        <td>{{ $order->id }}</td>
                    </tr>
                    <tr>
                        <th>Tipo</th>
                        <td>{{ $order->type->type }}</td>
                    </tr>
                    <tr>
                        <th>Área de Resolución</th>
                        <td>{{ $order->resolutionArea->area }}</td>
                    </tr>
                    <tr>
                        <th>Fecha de Creación</th>
                        <td>{{ $order->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    <tr>
                        <th>Descripción</th>
                        <td>{{ $order->client_description }}</td>
                    </tr>
                    <tr>
                        <th>Estado</th>
                        <td>
                            <span class="status {{ $order->status->status == 'Activo' ? 'active' : 'inactive' }}">
                                {{ $order->status->status }}
                            </span>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- Fecha de emisión del PDF -->
            <div class="footer">
                <p>Fecha de emisión del PDF: {{ now()->format('d/m/Y H:i') }}</p>
            </div>
        </div>

    </body>

</html>
