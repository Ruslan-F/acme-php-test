# syntax=docker/dockerfile:1

FROM composer:lts as composer-deps
WORKDIR /App
RUN --mount=type=bind,source=./composer.json,target=composer.json \
    --mount=type=bind,source=./composer.lock,target=composer.lock \
    --mount=type=cache,target=/tmp/cache \
    composer install --no-interaction

FROM php:8.2-apache as base
COPY App /var/www/html/App
COPY ./index.php /var/www/html/index.php
COPY --from=composer-deps App/vendor/ /var/www/html/vendor
COPY --from=composer-deps /usr/bin/composer /usr/bin/composer

FROM base as development
RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"

FROM development as test
WORKDIR /var/www/html
COPY ./Tests /var/www/html/Tests
RUN ./vendor/bin/phpunit ./Tests/IndexTest.php