# 1) Vendor deps with PHP 8.4 (to match your project)
FROM php:8.4-cli AS vendor
WORKDIR /app

RUN apt-get update && apt-get install -y \
    git unzip libpq-dev libzip-dev libonig-dev libxml2-dev \
 && docker-php-ext-install pdo_pgsql pgsql zip mbstring xml \
 && rm -rf /var/lib/apt/lists/*

COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

COPY composer.json composer.lock ./
RUN composer install --no-interaction --prefer-dist --no-scripts

COPY . .
RUN composer dump-autoload --optimize \
 && php artisan package:discover --ansi

# 2) Frontend build (Vite)
FROM node:20-alpine AS frontend
WORKDIR /app
COPY package*.json ./
RUN npm ci
COPY resources resources
COPY public public
COPY vite.config.* postcss.config.* tailwind.config.* ./
RUN npm run build

# 3) Runtime
FROM php:8.4-cli
WORKDIR /var/www

RUN apt-get update && apt-get install -y \
    unzip git libpq-dev libzip-dev \
 && docker-php-ext-install pdo_pgsql pgsql zip \
 && rm -rf /var/lib/apt/lists/*

COPY --from=vendor /app /var/www
COPY --from=frontend /app/public/build /var/www/public/build

RUN chown -R www-data:www-data storage bootstrap/cache || true

EXPOSE 8000

COPY docker/entrypoint.sh /entrypoint.sh
ENTRYPOINT ["/entrypoint.sh"]

CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
