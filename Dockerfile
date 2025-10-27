# ------------------------------------------------------
# 1️⃣ Base Image
# ------------------------------------------------------
FROM php:8.2-cli

# ------------------------------------------------------
# 2️⃣ System dependencies
# ------------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    zip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libsodium-dev \
    libpq-dev \
    default-mysql-client \
    default-libmysqlclient-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_pgsql pdo_mysql mbstring exif pcntl bcmath gd zip sodium \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ------------------------------------------------------
# 3️⃣ Composer
# ------------------------------------------------------
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# ------------------------------------------------------
# 4️⃣ Node.js + npm
# ------------------------------------------------------
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g npm@latest \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# ------------------------------------------------------
# 5️⃣ App directory
# ------------------------------------------------------
WORKDIR /var/www/html

# Copy package files first (better cache)
COPY package*.json ./

# Install frontend dependencies
RUN npm install

# Copy the rest of the project
COPY . .

# Build Tailwind / Mix / Vite (production mode)
RUN npm run production

# ------------------------------------------------------
# 6️⃣ Install Laravel dependencies
# ------------------------------------------------------
RUN COMPOSER_ALLOW_SUPERUSER=1 composer install --no-dev --optimize-autoloader

# ------------------------------------------------------
# 7️⃣ Laravel setup (clear caches)
# ------------------------------------------------------
RUN php artisan config:clear || true \
 && php artisan cache:clear || true \
 && php artisan route:clear || true \
 && php artisan view:clear || true \
 && php artisan permission:cache-reset || true \
 && rm -f bootstrap/cache/config.php

# ------------------------------------------------------
# 8️⃣ File permissions
# ------------------------------------------------------
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# ------------------------------------------------------
# 9️⃣ Expose port
# ------------------------------------------------------
EXPOSE 8080

# ------------------------------------------------------
# 🔟 Start server
# ------------------------------------------------------
CMD ["sh", "-c", "php artisan config:clear && php artisan serve --host=0.0.0.0 --port=8080 & php artisan schedule:work"]
