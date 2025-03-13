FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpq-dev \  
    libzip-dev \
    unzip \
    curl \
    git \
    && docker-php-ext-install zip pdo pdo_pgsql  # Instalando os drivers do PostgreSQL

# Install Node.js 18.x
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash -
RUN apt-get install -y nodejs

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www

# Copy ONLY Composer files first
COPY composer.json ./

# Install PHP dependencies (optimized layer caching)
RUN composer install --no-interaction --no-scripts

# Copy the rest of the application files
COPY . .

# Install PHP dependencies properly
RUN composer install --no-interaction && \
    composer dump-autoload --optimize

# Node.js dependencies
RUN npm install --force && \
    npm run build

# Expose ports
EXPOSE 8000 5173

# Start commands
CMD ["sh", "-c", "php artisan serve --host=0.0.0.0 --port=8000 & npm run dev"]
