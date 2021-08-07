FROM php:7.4-fpm-alpine

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer

# RUN apt-get update \
# && apt-get install -y \
# wget

RUN apk add autoconf
RUN apk add build-base
RUN pecl install xdebug

COPY ./php.ini /usr/local/etc/php/conf.d/php.ini

WORKDIR /app
COPY . .
RUN composer install

CMD php artisan serve --host=0.0.0.0
