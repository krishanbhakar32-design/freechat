FROM php:8.2-apache

# Install PostgreSQL drivers
RUN apt-get update && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

# Copy your files
COPY . /var/www/html/

# Port for Render
EXPOSE 80
