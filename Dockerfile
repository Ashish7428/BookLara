FROM php:8.2-apache

# Set working directory
WORKDIR /var/www/html

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libzip-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Enable Apache rewrite module
RUN a2enmod rewrite

# Handle Apache + Render port binding
ENV PORT=10000
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf \
    && sed -i "s/80/${PORT}/g" /etc/apache2/ports.conf \
    && sed -i "s/:80/:${PORT}/g" /etc/apache2/sites-available/000-default.conf

# Set document root to Laravel public directory
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

# Copy Composer from official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy source code
COPY . .

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader

# Copy .env if available, or assume it's set in Render env
COPY .env.example .env

# Generate APP_KEY only if not already set
RUN php artisan key:generate || true

# Set Laravel storage permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Avoid config caching in build (can fail if env missing)
# We'll cache config in start command

EXPOSE ${PORT}

# Start Apache + Laravel setup in container startup
CMD php artisan config:clear \
    && php artisan config:cache \
    && php artisan migrate --force \
    && apache2-foreground
