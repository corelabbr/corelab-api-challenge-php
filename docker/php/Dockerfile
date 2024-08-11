FROM php:8.2-fpm

RUN apt-get update && apt-get install -y \
    zip \
    unzip \
    git \
    libpq-dev \
    && docker-php-ext-install pdo_pgsql

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY ../. .


RUN chown -R www-data:www-data /var/www
