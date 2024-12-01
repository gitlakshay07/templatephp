FROM php:8.1.13-apache

# INSTALL ZIP TO USE COMPOSER
RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    && docker-php-ext-install zip pdo_mysql mysqli

RUN a2enmod rewrite

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer



WORKDIR /var/www/html
COPY ./form .

CMD ["sh", "-c", "composer install && apache2ctl -D FOREGROUND"]