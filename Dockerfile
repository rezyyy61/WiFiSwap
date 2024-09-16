FROM php:8.3-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    git \
    unzip \
    libonig-dev \
    libxml2-dev \
    curl \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd \
    && docker-php-ext-install mysqli \
    && docker-php-ext-install pdo pdo_mysql \
    && docker-php-ext-install bcmath \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache

# Set the working directory inside the container
WORKDIR /var/www

# Copy the current directory contents into the container at /var/www
COPY . /var/www

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Expose port 9000 and start PHP-FPM server
EXPOSE 9000
CMD ["php-fpm"]

# Add a health check to ensure the PHP service is running
HEALTHCHECK --interval=30s --timeout=10s \
  CMD curl --silent --fail http://localhost:9000 || exit 1

# Fix permissions
RUN chown -R www-data:www-data /var/www/storage /var/www/bootstrap/cache \
    && chmod -R 775 /var/www/storage /var/www/bootstrap/cache


