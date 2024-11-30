export default function sidebarData() {
    return {
        sideNav: JSON.parse(localStorage.getItem("sideNav")) ?? true, // Cargar el estado de sideNav desde localStorage
        init() {
            // Se inicializa el valor de sideNav si es necesario
            this.sideNav = JSON.parse(localStorage.getItem("sideNav")) ?? true;
        },
        toggleSideNav() {
            // Cambiar el estado de sideNav
            this.sideNav = !this.sideNav;
            localStorage.setItem("sideNav", JSON.stringify(this.sideNav)); // Guardar el estado en localStorage
        },
    };
}