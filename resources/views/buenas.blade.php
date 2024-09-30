<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>BUNEAS</title>

        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    </head>

    <body>

        
        <form action="" method="POST" class="space-y-4">
            @csrf
            @method('POST')
            <div class="form-group">
                <label for="client_name" class="block text-sm font-medium text-gray-700">Buscar Usuario</label>
                <input list="users" id="client_name" name="client_name" class="mt-1 block w-full px-3 py-2 bg-white border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"
                    
                    placeholder="Escriba para buscar..." autocomplete="off">
                <datalist id="users" class="max-h-40 overflow-y-auto">
                    @foreach ($users as $user)
                        <option value="{{ $user->name }}" data-id="{{ $user->id }}" class="py-2 px-4 border-b border-gray-300">
                    @endforeach
                </datalist>
            </div>
            <!-- Otros campos del formulario -->
            <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                Guardar Orden
            </button>
        </form>

    </body>

</html>
