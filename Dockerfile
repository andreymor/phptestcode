FROM composer:1 AS composer

FROM php:7.4-fpm

COPY --from=composer /usr/bin/composer /usr/bin/composer

RUN apt-get update -y \
  && apt-get install -y git zip \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean -y
