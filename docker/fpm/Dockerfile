FROM php:8.1-fpm-alpine

ARG UID=1000
ARG GID=1000

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN apk add --update --no-cache shadow && usermod -u $UID www-data && groupmod -g $GID www-data && apk del shadow \
    && chown www-data:www-data /var/www -R \
    && chmod +x /usr/local/bin/install-php-extensions \
    && install-php-extensions zip pcntl bcmath pdo_mysql \
    && rm -rf /tmp/* /var/tmp/* /usr/share/doc/* /var/cache/apk/* /usr/share/php8 \
    && mkdir /var/www/app && chown www-data:www-data /var/www/app \
;

WORKDIR /var/www/app

VOLUME /var/www/app