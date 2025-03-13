FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \  
    libzip-dev \
    unzip \
    curl \
    git \
    && docker-php-ext-install zip pdo pdo_pgsql

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

COPY composer.json ./

RUN composer install --no-interaction --no-scripts

COPY . .

RUN composer install --no-interaction && \
    composer dump-autoload --optimize

RUN npm install --force && \
    npm run build

EXPOSE 8000 5173

CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"]
