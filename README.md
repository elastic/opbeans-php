[![Build Status](https://apm-ci.elastic.co/buildStatus/icon?job=apm-agent-php%2Fopbeans-php-mbp%2Fmaster)](https://apm-ci.elastic.co/job/apm-agent-php/job/opbeans-php-mbp/job/master/)
# opbeans-php
PHP backend implementation for Opbeans, Elastic APM demo app

## Makefile

Build the docker image with the usual

    make build

Tests are written using [bats](https://github.com/sstephenson/bats) under the tests dir

    make test

Publish the docker image locally to dockerhub with

    VERSION=v1.2.3 make publish

NOTE: VERSION refers to the tag for the docker image which will be published in the registry
