FROM php:8.1.9-apache-bullseye as new-living-base

WORKDIR /var/www/new-living/

RUN a2enmod rewrite && \
    apt-get -y update && \
    apt-get -y --no-install-recommends install git \
                                               curl \
                                               bash \
                                               unzip \
                                               libpq-dev \
                                               libzip-dev \
                                               libxslt-dev \
                                               librabbitmq-dev && \
    apt-get clean && \
    rm -rf /var/lib/apt/lists/* && \
    docker-php-ext-install zip \
                           pdo \
                           xsl \
                           opcache \
                           pdo_pgsql && \
    pecl install amqp

COPY --from=composer:2.4.0 /usr/bin/composer /usr/bin/composer

