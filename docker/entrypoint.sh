#!/bin/sh
set -e

mkdir -p storage/framework/views storage/framework/cache/data storage/framework/sessions bootstrap/cache
chmod -R 775 storage bootstrap/cache || true

php artisan package:discover --ansi || true

exec "$@"
