# Use an official PHP image with Apache
FROM php:8.2-apache

# Set the document root
ENV APACHE_DOCUMENT_ROOT /var/www/html/public

# Update the Apache configuration
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install necessary PHP extensions and dependencies
RUN apt-get update && apt-get install -y \
    libcurl4-openssl-dev \
    pkg-config \
    libssl-dev \
    libevent-dev \
    libicu-dev \
    libidn2-0-dev \
    libidn11-dev \
    zlib1g-dev \
    && pecl install raphf \
    && docker-php-ext-enable raphf \
    && pecl install pecl_http \
    && docker-php-ext-enable http \
    && docker-php-ext-install pdo pdo_mysql

# Install Node.js and npm
RUN curl -sL https://deb.nodesource.com/setup_16.x | bash - \
    && apt-get install -y nodejs

# Copy the source code into the container
COPY .. /var/www/html

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install PHP dependencies
RUN composer install

# Install npm dependencies
RUN npm install

# Expose port 80
EXPOSE 80