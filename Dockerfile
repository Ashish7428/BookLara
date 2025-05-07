FROM php:8.2-apache

# Working directory
WORKDIR /var/www/html

# System + PHP dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libzip-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Apache rewrite
RUN a2enmod rewrite

# Composer install
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy Laravel project files
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

EXPOSE 80
