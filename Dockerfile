FROM php:8.2-fpm

# Instalar dependencias del sistema
RUN apt-get update && apt-get install -y \
    libpq-dev zip unzip git curl libpng-dev libonig-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Configurar PHP
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

# Instalar Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Crear usuario para la aplicación
RUN groupadd -g 1000 www
RUN useradd -u 1000 -ms /bin/bash -g www www

# Cambiar al usuario www
USER www

WORKDIR /var/www/html

# Copiar composer files
COPY --chown=www:www composer.json composer.lock ./

# Instalar dependencias
RUN composer install --no-interaction --prefer-dist --no-scripts --no-autoloader

# Copiar aplicación
COPY --chown=www:www . .

# Optimizar autoload
RUN composer dump-autoload --optimize

EXPOSE 9000
CMD ["php-fpm"]