FROM php:8.2-fpm

RUN apt-get update && apt-get install -y git\
    build-essential \
    libzip-dev \
    libonig-dev \
    zip \
    curl \
    nginx \
    -y wget

RUN docker-php-ext-install mbstring zip exif pcntl

RUN wget https://phar.phpunit.de/phpunit.phar \
    && chmod +x phpunit.phar \
    && mv phpunit.phar /usr/local/bin/phpunit

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www