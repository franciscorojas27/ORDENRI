<!-- resources/views/chat.blade.php -->
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chatbot</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Chatbot</h1>
    <form id="chat-form" action="{{ route('chatbot') }}" method="POST">
        @csrf
        @method('POST')
        <input type="text" id="user-input" placeholder="Escribe tu mensaje" required>
        <button type="submit">Enviar</button>
    </form>
    <label id="response-label"></label>

    <script>
        $(document).ready(function() {
            $('#chat-form').on('submit', function(e) {
                e.preventDefault();
                const userInput = $('#user-input').val();

                $.ajax({
                    url: '/chatbot',
                    method: 'POST',
                    data: {
                        message: userInput,
                        _token: '{{ csrf_token() }}' // Incluir el token CSRF
                    },
                    success: function(response) {
                        $('#response-label').text(response.response);
                    },
                    error: function(xhr) {
                        $('#response-label').text("Error en la comunicación con el servidor.");
                    }
                });
            });
        });
    </script>
</body>
</html>
