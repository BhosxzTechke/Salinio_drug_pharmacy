# Use PHP 8.2 with Apache
FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install dependencies and PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev zip curl nodejs npm \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd \
    && a2enmod rewrite

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy all project files
COPY . .

# Install PHP dependencies (Laravel)
RUN composer install --no-dev --no-interaction --optimize-autoloader

# Install Node dependencies and build assets (if package.json exists)
RUN if [ -f package.json ]; then npm install && npm run build; fi

# Set correct permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Set Apache document root to /public
RUN sed -i 's|DocumentRoot /var/www/html|DocumentRoot /var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Fix "ServerName" warning
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Expose the port (Railway will replace this automatically)
EXPOSE 8080

# Clear Laravel cache
RUN php artisan config:clear && php artisan cache:clear && php artisan view:clear

# Start Apache in foreground
CMD ["apache2-foreground"]
