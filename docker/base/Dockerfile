FROM php:8.1.9-apache-buster as new-living-base

WORKDIR /var/www/new-living/

RUN a2enmod rewrite && \
    apt-get -y update && \
    apt-get -y upgrade && \
    apt-get -y install git bash libzip-dev unzip curl libpq-dev libxslt-dev librabbitmq-dev && \
    docker-php-ext-install opcache zip pdo pdo_pgsql xsl && \
    pecl install amqp

COPY --from=composer:2.4.0 /usr/bin/composer /usr/bin/composer
