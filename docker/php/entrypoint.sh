#!/bin/sh
set -e

if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --optimize-autoloader
fi

echo "Compiling TypeScript..."
php bin/console typescript:build

echo "Clearing Symfony cache..."
php bin/console cache:clear

echo "Starting PHP-FPM..."
exec "$@"