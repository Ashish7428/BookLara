FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies & PHP extensions
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libzip-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Set Laravel public directory as document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update Apache config for document root
RUN sed -ri "s!/var/www/html!${APACHE_DOCUMENT_ROOT}!g" /etc/apache2/sites-available/000-default.conf

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy app code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy .env (optional: you can skip if set in Render environment)
COPY .env.example .env

# Generate APP_KEY
RUN php artisan key:generate || true

# Fix folder permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Tell Apache to listen on the dynamic Render PORT
ENV PORT 8080
EXPOSE ${PORT}

# Replace Apache listen directives to use 0.0.0.0:${PORT}
RUN sed -i "s|Listen 80|Listen 0.0.0.0:${PORT}|" /etc/apache2/ports.conf \
    && sed -i "s|<VirtualHost \*:80>|<VirtualHost 0.0.0.0:${PORT}>|" /etc/apache2/sites-available/000-default.conf

# Final startup command
CMD php artisan config:clear \
 && php artisan config:cache \
 && php artisan migrate --force \
 && apache2-foreground
