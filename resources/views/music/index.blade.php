<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reproductor de Música</title>
</head>
<body>
    <h1>Lista de Canciones</h1>
    <ul>
        @foreach ($songs as $song)
            <li>
                <button onclick="playAudio('{{ route('music.stream', ['filename' => $song]) }}')">
                    {{ $song }}
                </button>
            </li>
        @endforeach
    </ul>

    <audio controls id="audioPlayer" style="margin-top: 20px;">
        <source id="audioSource" src="" type="audio/mpeg">
        Tu navegador no soporta el elemento de audio.
    </audio>

    <script>
        function playAudio(url) {
            const audioPlayer = document.getElementById('audioPlayer');
            const audioSource = document.getElementById('audioSource');

            audioSource.src = url;
            audioPlayer.load();
            audioPlayer.play();
        }
    </script>
</body>
</html>
