# Usar una imagen oficial de PHP 8.4 con FPM
FROM php:8.4-fpm-alpine

# Argumentos para el ID de usuario y grupo que pasaremos desde docker-compose
ARG USER_ID
ARG GROUP_ID

# Instalar dependencias del sistema y extensiones de PHP
RUN apk add --no-cache \
    libzip-dev \
    zip \
    && docker-php-ext-install pdo pdo_mysql zip

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear un grupo y un usuario con los IDs de nuestro sistema anfitrión
RUN addgroup -g ${GROUP_ID} docker-group && \
    adduser -u ${USER_ID} -G docker-group -s /bin/sh -D docker-user

# Cambiar al nuevo usuario
USER docker-user

# Establecer el directorio de trabajo
WORKDIR /var/www/html