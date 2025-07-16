# Prueba Técnica: ZalvadoraTest - API de Suscripciones

Este repositorio contiene la solución a la prueba técnica para Senior Backend Developer. El objetivo ha sido desarrollar una API RESTful para un sistema de gestión de suscripciones, aplicando principios de **Arquitectura Limpia** y **Diseño Guiado por el Dominio (DDD)**.

---

## 1. Tecnologías y Versiones

El proyecto está construido sobre un stack moderno y completamente dockerizado para garantizar la consistencia y facilidad de despliegue.

* **Framework:** Laravel 12
* **Lenguaje:** PHP 8.4
* **Base de Datos:** MySQL 8.0
* **Entorno:** Docker & Docker Compose
* **Documentación API:** Swagger (OpenAPI)
* **Autenticación:** Laravel Sanctum
* **Testing:** PHPUnit

---

## 2. Filosofía de Arquitectura

La decisión arquitectónica principal fue implementar una **Arquitectura Limpia por Capas**, separando las responsabilidades del sistema para lograr un código desacoplado, mantenible y altamente testeable.

La estructura se divide en tres capas fundamentales dentro de `src/app/`:

### 2.1. Capa de Dominio (`Domain`)
El corazón de la aplicación. Contiene la lógica de negocio pura, sin ninguna dependencia de frameworks o detalles de infraestructura.
* **Entidades:** Clases PHP puras que representan los conceptos de negocio (ej. `Plan`, `Company`, `User`).
* **Interfaces de Repositorio:** Contratos que definen las operaciones de persistencia (ej. `PlanRepositoryInterface`), pero no su implementación.

### 2.2. Capa de Aplicación (`Application`)
El cerebro orquestador. Esta capa no contiene lógica de negocio, sino que coordina el flujo de datos para ejecutar acciones específicas.
* **Casos de Uso (Use Cases):** Clases que representan cada acción que el sistema puede realizar (ej. `RegisterCompanyUseCase`, `ChangeCompanyPlanUseCase`).
* **DTOs (Data Transfer Objects):** Objetos inmutables que transportan datos de manera estructurada entre las capas.

### 2.3. Capa de Infraestructura (`Infrastructure`)
Los detalles técnicos y las implementaciones concretas. Es la capa más externa y depende de las demás.
* **Persistencia:** Implementaciones de los repositorios del dominio utilizando **Eloquent ORM**. Los modelos de Eloquent (ej. `PlanModel`) residen aquí, actuando como un detalle de implementación.
* **Framework:** Contiene los elementos específicos de Laravel como Controladores, `Form Requests`, `API Resources`, Service Providers y Rutas.

Este diseño garantiza que el núcleo del negocio sea independiente de la tecnología, facilitando su evolución y prueba.

---

## 3. Instalación y Puesta en Marcha

El proyecto está completamente dockerizado. Solo necesitas tener **Git** y **Docker Desktop** instalados.

**1. Clonar el Repositorio**
```bash
git clone https://github.com/RikardoBonilla/ZalvadoraTest.git
cd ZalvadoraTest
```

**2. Configurar el Entorno.**

Copia el archivo de entorno de ejemplo.
```bash
cp src/.env.example src/.env
```

**3. Levantar los Contenedores.**

Este comando construirá las imágenes y levantará los servicios de la aplicación, Nginx y MySQL.
```bash
docker-compose up -d --build
```
**4. Instalar Dependencias de PHP.**

Este es un paso crucial. Instala todas las librerías necesarias del proyecto dentro del contenedor.
```bash
docker-compose exec app composer install
```
**5. Generar la Clave de la Aplicación.**

```bash
docker-compose exec app php artisan key:generate
```

**6. Ajusta la conexion a la base de datos.**

```bash
DB_CONNECTION=mysql
DB_HOST=db
DB_PORT=3306
DB_DATABASE=zalvadora_db
DB_USERNAME=root
DB_PASSWORD=root
```

**7. Preparar la Base de Datos.**

Este comando ejecutará todas las migraciones para crear la estructura de la base de datos y luego la poblará con datos de ejemplo (planes, una empresa y un usuario) a través de los seeders.

```bash
docker-compose exec app php artisan migrate:fresh --seed
```
---

## 4. Uso de la API
### 4.1. Documentación Interactiva

La documentación completa de la API, generada con Swagger, está disponible en la siguiente URL una vez que el entorno está levantado:

```bash
http://localhost:8080/api/documentation
```

### 4.2. Autenticación

Los endpoints de gestión de usuarios están protegidos. Para obtener un token de acceso, realiza una petición POST al endpoint de login:


* **Endpoint:** POST /api/v1/login

* **Credenciales de prueba (creadas por el seeder):** email: admin@prueba.com

* **password:** password

La respuesta te proporcionará un token. 

Para acceder a las rutas protegidas, debes incluir este token en la cabecera de tus peticiones:

* **Authorization:** Bearer <TU_TOKEN>

## 5. Ejecución de Pruebas

El proyecto incluye una suite de pruebas inicial para demostrar la metodología. Para ejecutar todas las pruebas, utiliza el siguiente comando:

```bash
docker-compose exec app php artisan test
```

¡Gracias por la oportunidad de realizar esta prueba!