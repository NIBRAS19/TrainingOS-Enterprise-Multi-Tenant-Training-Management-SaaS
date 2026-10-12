FROM php:8.4-cli
RUN apt-get update && apt-get install -y git unzip libpq-dev libzip-dev libpng-dev && docker-php-ext-install pdo_pgsql zip gd
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer
WORKDIR /var/www
COPY composer.json ./
RUN composer install --no-interaction --prefer-dist --no-scripts || true
COPY . .
EXPOSE 8000
CMD ["php","artisan","serve","--host=0.0.0.0","--port=8000"]
