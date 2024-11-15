# Use the base PHP FPM image
FROM php:8.3-fpm

# Install required dependencies
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    git \
    curl

# Install pdo_mysql extension
RUN docker-php-ext-install pdo_mysql

# Install other useful extensions if needed (e.g., gd, intl)
RUN docker-php-ext-install gd

# Clean up
RUN apt-get clean && rm -rf /var/lib/apt/lists/*
