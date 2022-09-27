FROM new-living-api-base as new-living-api-dev

WORKDIR /var/www/new-living-api/

COPY ./docker/dev/php.ini $PHP_INI_DIR/conf.d/
COPY ./docker/dev/vhost.conf /etc/apache2/sites-available/new-living-api.conf

RUN a2ensite new-living-api
