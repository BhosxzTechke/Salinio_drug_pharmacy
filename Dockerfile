# Use official PHP image
FROM php:8.2

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    nodejs \
    npm \
    libzip-dev \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy all project files into container
COPY . .

# Install PHP dependencies
RUN composer install --optimize-autoloader --no-dev --no-interaction

# Install Node dependencies and build assets
RUN npm install && npm run build

# Ensure Laravel has writable folders
RUN chmod -R 775 storage bootstrap/cache

# Expose port 8000 for php artisan serve
EXPOSE 8000

# Run database migrations automatically (optional)
# You can comment this line if you don’t want it to run every start
CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
