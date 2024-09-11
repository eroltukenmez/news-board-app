#!/bin/bash
set -e

chown -R www-data:www-data /var/www/storage
chmod -R 775 /var/www/storage

php artisan migrate --force
php artisan optimize

exec docker-php-entrypoint php-fpm
