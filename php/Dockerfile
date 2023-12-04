FROM php:8.1-fpm-alpine

COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN set -eux; \
    install-php-extensions pdo pdo_mysql xdebug

ENV XDEBUG_MODE=debug,trace,develop
COPY ./php/conf.d/xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini
