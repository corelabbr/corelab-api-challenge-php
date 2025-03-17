FROM php:8.1-fpm

# Instala dependências
RUN apt-get update && apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev zip git && \
    docker-php-ext-configure gd --with-freetype --with-jpeg && \
    docker-php-ext-install gd pdo pdo_mysql

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define o diretório de trabalho
WORKDIR /var/www

# Copia o código do Laravel
COPY . .

# Instala as dependências do Laravel
RUN composer install

EXPOSE 9000
CMD ["php-fpm"]
