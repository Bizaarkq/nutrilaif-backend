#!/bin/bash

# Debug: Verify this script has execute permissions
if [ ! -x "$0" ]; then
    echo "Error: $0 does not have execute permissions."
    exit 1
fi

# Set verbose mode to see all commands being executed
set -x

# Grant permissions to storage and cache directories
chmod -R gu+w storage/
chmod -R guo+w storage/
chmod -R gu+w bootstrap/cache/
chmod -R guo+w bootstrap/cache/

# Run Composer install
composer install --no-interaction --prefer-dist --optimize-autoloader

# Generate app key
php artisan key:generate

# Generate JWT secret
php artisan jwt:secret

#check permissions
ls -la

# Check if Composer dependencies are installed
if [ ! -f "vendor/autoload.php" ]; then
    echo "Error: Composer dependencies not installed correctly."
    exit 1
fi

# Check PHP configuration
php -m | grep -q 'mysqli' || { echo "Error: PHP extension mysqli not loaded."; exit 1; }
php -m | grep -q 'pdo_mysql' || { echo "Error: PHP extension pdo_mysql not loaded."; exit 1; }

# Check if Apache configuration is loaded
apachectl configtest || { echo "Error: Apache configuration failed."; exit 1; }

echo "Configuration checks passed successfully."

# Start Apache in the foreground
apache2-foreground
