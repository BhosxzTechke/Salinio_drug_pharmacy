# Use PHP CLI version (no Apache)
FROM php:8.2-cli

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip nodejs npm libzip-dev libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Install Node dependencies and build assets
RUN npm install && npm run build

# Make storage & cache writable
RUN chmod -R 775 storage bootstrap/cache

# Expose Laravel's default port
EXPOSE 8000

# Run Laravel when the container starts
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
