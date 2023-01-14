FROM new-living-base as new-living-prod

WORKDIR /var/www/new-living/

ENV APP_ENV prod
ENV APP_DEBUG 0

COPY ./docker/prod/php.ini $PHP_INI_DIR/conf.d/

COPY ./docker/prod/vhost.conf /etc/apache2/sites-available/new-living.conf

RUN a2ensite new-living && \
    sed -i 's/80/8080/g' /etc/apache2/sites-available/new-living.conf /etc/apache2/ports.conf && \
    a2ensite new-living

COPY . .

RUN composer install --no-dev --classmap-authoritative && \
    php bin/console cache:warmup --env=prod && \
    chmod -R 777 var/