#!/usr/bin/env bash
echo "Starting Laravel application..."

# Run migrations
php artisan migrate --force

# Start the application
php artisan serve --host=0.0.0.0 --port=$PORT