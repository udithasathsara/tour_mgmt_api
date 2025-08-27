#!/usr/bin/env bash
echo "Starting build process..."

# Install dependencies
composer install --no-dev --optimize-autoloader

# Generate app key if not exists
if [ ! -f ".env" ]; then
    cp .env.example .env
fi

# Clear and cache config
php artisan config:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Build completed successfully!"