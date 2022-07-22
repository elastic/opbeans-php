#!/usr/bin/env bash

php artisan migrate:fresh --seed
chown -R www-data:www-data /var/www

php-fpm
