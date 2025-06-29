#!/bin/bash
set -e

# Clear and cache config
php artisan config:clear
php artisan config:cache

# Run migrations (only if DB is available)
while ! php artisan migrate --force; do
  echo "Database might not be ready yet - retrying in 5 seconds..."
  sleep 5
done

# Start Apache
exec apache2-foreground
