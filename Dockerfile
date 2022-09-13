FROM webdevops/php-nginx:8.2

ARG OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY=""
ENV OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY="$OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY"
ARG OPBEANS_PHP_AGENT_INSTALL_LOCAL_SRC=""
ENV OPBEANS_PHP_AGENT_INSTALL_LOCAL_SRC="$OPBEANS_PHP_AGENT_INSTALL_LOCAL_SRC"
ARG OPBEANS_PHP_AGENT_INSTALL_PACKAGE_FROM_URL=""
ENV OPBEANS_PHP_AGENT_INSTALL_PACKAGE_FROM_URL="$OPBEANS_PHP_AGENT_INSTALL_PACKAGE_FROM_URL"
ARG OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION=""
ENV OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION="$OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION"

RUN echo "OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY: $OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY"
RUN OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY=$OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY echo "OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY: $OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY"

#
# Replace port in "listen 80 default_server;" and "listen [::]:80 default_server;"
#
RUN cp /opt/docker/etc/nginx/vhost.conf /tmp/opt_docker_etc_nginx_vhost.conf_before_port_replace && \
    sed 's|listen 80 default_server;|listen 3000 default_server;|' /tmp/opt_docker_etc_nginx_vhost.conf_before_port_replace | \
        sed 's|listen \[::\]:80 default_server;|listen [::]:3000 default_server;|' > /opt/docker/etc/nginx/vhost.conf

COPY --from=opbeans/opbeans-frontend:latest /app/build  /app/public
#
COPY --from=opbeans/opbeans-frontend:latest /app/package.json /app/package.json

ADD . /app

COPY --from=opbeans/opbeans-frontend:latest /app/build/index.html /app/resources/views/page_from_frontend.blade.php

# Install composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN curl -sS https://getcomposer.org/installer | php -- \
    --filename=composer \
    --install-dir=/usr/local/bin

RUN composer install -d /app

RUN chown -R www-data:www-data /app

RUN chmod -R 777 /app

RUN /app/install_agent.sh

WORKDIR /app

ENV WEB_DOCUMENT_ROOT=/app/public/
ENTRYPOINT ["/app/docker_entrypoint_one_container.sh"]
CMD ["supervisord"]
