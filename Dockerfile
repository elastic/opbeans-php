FROM php:7.4-apache

RUN apt-get -qq update \
 && apt-get -qq install -y --no-install-recommends \
    autoconf \
    build-essential \
    curl \
    git \
    libcurl4-openssl-dev \
    wget \
 && rm -rf /var/lib/apt/lists/*

COPY . /src/
WORKDIR /src
RUN wget -q "https://github.com/elastic/apm-agent-php/releases/download/v1.0.0/apm-agent-php_1.0.0_all.deb" \
     -O "/tmp/apm-agent-php.deb" \
 && dpkg -i "/tmp/apm-agent-php.deb"

LABEL \
    org.label-schema.schema-version="1.0" \
    org.label-schema.vendor="Elastic" \
    org.label-schema.name="opbeans-php" \
    org.label-schema.version="1.8.0" \
    org.label-schema.url="https://hub.docker.com/r/opbeans/opbeans-php" \
    org.label-schema.vcs-url="https://github.com/elastic/opbeans-php" \
    org.label-schema.license="MIT"

#EXPOSE 80
#ENTRYPOINT TBD
