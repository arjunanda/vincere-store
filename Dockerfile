# ============================================================
# COPYRIGHT NOTICE
# This code is proprietary and the sole property of Arjunanda.
# Unauthorized use, copying, or distribution is strictly prohibited 
# without explicit written permission from the owner.
# Copyright (c) 2026 Arjunanda.
# ============================================================
# Stage 1: Node.js - Build frontend assets
# ============================================================
FROM node:22-alpine AS frontend

WORKDIR /app

COPY package*.json ./
RUN npm ci

COPY resources/ ./resources/
COPY vite.config.js ./
COPY public/ ./public/

RUN npm run build

# ============================================================
# Stage 2: Composer - Install PHP dependencies
# ============================================================
FROM composer:2.8 AS composer

WORKDIR /app

COPY composer.json composer.lock ./

RUN composer install \
    --no-dev \
    --no-scripts \
    --no-autoloader \
    --no-interaction \
    --prefer-dist

COPY . .

RUN composer dump-autoload --optimize --no-dev --no-scripts

# ============================================================
# Stage 3: Production - FrankenPHP + Laravel Octane
# ============================================================
FROM dunglas/frankenphp:1-php8.3 AS production

LABEL maintainer="Ventuz Store"

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y --no-install-recommends \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libgd-dev \
    libpq-dev \
    zip \
    unzip \
    supervisor \
    netcat-openbsd \
    && docker-php-ext-install \
        pdo \
        pdo_pgsql \
        pgsql \
        mbstring \
        exif \
        pcntl \
        bcmath \
        gd \
        zip \
        opcache \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2.8 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy PHP configs
COPY docker/php/php.ini /usr/local/etc/php/conf.d/99-app.ini
COPY docker/php/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

# Copy FrankenPHP (Caddyfile)
COPY docker/Caddyfile /etc/caddy/Caddyfile

# Copy Supervisor configs
COPY docker/supervisor/supervisord.conf /etc/supervisor/conf.d/supervisord.conf

# Copy app from builder stages
COPY --from=composer /app /var/www/html
COPY --from=frontend /app/public/build /var/www/html/public/build

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# Ensure storage directories exist
RUN mkdir -p /var/www/html/storage/app/public

# Expose ports
# 8000 = Octane HTTP, 8080 = Reverb WebSocket
EXPOSE 8000 8080

COPY docker/entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
