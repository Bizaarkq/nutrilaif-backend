#!/bin/bash

# Debug: Verify this script has execute permissions
if [ ! -x "$0" ];then
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

# Install Composer dependencies
composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy .env.example to .env if .env does not exist
if [ ! -f .env ]; then
    cp .env.example .env
fi

# Function to set environment variable if it exists
set_env_var() {
    local var_name="$1"
    local env_var="${!var_name}"
    if [ -n "$env_var" ]; then
        sed -i "s|^$var_name=.*|$var_name=${env_var}|g" .env
    fi
}

# List of environment variables to check and set in .env
env_vars=(
    "DB_CONNECTION"
    "DB_HOST"
    "DB_PORT"
    "DB_DATABASE"
    "DB_USERNAME"
    "DB_PASSWORD"
    "LOCALE_ID"
    "LOG_CHANNEL"
    "MAIL_ENCRYPTION"
    "MAIL_FROM_ADDRESS"
    "MAIL_FROM_NAME"
    "MAIL_HOST"
    "MAIL_MAILER"
    "MAIL_PASSWORD"
    "MAIL_PORT"
    "MAIL_USERNAME"
)

# Loop through each environment variable and set it if it exists
for var in "${env_vars[@]}"; do
    set_env_var "$var"
done

# Generate APP_KEY if not set
php artisan key:generate

# Generate JWT secret if not set
php artisan jwt:secret

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

# do request to the server to check if it is up every sixty seconds
while true; do
    curl -s https://nutrilaif-backend-573v.onrender.com/ > /dev/null
    if [ $? -eq 0 ]; then
        break
    fi
    sleep 60
done

# Start Apache in the foreground
apache2-foreground
