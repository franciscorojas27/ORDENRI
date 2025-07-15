🚀 ORDENRI: Sistema de Gestión de Órdenes de Servicio para la Red Inteligente de Cantv
✨ Descripción del Proyecto
ORDENRI es una aplicación web integral diseñada para optimizar y centralizar la gestión de órdenes de servicio (OS) relacionadas con las fallas en la red inteligente de Cantv. Permite un control eficiente de todo el ciclo de vida de una OS, desde su creación hasta su resolución, facilitando el seguimiento, la asignación de recursos y la visualización de indicadores clave de rendimiento (KPIs).

Desarrollada con Laravel, MySQL, Blade, Alpine.js y Tailwind CSS, ORDENRI aprovecha todas las funcionalidades del framework Laravel para ofrecer una solución robusta, escalable y con una interfaz de usuario moderna y responsiva. Incluye un sistema de autenticación personalizado basado en Laravel Breeze, asegurando un control de acceso seguro.

💡 Características Principales
Gestión Completa de Órdenes de Servicio:

Creación, visualización, edición y eliminación de órdenes de servicio.

Registro detallado de la falla, ubicación, equipo afectado y datos del cliente.

Asignación de órdenes a técnicos o cuadrillas.

Seguimiento de Estado en Tiempo Real:

Flujo de trabajo configurable para el cambio de estado de las órdenes (Ej: Creada, Asignada, En Proceso, Resuelta, Cerrada).

Historial de cambios y acciones realizadas en cada orden.

Gestión de Usuarios y Roles:

Sistema de autenticación y autorización robusto (Laravel Breeze modificado).

Definición de roles con diferentes niveles de acceso y permisos (Ej: Administrador, Coordinador, Técnico, Supervisor).

Módulo de Reportes e Indicadores (KPIs):

Visualización de métricas clave sobre el rendimiento en la resolución de fallas.

Generación de informes sobre tiempos de respuesta, cantidad de fallas por zona, etc.

Gestión de Acuerdos de Nivel de Servicio (SLAs) para medir el cumplimiento.

Interfaz de Usuario Intuitiva y Moderna:

Desarrollada con Blade (vistas) y Tailwind CSS (estilos) para un diseño adaptable y atractivo.

Funcionalidades interactivas con Alpine.js para una experiencia de usuario dinámica.

Base de Datos Relacional:

Utiliza MySQL para una gestión eficiente y segura de los datos.

Desarrollo Eficiente:

Aprovecha las migraciones, seeders, Eloquent ORM, y el sistema de ruteo de Laravel.

Pruebas Automatizadas:

Incluye tests (pruebas unitarias y de integración) para asegurar la estabilidad y el correcto funcionamiento de las funcionalidades.

🛠️ Tecnologías Utilizadas
Backend:

Laravel: PHP Framework para el desarrollo web.

PHP: Lenguaje de programación.

MySQL: Sistema de Gestión de Bases de Datos Relacionales.

Frontend:

Blade: Motor de plantillas de Laravel.

Alpine.js: Framework JavaScript ligero para el comportamiento reactivo.

Tailwind CSS: Framework CSS utilitario para un diseño rápido y responsivo.

Autenticación:

Laravel Breeze: Kit de inicio de autenticación (versión editada).

Herramientas de Desarrollo:

Composer: Gestor de dependencias para PHP.

Node.js y NPM/Yarn: Gestores de paquetes para JavaScript.

Vite: Bundler para el frontend.

⚙️ Requisitos del Sistema
Antes de instalar y ejecutar ORDENRI, asegúrese de tener los siguientes componentes en su entorno:

Servidor Web: Nginx o Apache.

PHP: Versión 8.1 o superior.

MySQL: Versión 8.0 o superior.

Composer: Última versión instalada.

Node.js y NPM/Yarn: Para la compilación de activos de frontend.

🚀 Instalación y Configuración
Siga estos pasos para poner en marcha el proyecto en su entorno local:

Clonar el repositorio:

git clone https://github.com/franciscorojas27/ORDENRI.git
cd ORDENRI

Instalar dependencias de Composer:

composer install

Configurar el archivo de entorno:

Cree una copia del archivo .env.example y renómbrela a .env:

cp .env.example .env

Abra el archivo .env y configure los siguientes parámetros:

APP_URL: La URL de su aplicación (ej: http://localhost:8000).

DB_DATABASE, DB_USERNAME, DB_PASSWORD: Credenciales de su base de datos MySQL.

Generar la clave de aplicación:

php artisan key:generate

Ejecutar migraciones y seeders (opcional, para datos de prueba):

php artisan migrate --seed

(Si desea poblar la base de datos con datos de prueba iniciales.)

Instalar dependencias de Node.js y compilar activos de frontend:

npm install
npm run dev  # Para desarrollo
# o
npm run build # Para producción

Iniciar el servidor de desarrollo de Laravel (si no está usando un servidor web como Nginx/Apache):

php artisan serve

🔒 Autenticación
El sistema incluye un módulo de autenticación personalizado basado en Laravel Breeze. Los usuarios pueden:

Registrarse

Iniciar Sesión

Restablecer Contraseña (se ha agregado un botón para volver en el formulario de "forgot-email")

📝 Contribución
¡Las contribuciones son bienvenidas! Si desea mejorar este proyecto, por favor siga los siguientes pasos:

Haga un fork del repositorio.

Cree una nueva rama (git checkout -b feature/su-caracteristica).

Realice sus cambios y haga commit (git commit -am 'Agregar nueva característica').

Suba sus cambios a su fork (git push origin feature/su-caracteristica).

Abra un Pull Request explicando sus cambios.


📧 Contacto
Para cualquier consulta o sugerencia, puede contactar al desarrollador:

Francisco Rojas - franciscorojas27
