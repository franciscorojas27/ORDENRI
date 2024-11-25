<?php

$address = '127.0.0.1';
$port = 8080;

// Crear el servidor de socket
$server = stream_socket_server("tcp://$address:$port", $errno, $errstr);
if (!$server) {
    die("Error al crear el servidor: $errstr ($errno)\n");
}

echo "Servidor WebSocket iniciado en ws://$address:$port\n";

// Array para almacenar las conexiones activas
$clients = [];

while (true) {
    // Crear un array de los sockets para la función stream_select
    $read = $clients;
    $read[] = $server;

    // Esperar actividad en los sockets (leer, escribir o excepción)
    $write = $except = null;
    $num_changed_sockets = stream_select($read, $write, $except, null);

    // Si el servidor está listo para aceptar una nueva conexión
    if (in_array($server, $read)) {
        $client = stream_socket_accept($server);
        if ($client) {
            echo "Nuevo cliente conectado.\n";
            $clients[] = $client;

            // Realizar el "handshake" para WebSocket
            handshake($client);
        }

        // Eliminar el servidor de la lista de sockets para evitar aceptaciones múltiples
        $read = array_diff($read, [$server]);
    }

    // Manejar mensajes entrantes de los clientes
    foreach ($read as $client) {
        $data = fread($client, 1024);
        if (!$data) {
            // Si no se recibe datos, el cliente ha cerrado la conexión
            $key = array_search($client, $clients);
            if ($key !== false) {
                unset($clients[$key]);
                fclose($client);
                echo "Cliente desconectado.\n";
            }
        } else {
            // Decodificar y retransmitir el mensaje
            $decodedMessage = unmask($data);
            echo "Mensaje recibido: $decodedMessage\n";

            // Enviar el mensaje a todos los demás clientes
            foreach ($clients as $sendClient) {
                if ($sendClient !== $client) {
                    $encodedMessage = mask($decodedMessage);
                    fwrite($sendClient, $encodedMessage);
                }
            }
        }
    }
}

// Función para realizar el handshake de WebSocket
function handshake($client) {
    $headers = fread($client, 1024);
    preg_match('#Sec-WebSocket-Key: (.*)\r\n#', $headers, $matches);
    $key = $matches[1];
    $acceptKey = base64_encode(sha1($key . '258EAFA5-E914-47DA-95CA-C5AB0DC85B11', true));

    $response = "HTTP/1.1 101 Switching Protocols\r\n";
    $response .= "Upgrade: websocket\r\n";
    $response .= "Connection: Upgrade\r\n";
    $response .= "Sec-WebSocket-Accept: $acceptKey\r\n\r\n";

    fwrite($client, $response);
}

// Función para desofuscar los datos recibidos
function unmask($payload) {
    $length = ord($payload[1]) & 127;
    if ($length === 126) {
        $masks = substr($payload, 4, 4);
        $data = substr($payload, 8);
    } elseif ($length === 127) {
        $masks = substr($payload, 10, 4);
        $data = substr($payload, 14);
    } else {
        $masks = substr($payload, 2, 4);
        $data = substr($payload, 6);
    }

    $text = '';
    for ($i = 0; $i < strlen($data); ++$i) {
        $text .= $data[$i] ^ $masks[$i % 4];
    }
    return $text;
}

// Función para ofuscar los datos a enviar
function mask($text) {
    $b1 = 0x81;
    $length = strlen($text);

    if ($length <= 125) {
        $header = pack('CC', $b1, $length);
    } elseif ($length <= 65535) {
        $header = pack('CCn', $b1, 126, $length);
    } else {
        $header = pack('CCNN', $b1, 127, 0, $length);
    }

    return $header . $text;
}
?>
