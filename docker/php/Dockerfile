FROM php:8.2-fpm

COPY composer.lock composer.json /var/www/
WORKDIR /var/www

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN usermod -u 1000 www-data
COPY --chown=www-data:www-data . /var/www
USER www-data

EXPOSE 9000
CMD ["php-fpm"]