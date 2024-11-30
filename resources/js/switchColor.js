document.addEventListener("DOMContentLoaded", () => {
    const themeToggleMain = document.getElementById("theme-toggle-main");
    const themeToggleResponsive = document.getElementById(
        "theme-toggle-responsive"
    );

    // Detecta la preferencia del sistema
    const prefersDarkScheme = window.matchMedia(
        "(prefers-color-scheme: dark)"
    ).matches;

    // Recupera el estado del tema desde localStorage (maneja el caso donde no existe)
    let storedDarkMode = localStorage.getItem("darkMode");

    // Si no existe en localStorage, usamos la preferencia del sistema
    if (storedDarkMode === null) {
        storedDarkMode = prefersDarkScheme;
    } else {
        storedDarkMode = JSON.parse(storedDarkMode); // Convierte el valor almacenado a boolean
    }

    // Aplica el tema inicial
    if (storedDarkMode) {
        document.documentElement.classList.add("dark");
    }

    // Sincroniza los interruptores de tema (si existen)
    if (themeToggleMain) themeToggleMain.checked = storedDarkMode;
    if (themeToggleResponsive) themeToggleResponsive.checked = storedDarkMode;

    // Función para alternar el modo oscuro y sincronizar los interruptores
    const toggleDarkMode = () => {
        const isDark = document.documentElement.classList.toggle("dark");
        localStorage.setItem("darkMode", JSON.stringify(isDark));

        if (themeToggleMain) themeToggleMain.checked = isDark;
        if (themeToggleResponsive) themeToggleResponsive.checked = isDark;
    };

    // Agrega eventos a los interruptores
    if (themeToggleMain)
        themeToggleMain.addEventListener("change", toggleDarkMode);
    if (themeToggleResponsive)
        themeToggleResponsive.addEventListener("change", toggleDarkMode);

    // Escucha cambios en la preferencia del sistema
    window
        .matchMedia("(prefers-color-scheme: dark)")
        .addEventListener("change", (e) => {
            if (localStorage.getItem("darkMode") === null) {
                const isSystemDark = e.matches;
                document.documentElement.classList.toggle("dark", isSystemDark);

                if (themeToggleMain) themeToggleMain.checked = isSystemDark;
                if (themeToggleResponsive)
                    themeToggleResponsive.checked = isSystemDark;
            }
        });

    // Muestra el contenido una vez cargado el tema
    document.documentElement.classList.add("theme-loaded");
});


