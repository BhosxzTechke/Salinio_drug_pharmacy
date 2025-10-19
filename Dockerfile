# Use PHP CLI version (no Apache)
FROM php:8.2-cli

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git unzip nodejs npm libzip-dev libpng-dev libonig-dev libxml2-dev zip curl \
    && docker-php-ext-install pdo_mysql mbstring zip exif pcntl bcmath gd

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY . .

# ✅ Install Composer packages
RUN composer install --optimize-autoloader --no-dev --no-interaction

# ✅ Install Node packages
RUN npm install

# ✅ This ensures Bootstrap/Tailwind are compiled before running Laravel
RUN npm run build || npm run production

# ✅ Fix folder permissions
RUN chmod -R 775 storage bootstrap/cache

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000
