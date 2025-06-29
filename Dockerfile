FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libzip-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set Apache to use dynamic port from Render
ENV PORT 10000
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
    && sed -i "s|<VirtualHost \*:80>|<VirtualHost *:${PORT}>|g" /etc/apache2/sites-available/000-default.conf \
    && sed -ri -e "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Optional: Copy .env if you don’t set variables in Render Dashboard
COPY .env.example .env

# Generate APP_KEY safely
RUN php artisan key:generate || true

# Set Laravel folder permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Expose Render's dynamic port
EXPOSE ${PORT}

# Start Laravel & Apache server
CMD php artisan config:clear \
    && php artisan config:cache \
    && php artisan migrate --force \
    && apache2-foreground
