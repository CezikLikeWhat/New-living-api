FROM new-living-base as new-living-dev

COPY ./docker/dev/php.ini $PHP_INI_DIR/conf.d/
COPY ./docker/dev/vhost.conf /etc/apache2/sites-available/new-living.conf

RUN a2ensite new-living
