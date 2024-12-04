<!-- Modal de confirmación -->
<div id="confirmationModal" class="hidden fixed inset-0 bg-black bg-opacity-60 z-50 opacity-0 transition-opacity duration-200">
    <div id="modalContent" class="bg-white dark:bg-gray-800 rounded-lg shadow-lg w-96 p-6 transform scale-75 opacity-0 transition-all duration-200" 
        style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <h2 class="text-lg font-semibold text-gray-800 dark:text-gray-200">Confirmar eliminación</h2>
        <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
            @if (request()->routeIs('order.edit'))
                ¿Estás seguro de que deseas eliminar este archivo? Esta acción no se puede deshacer.
            @else
                ¿Estás seguro de que deseas eliminar esta orden? Esta acción no se puede deshacer.
            @endif
        </p>

        <div class="mt-4 flex justify-end space-x-2">
            <!-- Botón para cancelar -->
            <button id="cancelButton" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-gray-200 dark:hover:bg-gray-600">
                Cancelar
            </button>

            <!-- Botón para aceptar -->
            <button id="confirmButton" class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700" disabled>
                Aceptar (5)
            </button>
        </div>
    </div>
</div>
