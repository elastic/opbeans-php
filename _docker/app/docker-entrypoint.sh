#!/usr/bin/env bash
set -xe

php artisan migrate:fresh --seed

php-fpm
