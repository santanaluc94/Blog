FROM php:8.1-fpm

RUN apt-get update -y && apt-get upgrade -y

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=2.5.5

RUN pecl install xdebug && docker-php-ext-enable xdebug