FROM php:8.2-apache

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libzip-dev libxml2-dev \
    && docker-php-ext-install pdo pdo_mysql zip gd

RUN a2enmod rewrite
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
RUN echo "Listen 0.0.0.0:80" >> /etc/apache2/ports.conf

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY . .

RUN composer install --no-dev --optimize-autoloader

# Set Laravel permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Clear and cache config
RUN php artisan config:clear && php artisan config:cache

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80
