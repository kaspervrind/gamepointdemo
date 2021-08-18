FROM composer:latest AS php_dependencies

WORKDIR /app/

COPY composer.json composer.lock* /app/

RUN composer install \
    --ignore-platform-reqs \
    --no-interaction \
    --no-plugins \
    --prefer-dist \
    --no-dev \
    --classmap-authoritative

COPY . .

RUN composer dump-autoload \
    --no-scripts \
    --optimize \
    --no-dev \
    --no-interaction \
    --no-plugins \
    --classmap-authoritative

FROM php:8.0-apache AS development

ENV USER=daemon
ENV GROUP=daemon
ENV APACHE_DOCUMENT_ROOT=/app/public
ENV APACHE_PORT=80

#RUN docker-php-ext-install soap opcache
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

COPY --from=php_dependencies /app/vendor/ /app/vendor/
COPY . /app

RUN chown -R $USER:$GROUP $APACHE_DOCUMENT_ROOT

RUN sed -ri -e 's!Listen 80!Listen ${APACHE_PORT}!g' /etc/apache2/ports.conf \
    && sed -ri -e 's!:80!:${APACHE_PORT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

USER $USER

EXPOSE $APACHE_PORT

FROM development AS production

COPY docker/php/production.ini $PHP_INI_DIR/conf.d/mijnoverheid.ini
