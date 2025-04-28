FROM php:8.2-fpm

WORKDIR /var/www/html

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# Instala Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copia el proyecto
COPY . .

# Instala dependencias de Laravel
RUN composer install --optimize-autoloader --no-dev

# Permisos de storage
RUN chown -R www-data:www-data /var/www/html/storage

# Puerto expuesto
EXPOSE 8000

# Comando para iniciar el servidor
CMD php artisan serve --host=0.0.0.0 --port=8000