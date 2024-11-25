
// Verifica el tema almacenado en localStorage
const storedDarkMode = localStorage.getItem("darkMode") === "true";

// Determina el tema a aplicar: prioridad a lo que está en localStorage, sino a la preferencia del sistema
const isDarkMode = storedDarkMode !== null ? storedDarkMode : prefersDarkScheme;

// Obtener los elementos de los switches
const themeToggleMain = document.getElementById("theme-toggle-main");
const themeToggleResponsive = document.getElementById(
    "theme-toggle-responsive"
);
// Verifica el tema preferido del sistema operativo utilizando matchMedia
const prefersDarkScheme = window.matchMedia(
    "(prefers-color-scheme: dark)"
).matches;

// Si el tema actual es oscuro, activa los switches
if (isDarkMode) {
    document.documentElement.classList.add("dark");
    themeToggleMain.checked = true;
    themeToggleResponsive.checked = true;
}

// Función para cambiar el tema y sincronizar ambos switches
function toggleDarkMode() {
    document.documentElement.classList.toggle("dark");
    localStorage.setItem("darkMode", document.documentElement.classList.contains("dark"));

    // Sincroniza ambos switches
    const isChecked = document.documentElement.classList.contains("dark");
    themeToggleMain.checked = isChecked;
    themeToggleResponsive.checked = isChecked;
}

// Event listeners para ambos switches
themeToggleMain.addEventListener("change", toggleDarkMode);
themeToggleResponsive.addEventListener("change", toggleDarkMode);

// Detecta cambios en la preferencia del sistema (si el usuario cambia de tema)
window
    .matchMedia("(prefers-color-scheme: dark)")
    .addEventListener("change", (e) => {
        if (!localStorage.getItem("darkMode")) {
            const isSystemDark = e.matches;
            document.documentElement.classList.toggle("dark", isSystemDark);
            themeToggleMain.checked = isSystemDark;
            themeToggleResponsive.checked = isSystemDark;
        }
    });

