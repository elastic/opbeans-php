FROM php:8.1-fpm

WORKDIR /var/www

ARG PHP_DB_extension

RUN apt-get update && apt-get install -y \
      apt-utils \
      libpq-dev \
      libpng-dev \
      libzip-dev \
      zip unzip \
      git && \
      docker-php-ext-install ${PHP_DB_extension} && \
      docker-php-ext-install bcmath && \
      docker-php-ext-install gd && \
      docker-php-ext-install zip && \
      apt-get clean && \
      rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

COPY ./_docker/app/php.ini /usr/local/etc/php/conf.d/php.ini

ADD . /var/www/

RUN mkdir -p /usr/bin
RUN mv /var/www/docker-entrypoint.sh /usr/bin/docker-entrypoint.sh
RUN chmod a+x /usr/bin/docker-entrypoint.sh

COPY --from=opbeans/opbeans-frontend:latest /app/build/index.html /var/www/resources/views/page_from_frontend.blade.php

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin
RUN composer install

RUN curl -fsSL https://github.com/elastic/apm-agent-php/releases/download/v1.5/apm-agent-php_1.5_all.deb > /tmp/apm-gent-php.deb \
    && dpkg -i /tmp/apm-gent-php.deb

ENTRYPOINT ["/usr/bin/docker-entrypoint.sh"]
