FROM php:8.3-fpm

COPY . /usr/local/etc/php/php.ini

WORKDIR /var/www/html

RUN apt-get update \
    && apt-get install -y libpq-dev \
    curl \
    wget \
    git \
    libzip-dev \
    libonig-dev \
    libpng-dev \
    && docker-php-ext-install mbstring pdo pdo_pgsql pgsql zip gd

COPY --from=composer:latest usr/bin/composer /usr/bin/composer

EXPOSE 9000