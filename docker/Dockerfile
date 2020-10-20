# Docker File
FROM php:7.3-fpm

RUN apt-get update && apt-get install -y git zip unzip \
    && apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev \
    && php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php --install-dir=/usr/local/bin --filename=composer \
    && rm composer-setup.php \
    && docker-php-ext-install opcache \
    && pecl install mongodb apcu && docker-php-ext-enable mongodb apcu opcache

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_12.x | bash
RUN apt-get install --yes nodejs
RUN node -v
RUN npm -v

RUN composer install
RUN npm install