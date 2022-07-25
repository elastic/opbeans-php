#!/usr/bin/env bash

php artisan migrate:fresh --seed

/entrypoint "supervisord"
