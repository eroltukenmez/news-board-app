#!/bin/bash
set -e

if [ -z "$(php artisan key:generate --show)" ]; then
    php artisan key:generate
fi

php artisan migrate
php artisan optimize

exec docker-php-entrypoint php-fpm