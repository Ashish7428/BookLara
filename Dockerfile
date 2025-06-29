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

# Fix folder permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Configure for Render's dynamic port (use 8080 or 10000)
ARG PORT=8080
ENV PORT $PORT
EXPOSE $PORT

# Update Apache configuration for port
RUN echo "Listen $PORT" > /etc/apache2/ports.conf && \
    sed -i "s/:80/:$PORT/" /etc/apache2/sites-available/000-default.conf && \
    sed -i "s/<VirtualHost \*:80>/<VirtualHost \*:$PORT>/" /etc/apache2/sites-available/000-default.conf


# ... (keep your existing Dockerfile content)

# Configure Apache for Render
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf && \
    echo "Listen 0.0.0.0:${PORT}" >> /etc/apache2/ports.conf && \
    sed -i "s/<VirtualHost \*:${PORT}>/<VirtualHost 0.0.0.0:${PORT}>/" /etc/apache2/sites-available/000-default.conf

# ... (rest of your Dockerfile)

# Health check (optional but recommended)
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost:$PORT/ || exit 1

# Final startup command (split into a script for better error handling)
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["docker-entrypoint.sh"]
