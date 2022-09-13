#!/usr/bin/env bash

set -xe

OPBEANS_PHP_AGENT_DEFAULT_RELEASE_VERSION_TO_INSTALL=1.6.1

install_local_code () {
    cat /app/local_agent_code_php.ini
    ln -s /app/local_agent_code_php.ini /usr/local/etc/php/conf.d/98-elastic-apm.ini
}

install_local_package_from_url () {
    package_url="$1"
    curl -fsSL "${package_url}" > /tmp/apm-gent-php.deb
    dpkg -i /tmp/apm-gent-php.deb
}

main () {
    set | grep ELASTIC || true

    if [ -n "${OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY}" ]; then
        echo "Installing agent using local code (OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY: ${OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY}) ..."
        install_local_code
        return
    fi

    if [ -n "${OPBEANS_PHP_AGENT_INSTALL_PACKAGE_FROM_URL}" ]; then
        echo "Installing agent using package from url (OPBEANS_PHP_AGENT_INSTALL_PACKAGE_FROM_URL: ${OPBEANS_PHP_AGENT_INSTALL_PACKAGE_FROM_URL}) ..."
        install_local_package_from_url "${OPBEANS_PHP_AGENT_INSTALL_PACKAGE_FROM_URL}"
        return
    fi

    agent_version="${OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION:-${OPBEANS_PHP_AGENT_DEFAULT_RELEASE_VERSION_TO_INSTALL}}"
    echo "Installing agent using release version ${agent_version} (OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION: ${OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION})..."
    install_local_package_from_url "https://github.com/elastic/apm-agent-php/releases/download/v${agent_version}/apm-agent-php_${agent_version}_all.deb"
}

main
