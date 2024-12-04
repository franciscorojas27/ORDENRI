/**
 * Este script maneja la apertura, cierre y el conteo regresivo en un modal de confirmación
 * para la eliminación de un objeto (orden, elemento, etc.) en la interfaz de usuario.
 * Al hacer clic en un botón de "Eliminar", se muestra un modal que pregunta al usuario si
 * desea confirmar la acción, con un temporizador que cuenta hacia atrás desde 5 segundos.
 * Si el usuario no confirma antes de que termine el tiempo, el botón de confirmar se habilita.
 * Si el usuario confirma, se envía el formulario relacionado con la acción de eliminación.
 * 
 * @fileOverview Controlador de modal con temporizador para confirmación de eliminación
 * @author Tu Nombre
 * @version 1.0
 */

// Escucha cuando el contenido del DOM está completamente cargado
document.addEventListener("DOMContentLoaded", () => {

    // Elementos del DOM que se utilizarán
    const modal = document.getElementById("confirmationModal"); // Modal de confirmación
    const modalContent = document.getElementById("modalContent"); // Contenido del modal
    const cancelButton = document.getElementById("cancelButton"); // Botón de cancelar
    const confirmButton = document.getElementById("confirmButton"); // Botón de confirmar

    let countdown, targetForm;

    /**
     * Abre el modal y configura el formulario objetivo.
     * @param {HTMLElement} button - El botón que activó el modal, contiene un atributo 'data-form-id' con el ID del formulario a enviar.
     */
    const openModal = (button) => {
        targetForm = document.getElementById(button.dataset.formId); // Encuentra el formulario correspondiente
        resetConfirmButton(); // Reinicia el estado del botón de confirmación
        modal.classList.remove("hidden", "opacity-0"); // Muestra el modal
        setTimeout(() => {
            modalContent.classList.remove("scale-75", "opacity-0"); // Efecto de aparición
            modalContent.classList.add("scale-100", "opacity-100");
        }, 10);
        startCountdown(); // Inicia el temporizador
    };

    /**
     * Inicia el temporizador de cuenta regresiva en el botón de confirmación.
     */
    const startCountdown = () => {
        let timeLeft = 5; // Temporizador comienza en 5 segundos
        confirmButton.textContent = `Aceptar (${timeLeft})`; // Actualiza el texto del botón
        confirmButton.disabled = true; // Deshabilita el botón hasta que se complete la cuenta atrás
        countdown = setInterval(() => {
            confirmButton.textContent = `Aceptar (${--timeLeft})`; // Actualiza el tiempo restante
            if (timeLeft <= 0) stopCountdown(); // Detiene el temporizador cuando llega a 0
        }, 1000); // El temporizador se actualiza cada 1 segundo
    };

    /**
     * Detiene la cuenta regresiva y habilita el botón de confirmación.
     */
    const stopCountdown = () => {
        clearInterval(countdown); // Detiene el temporizador
        confirmButton.textContent = "Aceptar"; // Restablece el texto del botón
        confirmButton.disabled = false; // Habilita el botón para que el usuario pueda confirmar
    };

    /**
     * Cierra el modal y reinicia el estado del botón de confirmación.
     */
    const closeModal = () => {
        clearInterval(countdown); // Detiene cualquier temporizador activo
        modalContent.classList.remove("scale-100", "opacity-100"); // Efecto de cierre del modal
        modalContent.classList.add("scale-75", "opacity-0");
        setTimeout(() => {
            modal.classList.add("hidden", "opacity-0"); // Oculta el modal
            resetConfirmButton(); // Reinicia el estado del botón de confirmación
        }, 200); // Espera un poco antes de ocultar el modal
    };

    /**
     * Reinicia el botón de confirmación a su estado original (con 5 segundos de cuenta regresiva).
     */
    const resetConfirmButton = () => {
        clearInterval(countdown); // Detiene el temporizador
        confirmButton.textContent = "Aceptar (5)"; // Restablece el texto del botón
        confirmButton.disabled = true; // Deshabilita el botón
    };

    // Añade un event listener a todos los botones de apertura de modal (con la clase 'open-modal-button')
    document.querySelectorAll(".open-modal-button").forEach((button) => {
        button.addEventListener("click", () => openModal(button)); // Abre el modal al hacer clic
    });

    // Añade un event listener al botón de confirmación para enviar el formulario
    confirmButton.addEventListener("click", () => {
        if (targetForm) {
            targetForm.submit(); // Envía el formulario
            closeModal(); // Cierra el modal después de enviar el formulario
        }
    });

    // Añade un event listener al botón de cancelar para cerrar el modal sin realizar ninguna acción
    cancelButton.addEventListener("click", closeModal);
});
