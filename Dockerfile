# Stage 1: Builder (Composer + Vendor install)
FROM php:8.2-fpm AS build

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev libcurl4-openssl-dev pkg-config \
    libfreetype6-dev libjpeg62-turbo-dev zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl bcmath gd intl

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

# Copy composer files and install dependencies
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-interaction --no-scripts --prefer-dist --optimize-autoloader

# Copy the rest of the app
COPY . .

# Stage 2: Production (Nginx + PHP-FPM)
FROM php:8.2-fpm

# Install Nginx and system dependencies
RUN apt-get update && apt-get install -y nginx \
    libzip-dev libpng-dev libonig-dev libxml2-dev libicu-dev libcurl4-openssl-dev pkg-config \
    libfreetype6-dev libjpeg62-turbo-dev zlib1g-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql zip exif pcntl bcmath gd intl

WORKDIR /var/www

# Copy app from build stage
COPY --from=build /var/www /var/www

# Copy custom Nginx config
COPY ./nginx/default.conf /etc/nginx/conf.d/default.conf

# Permissions
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Environment port from Railway
ENV PORT=8080
EXPOSE 8080

# Start Nginx and PHP-FPM together
CMD service nginx start && php-fpm
