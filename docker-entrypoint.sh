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

# Update trending books cache on container start
php artisan books:update-trending

# Start queue worker in background
php artisan queue:work --tries=3 &

# Start scheduler in background
php artisan schedule:work &

# Start Apache in foreground
exec apache2-foreground
