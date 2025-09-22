FROM php:8.2-fpm

# Install librdkafka dependency
RUN apt-get update && apt-get install -y librdkafka-dev

# Install php-rdkafka extension
RUN pecl install rdkafka \
    && docker-php-ext-enable rdkafka

# Install dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    curl \
    git \
    nano \
    libzip-dev \
    libpq-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring zip exif pcntl bcmath gd

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy app code
COPY . /var/www

# Set permissions
RUN chown -R www-data:www-data /var/www

EXPOSE 9000

# Start PHP-FPM
CMD ["php-fpm"]
