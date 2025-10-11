FROM php:8.2-fpm

RUN apt-get update \
    && apt-get install -y \
        git curl libpng-dev libonig-dev libxml2-dev zip unzip \
    && docker-php-ext-install pdo_mysql mbstring gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY . /var/www

RUN cp .env.example .env \
    && composer install --no-interaction --prefer-dist --no-progress \
    && php artisan key:generate --force \
    && chown -R www-data:www-data /var/www \
    && find /var/www -type f -exec chmod 664 {} \; \
    && find /var/www -type d -exec chmod 775 {} \;

EXPOSE 9000

CMD ["php-fpm"]
