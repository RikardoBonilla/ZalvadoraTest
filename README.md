# Prueba Técnica: ZalvadoraTest - API de Suscripciones

Este repositorio contiene la solución a la prueba técnica para Senior Backend Developer. El objetivo ha sido desarrollar una API RESTful para un sistema de gestión de suscripciones, aplicando principios de **Arquitectura Limpia** y **Diseño Guiado por el Dominio (DDD)**.

---

## 1. Tecnologías y Versiones

* **Framework:** Laravel 12
* **Lenguaje:** PHP 8.4
* **Base de Datos:** MySQL 8.0
* **Entorno:** Docker & Docker Compose
* **Documentación API:** Swagger (OpenAPI)
* **Autenticación:** Laravel Sanctum
* **Testing:** PHPUnit

---

## 2. Filosofía de Arquitectura

La aplicación sigue una Arquitectura Limpia por Capas para garantizar que el código sea desacoplado, mantenible y altamente testeable.

* **Capa de Dominio (`Domain`):** Contiene la lógica de negocio pura (Entidades, Interfaces de Repositorio). Es el núcleo de la aplicación.
* **Capa de Aplicación (`Application`):** Orquesta los flujos de trabajo a través de Casos de Uso y DTOs, sin contener lógica de negocio.
* **Capa de Infraestructura (`Infrastructure`):** Contiene los detalles de implementación como los controladores de Laravel, los modelos de Eloquent y las implementaciones concretas de los repositorios.

---

## 3. Instalación y Puesta en Marcha

El proyecto está completamente dockerizado. Solo necesitas tener **Git** y **Docker Desktop** instalados. Sigue estos pasos en orden exacto.

**1. Clonar el Repositorio**
```bash
git clone [https://github.com/RikardoBonilla/ZalvadoraTest.git](https://github.com/RikardoBonilla/ZalvadoraTest.git)
cd ZalvadoraTest
```

**2. Copiar el Archivo de Entorno**
Crea tu propio archivo de configuración de entorno a partir del ejemplo.
```bash
cp src/.env.example src/.env
```

**3. Ajustar la Conexión a la Base de Datos**
Este es un paso **crítico**. Abre el archivo `src/.env` que acabas de crear en un editor de texto y **reemplaza** las siguientes variables de `DB_` para que apunten a nuestro contenedor de Docker:

```env
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=zalvadora_db
DB_USERNAME=root
DB_PASSWORD=root
```

**4. Levantar los Contenedores de Docker**
Este comando construirá y levantará los servicios de la aplicación, Nginx y MySQL.
```bash
docker-compose up -d --build
```

**5. Instalar Dependencias de PHP**
Instala todas las librerías del proyecto (el contenido de la carpeta `vendor/`) dentro del contenedor.
```bash
docker-compose exec app composer install
```

**6. Corregir Permisos**
Para evitar errores de escritura de logs y caché, asigna los permisos correctos a las carpetas de Laravel.
```bash
docker-compose exec app chown -R www-data:www-data storage bootstrap/cache
docker-compose exec app chmod -R 775 storage bootstrap/cache
```

**7. Generar la Clave de la Aplicación**
```bash
docker-compose exec app php artisan key:generate
```

**8. Preparar la Base de Datos**
Este comando borra las tablas, las vuelve a crear según las migraciones y las puebla con datos de ejemplo.
```bash
docker-compose exec app php artisan migrate:fresh --seed
```

¡Listo! La aplicación ya está corriendo y configurada correctamente.

---

## 4. Uso de la API

### 4.1. Documentación Interactiva
La documentación completa de la API, generada con Swagger, está disponible en:

**http://localhost:8080/api/documentation**

### 4.2. Autenticación
Para probar los endpoints protegidos, primero obtén un token de API:

* **Endpoint:** `POST /api/v1/login`
* **Credenciales de prueba:**
    * `email`: `admin@prueba.com`
    * `password`: `password`

Incluye el token recibido en la cabecera `Authorization` de tus siguientes peticiones: `Authorization: Bearer <TU_TOKEN>`

---

## 5. Ejecución de Pruebas

Para ejecutar la suite de pruebas automatizadas, usa el siguiente comando:

```bash
docker-compose exec app php artisan test
```
