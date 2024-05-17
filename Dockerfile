FROM php:7.4.3-apache

# Install dependencies
RUN apt-get update -y && apt-get -y install git zlib1g-dev libpng-dev libzip-dev curl nano
RUN docker-php-ext-install mysqli pdo pdo_mysql gd \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip

# Enable mod_rewrite
RUN a2enmod rewrite

# Copy Apache configuration and PHP configuration
COPY vhost.conf /etc/apache2/sites-available/000-default.conf
COPY php.ini "$PHP_INI_DIR/php.ini"

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer

# Set working directory
WORKDIR /app

# Copy source code
COPY . /app

# Ensure deploy.sh is executable
RUN chmod +x /app/deploy.sh

# Expose port
EXPOSE 80

# Start Apache in the foreground
CMD ["apache2-foreground"]
