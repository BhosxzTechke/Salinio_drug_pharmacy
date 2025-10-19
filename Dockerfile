# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . .

# Install PHP dependencies
RUN composer install --no-interaction --no-dev --optimize-autoloader

# Install Node.js and build frontend (for Laravel Breeze/Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs && \
    if [ -f package.json ]; then \
        npm install && \
        npm run build; \
    fi

# Set correct permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set Apache DocumentRoot to /public
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Ensure Apache listens on Railway’s dynamic port
RUN echo "Listen ${PORT:-8080}" > /etc/apache2/ports.conf

# Expose Railway port
EXPOSE ${PORT}

# Clear Laravel caches (optional but good for production)
RUN php artisan config:clear && php artisan cache:clear && php artisan view:clear

# Copy and make entrypoint executable
COPY entrypoint.sh /entrypoint.sh
RUN chmod +x /entrypoint.sh

ENTRYPOINT ["/entrypoint.sh"]
