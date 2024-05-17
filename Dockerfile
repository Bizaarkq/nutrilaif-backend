FROM php:7.4.3-apache
# Install dependencies
RUN apt-get update -y && apt-get -y install git zlib1g-dev libpng-dev libzip-dev curl nano
RUN docker-php-ext-install mysqli pdo pdo_mysql gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip
#mod_rewrite
RUN a2enmod rewrite
# Copy source code
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini "$PHP_INI_DIR/php.ini"
# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /app
# Copy source code
COPY . /app

#script to run
RUN chmod +x deploy.sh

#expose port
EXPOSE 80

# run script
CMD ["./deploy.sh"]