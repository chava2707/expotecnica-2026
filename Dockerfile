# syntax=docker/dockerfile:1

# ============================================================
# Etapa 1: dependencias PHP (Composer)
# ============================================================
FROM composer:2 AS vendor
WORKDIR /app

COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --no-autoloader --no-interaction --prefer-dist

COPY . .
RUN composer install --no-dev --no-scripts --optimize-autoloader --no-interaction --prefer-dist

# ============================================================
# Etapa 2: frontend (Vite / Tailwind)
# ============================================================
FROM node:22-alpine AS frontend
WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci

COPY . .
RUN npm run build

# ============================================================
# Etapa 3: imagen final (PHP 8.3 + Apache)
# ============================================================
FROM php:8.4.1-apache

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        unzip \
        libpng-dev \
        libjpeg-dev \
        libfreetype6-dev \
        libzip-dev \
        libicu-dev \
        libonig-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j"$(nproc)" \
        gd \
        pdo_mysql \
        mbstring \
        zip \
        bcmath \
        intl \
        exif \
        opcache \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Configuracion PHP para produccion (subida de PDFs/imagenes de proyectos)
RUN { \
        echo 'upload_max_filesize=64M'; \
        echo 'post_max_size=70M'; \
        echo 'memory_limit=512M'; \
        echo 'max_execution_time=120'; \
        echo 'opcache.enable=1'; \
        echo 'opcache.validate_timestamps=0'; \
    } > /usr/local/etc/php/conf.d/expo.ini

# Apache: document root = public/ y soporte de .htaccess (rutas de Laravel)
COPY docker/apache-site.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite headers

WORKDIR /var/www/html

COPY --from=vendor /app/vendor ./vendor
COPY --from=frontend /app/public/build ./public/build
COPY . .

# Permisos y descubrimiento de paquetes de Laravel
# (se borran las cachés locales para evitar providers de paquetes de desarrollo)
RUN chown -R www-data:www-data storage bootstrap/cache \
    && rm -f bootstrap/cache/packages.php bootstrap/cache/services.php \
    && php artisan package:discover --ansi

COPY docker/entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh \
    && sed -i 's/\r$//' /usr/local/bin/entrypoint.sh

EXPOSE 80

ENTRYPOINT ["entrypoint.sh"]
CMD ["apache2-foreground"]
