FROM new-living-api-base as new-living-api-prod

WORKDIR /var/www/new-living-api/

ADD . .

COPY ./docker/prod/php.ini $PHP_INI_DIR/conf.d/

COPY ./docker/prod/vhost.conf /etc/apache2/sites-available/new-living-api.conf

RUN a2ensite new-living-api && \
    sed -i 's/80/8080/g' /etc/apache2/sites-available/new-living-api.conf /etc/apache2/ports.conf && \
    a2ensite new-living-api

ENV APP_ENV prod
ENV APP_DEBUG 0

RUN composer install --no-dev --classmap-authoritative && \
    php bin/console cache:warmup --env=prod && \
    chmod -R 777 var/