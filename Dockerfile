# Gunakan image resmi PHP dengan ekstensi Laravel
FROM php:8.2-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    libzip-dev unzip git && \
    docker-php-ext-install pdo pdo_mysql zip

# Salin semua file ke container
COPY . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev --optimize-autoloader

# Jalankan artisan key:generate
RUN php artisan key:generate || true

# Expose port 10000 (biar Render tahu app-nya di sini)
EXPOSE 10000

# Jalankan Laravel pakai artisan serve
CMD php artisan serve --host=0.0.0.0 --port=10000
