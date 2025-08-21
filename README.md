# Planify API

La API de **Planify** es una solución integral para la gestión de viajes, desarrollada con **Laravel** y **MySQL**. Está diseñada para ser consumida por aplicaciones frontend como **React** y proporciona endpoints RESTful para interactuar con usuarios, reservas, vuelos, hoteles, itinerarios y tareas relacionadas.

## Funcionalidades principales

### Gestión de usuarios
- **Registro y autenticación**: Permite a los usuarios registrarse e iniciar sesión.
- **Perfil de usuario**: Consulta y actualización de la información del perfil.
- **Roles y permisos**: Gestión de roles para controlar el acceso a diferentes recursos.

### Gestión de viajes
- **Reservas de vuelos**: Realización de reservas de vuelos.
- **Reservas de hoteles**: Gestión de reservas de alojamiento.
- **Itinerarios de viaje**: Creación y consulta de itinerarios personalizados.
- **Tareas relacionadas**: Asignación y seguimiento de tareas vinculadas a los viajes.

### Plataforma completa
- **API RESTful**: Endpoints estructurados para facilitar la integración con aplicaciones frontend.
- **Formato JSON**: Respuestas en formato JSON para una fácil manipulación de datos.
- **Seguridad**: Implementación de autenticación basada en tokens para proteger los recursos sensibles.

## Tecnologías utilizadas

- **Backend**: Laravel (PHP)
- **Base de datos**: MySQL
- **Frontend**: React (consumidor de la API)
- **Autenticación**: Laravel Sanctum (tokens para autenticación segura)

## Instalación

1. Clonar el repositorio:

   ```bash
   git clone https://github.com/DavidLopezMirasierra16/Planify-API.git
   ```

2. Instalar las dependencias de Laravel:

   ```bash
   cd Planify-API
   composer install
   ```

3. Configurar el archivo .env con los datos de conexión a la base de datos y las claves necesarias.
4. Ejecutar las migraciones y seeders (opcional):
   
   ```bash
   php artisan migrate --seed
   ```

5. Iniciar el servidor de desarrollo:

   ```bash
   php artisan serve
   ```
