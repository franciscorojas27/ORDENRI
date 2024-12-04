document.addEventListener("DOMContentLoaded", function() {
    const file_input = document.getElementById('file_input');
    const filePreview = document.getElementById('filePreview');
    let filesQueue = [];

    // Función para mostrar los archivos seleccionados en la interfaz
    function renderFiles() {
        if (filesQueue.length > 0) {
            filePreview.style.display = 'block'; // Mostrar el contenedor si hay archivos
        } else {
            filePreview.style.display = 'none'; // Ocultar si no hay archivos
        }

        filePreview.innerHTML = ''; // Limpiar vista previa
        filesQueue.forEach((file, index) => {
            const fileDiv = document.createElement('div');
            fileDiv.classList.add('file-item', 'flex', 'justify-between', 'items-center',
                'bg-white', 'p-2', 'border', 'rounded-lg', 'mt-2');
            fileDiv.innerHTML = `
                <span class="text-black">${file.name}</span>
                <button type="button" class="text-red-500" onclick="removeFile(${index})">Eliminar</button>
            `;
            filePreview.appendChild(fileDiv);
        });
    }

    // Función para agregar archivos a la cola
    file_input.addEventListener('change', function() {
        const files = file_input.files;
        filesQueue = Array.from(
        files); // Reemplazar la cola de archivos con los nuevos archivos seleccionados
        renderFiles(); // Actualizar la vista
    });

    // Función para eliminar un archivo de la cola
    window.removeFile = function(index) {
        filesQueue.splice(index, 1); // Eliminar el archivo de la cola
        updateInput(); // Actualizar el input después de eliminar un archivo
        renderFiles(); // Actualizar la vista después de eliminar
    };

    // Actualiza el input para que solo contenga los archivos restantes
    function updateInput() {
        // Crear un nuevo objeto DataTransfer
        const dataTransfer = new DataTransfer();
        filesQueue.forEach(file => {
            dataTransfer.items.add(file); // Añadir cada archivo restante
        });
        // Actualizar el input con los archivos restantes
        file_input.files = dataTransfer.files;
    }
});