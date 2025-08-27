#!/usr/bin/env bash
# build.sh

echo "Running composer install..."
composer install --no-dev --working-dir=/opt/render/project/src --optimize-autoloader

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

echo "Running migrations..."
php artisan migrate --force