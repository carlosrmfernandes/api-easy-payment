# Dockerfile
FROM php:7.4.1-fpm
# Install Composer

RUN docker-php-ext-install sockets

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer --version=1.9.1

RUN apt-get update \
  && apt-get install -y --no-install-recommends libpq-dev \
  && docker-php-ext-install mysqli pdo_pgsql pdo_mysql

RUN apt-get install -y p7zip \
    p7zip-full \
    unace \
    zip \
    unzip 