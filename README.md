# MaxExpress PostgREST

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![PostgreSQL](https://img.shields.io/badge/PostgreSQL-4169E1?style=for-the-badge&logo=postgresql&logoColor=white)
![PostgREST](https://img.shields.io/badge/PostgREST-FF4F00?style=for-the-badge)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![Vite](https://img.shields.io/badge/Vite-646CFF?style=for-the-badge&logo=vite&logoColor=white)

---

Aplicación web desarrollada con Laravel y PostgREST como parte de un proyecto de aprendizaje de Clean Architecture. El proyecto quedó inconcluso por decisión del cliente, pero representa un importante ejercicio de arquitectura de software.

---

## Descripción General

MaxExpress PostgREST es una aplicación web que combina Laravel como framework backend con PostgREST como capa API para interactuar con PostgreSQL. El proyecto fue desarrollado para explorar la implementación de Clean Architecture en un entorno de producción, aunque finalmente no fue completado.

El repositorio muestra la estructura inicial de un proyecto Laravel con integración PostgREST, incluyendo configuración de Tailwind CSS y Vite para el frontend.

---

## Stack Tecnológico

| Tecnología | Versión | Propósito |
|------------|---------|-----------|
| **Laravel** | - | Framework PHP para backend |
| **PHP** | - | Lenguaje de programación |
| **PostgreSQL** | - | Base de datos relacional |
| **PostgREST** | - | API REST sobre PostgreSQL |
| **Tailwind CSS** | - | Framework CSS para diseño |
| **Vite** | - | Bundler para assets |
| **Composer** | - | Gestor de dependencias PHP |
| **NPM** | - | Gestor de dependencias JavaScript |

---

## Estructura del Proyecto

```
MaxExpressPostgrest/
├── app/                    # Código fuente de Laravel
│   ├── Console/            # Comandos Artisan
│   ├── Exceptions/         # Manejo de excepciones
│   ├── Http/               # Controladores y middleware
│   │   ├── Controllers/    # Controladores de la aplicación
│   │   └── Middleware/     # Middleware HTTP
│   ├── Models/             # Modelos Eloquent
│   └── Providers/          # Proveedores de servicios
├── bootstrap/              # Arranque de la aplicación
├── config/                 # Configuración de Laravel
├── database/               # Migraciones y seeds
│   ├── migrations/         # Esquema de base de datos
│   └── seeders/            # Datos de prueba
├── public/                 # Archivos públicos (index.php, assets)
├── resources/              # Vistas y assets
│   ├── css/                # Estilos (Tailwind)
│   ├── js/                 # JavaScript (Vite)
│   └── views/              # Plantillas Blade
├── routes/                 # Definición de rutas
│   ├── api.php             # Rutas API
│   ├── web.php             # Rutas web
│   └── console.php         # Rutas de consola
├── storage/                # Archivos generados
├── tests/                  # Pruebas unitarias y de integración
├── .env.example            # Variables de entorno de ejemplo
├── artisan                 # CLI de Laravel
├── composer.json           # Dependencias PHP
├── composer.lock           # Bloqueo de dependencias PHP
├── package.json            # Dependencias Node.js
├── postcss.config.js       # Configuración de PostCSS
├── tailwind.config.js      # Configuración de Tailwind
├── vite.config.js          # Configuración de Vite
└── ...
```

---

## Clean Architecture Implementada

El proyecto buscaba implementar **Clean Architecture** con la siguiente separación de capas:

### 1. Capa de Presentación (Presentation)
- **Vistas Blade**: Interfaz de usuario
- **Controladores**: Manejo de peticiones HTTP
- **Tailwind CSS**: Estilos y diseño

### 2. Capa de Dominio (Domain)
- **Modelos Eloquent**: Entidades y lógica de negocio
- **Reglas de negocio**: Validaciones y comportamientos

### 3. Capa de Datos (Data)
- **Migraciones**: Estructura de base de datos
- **PostgREST**: API REST sobre PostgreSQL
- **Repositorios**: Abstracción de acceso a datos

### 4. Capa de Infraestructura (Infrastructure)
- **PostgreSQL**: Base de datos
- **PostgREST**: Capa API
- **Servicios externos**: Integraciones

### Flujo de Datos Propuesto

```
Usuario (Navegador)
       |
       v
Vista Blade (Tailwind CSS)
       |
       v
Controlador Laravel
       |
       v
Modelo / Repositorio
       |
       +------------------+
       |                  |
       v                  v
   PostgREST          PostgreSQL
   (API)              (Database)
```

---

## Funcionalidades Planeadas

El proyecto estaba orientado a la gestión de expresos y envíos, con funcionalidades como:

- Gestión de envíos
- Seguimiento de paquetes
- Administración de clientes
- Gestión de rutas
- Reportes y estadísticas

(Nota: El proyecto no fue completado, por lo que estas funcionalidades no están implementadas)

---

## Aprendizajes

Este proyecto, aunque inconcluso, permitió adquirir experiencia en:

- **Clean Architecture**: Separación de responsabilidades y desacoplamiento
- **Laravel**: Framework PHP para aplicaciones web
- **PostgREST**: API REST sobre PostgreSQL
- **Integración de tecnologías**: Laravel + PostgREST + PostgreSQL
- **Frontend moderno**: Tailwind CSS + Vite
- **Estructura de proyectos**: Organización según estándares de Laravel
- **Gestión de dependencias**: Composer y NPM

---

## Estado Actual

Actualmente el proyecto:

- No está completo ni desplegado
- Fue abandonado por decisión del cliente
- Representa un ejercicio de aprendizaje de Clean Architecture
- El código puede descargarse y revisarse
- Muestra la estructura inicial de un proyecto Laravel con PostgREST

---

## Repositorio

[https://github.com/Gerson-dev11/MaxExpressPostgrest](https://github.com/Gerson-dev11/MaxExpressPostgrest)
