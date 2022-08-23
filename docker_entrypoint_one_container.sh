#!/usr/bin/env bash

cp /opt/docker/etc/nginx/vhost.conf /tmp/opt_docker_etc_nginx_vhost.conf_before_port_replace
# Replace port in "listen 80 default_server;" and "listen [::]:80 default_server;"
sed 's|listen 80 default_server;|listen 3000 default_server;|' /tmp/opt_docker_etc_nginx_vhost.conf_before_port_replace | \
    sed 's|listen \[::\]:80 default_server;|listen [::]:3000 default_server;|' > /opt/docker/etc/nginx/vhost.conf

php artisan migrate:fresh --seed

/entrypoint "supervisord"
