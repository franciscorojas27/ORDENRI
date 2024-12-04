<!-- Modal de confirmación -->
<div id="finishOrderModal"
    class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50 dark:bg-gray-900 dark:bg-opacity-75 z-50 opacity-0 transition-opacity duration-300 ease-in-out">
    <div id="modalContent"
        class="bg-white dark:bg-gray-800 rounded-lg overflow-hidden shadow-xl max-w-sm w-full transform scale-75 opacity-0 transition-all duration-300 ease-in-out"
        style="position: fixed; top: 50%; left: 50%; transform: translate(-50%, -50%);">
        <!-- Contenido del Modal -->
        <div class="p-6 text-center">
            <!-- Icono de éxito -->
            <div class="flex items-center justify-center mb-6">
                <svg class="h-24 w-24 text-green-600 dark:text-green-400 animate-bounce" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                    <polyline points="22 4 12 14.01 9 11.01" />
                </svg>
            </div>

            <!-- Título -->
            <h2 class="text-2xl font-semibold text-gray-800 dark:text-white mb-4">Orden finalizada exitosamente</h2>

            <!-- Descripción -->
            <p class="text-sm text-gray-600 dark:text-gray-400 mb-6">
                Tu orden ha sido procesada y finalizada con éxito. ¡Gracias por confiar en nosotros!
            </p>
        </div>
    </div>
</div>

