#!/usr/bin/env bash
echo "Running composer"
composer global require hirak/prestissimo
composer install --no-dev --working-dir=/var/www/html

echo "Caching config..."
php artisan config:cache

echo "Caching routes..."
php artisan route:cache

php artisan key:generate --show

echo "Running migrations..."
php artisan migrate
php artisan passport:install
php artisan passport:client --personal