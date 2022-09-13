#!/usr/bin/env bash

set -xe

if [ -n "${OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY}" ]; then
    ls -l /Elastic_APM_PHP_agent_local_code/elastic_apm.so
    ls -l /Elastic_APM_PHP_agent_local_code/src/bootstrap_php_part.php
fi

php artisan migrate:fresh --seed

/entrypoint "supervisord"
