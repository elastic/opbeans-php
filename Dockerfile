ARG PHP_VERSION=7.4
FROM php:${PHP_VERSION}-apache

# install all the system dependencies and enable PHP modules
RUN apt-get update && apt-get install -qq -y \
  libicu-dev \
  libmcrypt-dev \
  libpq-dev \
  libpng-dev \
  git \
  unzip \
  zip \
  && rm -r /var/lib/apt/lists/*

RUN docker-php-ext-configure pdo_mysql --with-pdo-mysql=mysqlnd \
  && docker-php-ext-install \
  gd \
  intl \
  mcrypt \
  mbstring \
  pcntl \
  opcache \
  pdo_mysql \
  pdo_pgsql \
  pgsql \
  zip

# install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/bin/ --filename=composer

# set our application folder as an environment variable
ENV APP_HOME /var/www/html

# change uid and gid of apache to docker user uid/gid
RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

# enable Apache module rewrite
RUN a2enmod rewrite
RUN a2enmod ssl
RUN a2enmod headers

# Apache configs + document root
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# mod_rewrite for URL rewrite and mod_headers for .htaccess extra headers like Access-Control-Allow-Origin-
RUN a2enmod rewrite headers

# copy source files
COPY . $APP_HOME

# install all PHP dependencies
RUN composer install --no-interaction

# change ownership of our applications
RUN chown -R www-data:www-data $APP_HOME
