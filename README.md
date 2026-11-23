# Agenda de Contactos

## 1. Descripción del proyecto

Agenda de Contactos es una aplicación web desarrollada en PHP y MySQL que permite a los usuarios administrar sus contactos personales de manera sencilla y organizada.

Cada usuario puede registrarse, iniciar sesión y gestionar su propia lista de contactos.

## 2. URL pública del proyecto

**Enlace de acceso:**

https://agendacontactos.wuaze.com/

El proyecto se encuentra publicado mediante el servicio de hosting gratuito InfinityFree.

## 3. Capturas de pantalla

A continuación, se presentan las capturas de pantalla de las principales funcionalidades del sistema:

| N.º | Pantalla | Captura |
|---|---|---|
| 1 | Inicio de sesión | `capturas/login.png` |
| 2 | Registro de usuarios | `capturas/registro.png` |
| 3 | Panel principal (Dashboard) | `capturas/dashboard.png` |
| 4 | Lista de contactos | `capturas/contactos.png` |
| 5 | Registro de contactos | `capturas/registrar-contacto.png` |
| 6 | Edición de contactos | `capturas/editar-contacto.png` |
| 7 | Lista de favoritos | `capturas/favoritos.png` |

*Nota: Las capturas deben agregarse a la carpeta `capturas` del proyecto.*

## 4. Tecnologías utilizadas

- **PHP:** desarrollo de la lógica del sistema y procesamiento de datos.
- **MySQL:** almacenamiento de usuarios, contactos y categorías.
- **HTML5:** estructura de las páginas web.
- **CSS3:** diseño y estilos visuales de la aplicación.
- **JavaScript:** funcionalidades de interacción y búsqueda de contactos.
- **XAMPP:** entorno de desarrollo local.
- **phpMyAdmin:** administración de la base de datos.
- **InfinityFree:** servicio de hosting utilizado para publicar el proyecto.

## 5. Instrucciones para instalar el proyecto localmente

### Requisitos previos

- Tener instalado XAMPP.
- Contar con un navegador web.
- Tener Visual Studio Code o un editor de código.
- Tener habilitados Apache y MySQL.

### Paso 1. Descargar el proyecto

Descargar o copiar la carpeta `agenda_contactos` en el directorio:

`C:\xampp\htdocs\`

### Paso 2. Iniciar XAMPP

Abrir el panel de control de XAMPP e iniciar los servicios:

- Apache
- MySQL

### Paso 3. Crear la base de datos

1. Abrir el navegador.
2. Ingresar a `http://localhost/phpmyadmin/`.
3. Crear una base de datos llamada `agenda_contactos`.
4. Importar el archivo `database/agenda_contactos.sql`.

### Paso 4. Configurar la conexión

Abrir el archivo:

`config/conexion.php`

Configurar las credenciales de la base de datos local:

- Servidor: `localhost`
- Usuario: `root`
- Contraseña: vacía (configuración predeterminada de XAMPP).
- Base de datos: `agenda_contactos`.

### Paso 5. Ejecutar el proyecto

Abrir el navegador e ingresar a:

`http://localhost/agenda_contactos/`

El sistema mostrará la pantalla de inicio de sesión, desde donde se podrá registrar un nuevo usuario.

## 6. Mejoras implementadas respecto a la versión anterior

En esta nueva versión se incorporaron mejoras para optimizar la organización, administración y presentación de los contactos.

### Mejoras funcionales

- Implementación del registro de usuarios e inicio de sesión.
- Protección de las páginas mediante validación de sesiones.
- Encriptación de contraseñas utilizando `password_hash()`.
- Implementación de categorías para clasificar los contactos: Familia, Amigos, Trabajo, Universidad y Otro.
- Incorporación de la opción para marcar contactos como favoritos.
- Creación de una sección para visualizar únicamente los contactos favoritos.
- Implementación de búsqueda de contactos.
- Mejoras en el registro, edición y eliminación de contactos.
- Restricción de acceso a los contactos según el usuario que inició sesión.

### Mejoras visuales

- Rediseño de las pantallas de inicio de sesión y registro.
- Mejor organización del panel principal.
- Incorporación de estilos CSS para los formularios y tablas.
- Mejor presentación de los mensajes de confirmación y error.
- Diseño más ordenado, moderno y uniforme en las diferentes secciones.

## 7. Autor

**Proyecto:** Agenda de Contactos

**Desarrollado por:** Kevin Ariel Catagña Pila

**Año:** 2026