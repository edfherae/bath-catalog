#!/bin/sh

#-e (errexit) — «упасть на первой же ошибке».
#-u (nounset) — «ругаться на необъявленную переменную». $FOO при пустой переменной молча станет пустой строкой. -u превращает это в ошибку — как "use strict" для переменных.
set -eu

cd /var/www/html

# git не доверяет папке, если uid контейнера не совпал с владельцем файлов.
# На Windows это всегда так. || true — чтобы не падать, если не получилось.
git config --global --get-all safe.directory 2>/dev/null | grep -qx /var/www/html \
  || git config --global --add safe.directory /var/www/html

echo "Installing Composer dependencies..."
composer install --no-interaction --prefer-dist

echo "Compiling TypeScript..."
php bin/console typescript:build

echo "Clearing Symfony cache..."
php bin/console cache:clear

echo "Starting PHP-FPM..."
exec "$@"