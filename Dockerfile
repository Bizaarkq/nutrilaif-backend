FROM php:7.4.3-apache
EXPOSE 80
WORKDIR /app
RUN apt-get update -y && apt-get -y install git zlib1g-dev libpng-dev libzip-dev curl nano
RUN docker-php-ext-install mysqli pdo pdo_mysql gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
COPY . /app
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini "$PHP_INI_DIR/php.ini"
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
RUN  a2enmod rewrite