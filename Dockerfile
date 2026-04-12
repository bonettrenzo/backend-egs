FROM php:8.4-cli

# Dependencias
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip

# Extensiones PH
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Workdir
WORKDIR /var/www

# Copiar proyecto
COPY . .

# Instalar dependencias
RUN composer install --no-dev --optimize-autoloader

# Permisos (importante)
RUN chmod -R 775 storage bootstrap/cache

# Puerto
EXPOSE 10000

# Arranque
CMD php artisan serve --host=0.0.0.0 --port=${PORT}