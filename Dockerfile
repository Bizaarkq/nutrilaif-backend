FROM php:7.4.3-apache as build
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer
WORKDIR /app
RUN apt-get update -y && apt-get -y install git zlib1g-dev libpng-dev libzip-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
RUN composer config -g repo.packagist composer https://repo.packagist.org
COPY . /app
RUN composer install \
    --no-interaction

FROM php:7.4.3-apache as app
EXPOSE 80
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini "$PHP_INI_DIR/php.ini"
RUN docker-php-ext-install mysqli pdo pdo_mysql && a2enmod rewrite
COPY --from=build --chown=www-data:www-data /app /app
