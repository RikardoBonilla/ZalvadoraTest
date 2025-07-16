======================================================================
  Prueba Técnica: ZalvadoraTest - API de Suscripciones
======================================================================

Este repositorio contiene la solución a la prueba técnica para Senior Backend Developer. El objetivo ha sido desarrollar una API RESTful para un sistema de gestión de suscripciones, aplicando principios de Arquitectura Limpia y Diseño Guiado por el Dominio (DDD).

---
1. TECNOLOGÍAS Y VERSIONES
---

El proyecto está construido sobre un stack moderno y completamente dockerizado para garantizar la consistencia y facilidad de despliegue.

- Framework: Laravel 12
- Lenguaje: PHP 8.4
- Base de Datos: MySQL 8.0
- Entorno: Docker & Docker Compose
- Documentación API: Swagger (OpenAPI)
- Autenticación: Laravel Sanctum
- Testing: PHPUnit

---
2. FILOSOFÍA DE ARQUITECTURA
---

La decisión arquitectónica principal fue implementar una Arquitectura Limpia por Capas, separando las responsabilidades del sistema para lograr un código desacoplado, mantenible y altamente testeable.

La estructura se divide en tres capas fundamentales dentro de `src/app/`:

  2.1. Capa de Dominio (`Domain`)
  El núcleo absoluto. Aquí viven las reglas de negocio puras, sin ninguna dependencia de frameworks o detalles de infraestructura.
  - Entidades: Clases PHP puras que representan los conceptos de negocio (ej. Plan, Company, User).
  - Interfaces de Repositorio: Contratos que definen las operaciones de persistencia (ej. PlanRepositoryInterface), pero no su implementación.

  2.2. Capa de Aplicación (`Application`)
  El cerebro orquestador. Esta capa no contiene lógica de negocio, sino que coordina el flujo de datos para ejecutar acciones específicas.
  - Casos de Uso (Use Cases): Clases que representan cada acción que el sistema puede realizar (ej. RegisterCompanyUseCase).
  - DTOs (Data Transfer Objects): Objetos inmutables que transportan datos de manera estructurada entre las capas.

  2.3. Capa de Infraestructura (`Infrastructure`)
  Los detalles técnicos y las implementaciones concretas. Es la capa más externa y depende de las demás.
  - Persistencia: Implementaciones de los repositorios del dominio utilizando Eloquent ORM.
  - Framework: Contiene los elementos específicos de Laravel como Controladores, Form Requests, API Resources, etc.

Este diseño garantiza que el núcleo del negocio sea independiente de la tecnología, facilitando su evolución y prueba.

---
3. INSTALACIÓN Y PUESTA EN MARCHA
---

El proyecto está completamente dockerizado. Solo necesitas tener Git y Docker Desktop instalados.

  1. Clonar el Repositorio
     git clone <URL_DEL_REPOSITORIO>
     cd ZalvadoraTest

  2. Configurar el Entorno
     Copia el archivo de entorno de ejemplo.
     cp src/.env.example src/.env

  3. Levantar los Contenedores
     Este comando construirá las imágenes y levantará los servicios.
     docker-compose up -d --build

  4. Generar la Clave de la Aplicación
     docker-compose exec app php artisan key:generate

  5. Preparar la Base de Datos
     Este comando ejecutará las migraciones y poblará la base de datos con datos de ejemplo.
     docker-compose exec app php artisan migrate:fresh --seed

¡Listo! La aplicación ya está corriendo.

---
4. USO DE LA API
---

  4.1. Documentación Interactiva
  La documentación completa de la API, generada con Swagger, está disponible en la siguiente URL:
  URL: http://localhost:8080/api/documentation

  4.2. Autenticación
  Los endpoints de gestión de usuarios están protegidos. Para obtener un token de acceso, realiza una petición POST al endpoint de login:

  - Endpoint: POST /api/v1/login
  - Credenciales de prueba (creadas por el seeder):
    - email: admin@prueba.com
    - password: password

  La respuesta te proporcionará un token. Para acceder a las rutas protegidas, debes incluir este token en la cabecera de tus peticiones:
  Authorization: Bearer <TU_TOKEN>

---
5. EJECUCIÓN DE PRUEBAS
---

El proyecto incluye una suite de pruebas inicial. Para ejecutar todas las pruebas, utiliza el siguiente comando:

  docker-compose exec app php artisan test

---

¡Gracias por la oportunidad de realizar esta prueba!
