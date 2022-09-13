# opbeans-php
PHP backend implementation for Opbeans, Elastic APM demo app

## How to run locally
To run locally, including Server, Kibana and Elasticsearch, use the provided docker compose file by running the commands
```bash
docker-compose up
```

Opbeans web UI is accessible at:
```
http://localhost:8000
```
You can change it by setting `OPBEANS_PHP_HOST` and/or `OPBEANS_PHP_PORT` environment variables.
For example 
```bash
OPBEANS_PHP_HOST=0.0.0.0 OPBEANS_PHP_PORT=9876 docker-compose up
```
will make Opbeans web UI accessible remotely for example
```
http://<my-opbeans-test-VM>:9876
```

*Note*: if you do access Opbeans web UI remotely
you will also need to define `ELASTIC_APM_JS_SERVER_URL` and `APM_SERVER_HOST`
so that RUM-JS (Real User Monitoring JavaScript) Agent can send data to APM Server as well.

For example
```bash
ELASTIC_APM_JS_SERVER_URL="http://my-opbeans-test-vm:8200" APM_SERVER_HOST=0.0.0.0 OPBEANS_PHP_HOST=0.0.0.0 OPBEANS_PHP_PORT=9876 docker-compose up
```

Kibana web UI is accessible at:
```
http://localhost:5601
```
You can change it by setting `KIBANA_HOST` and/or `KIBANA_PORT` environment variables.
For example
```bash
KIBANA_HOST=0.0.0.0 KIBANA_PORT=9877 docker-compose up
```
will make Kibana web UI accessible remotely.

## How to run locally with PostgreSQL

By default, docker containers combination implementing Opbeans-PHP uses MySQL as its database.
You can use the following command line to use PostgreSQL instead:  

```bash
docker-compose --env-file docker-compose_env_for_PostgreSQL.txt -f docker-compose_PostgreSQL.yml -f docker-compose.yml up
```

## How to run locally to demo distributed tracing between backend services

By default, only distributed tracing between the frontend and backend implemented by Opbeans-PHP
is demonstrated.
The following command will run additional backend services
and demonstrate distributed tracing from Opbeans-PHP to those additional backend services:   

```bash
docker-compose --env-file docker-compose_env_for_backend_distributed_tracing.txt -f docker-compose.yml -f docker-compose_backend_distributed_tracing.yml up
```

## How to run locally with custom Elastic APM PHP agent release version

By default, the latest release version of Elastic APM PHP agent is used.
You can use `OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION` environment variable to configure release version of Elastic APM PHP agent to use.
For example:

```bash
OPBEANS_PHP_AGENT_INSTALL_RELEASE_VERSION=1.5 docker-compose up
```

## How to run locally with local Elastic APM PHP agent code instead of a release version

By default, the latest release version of Elastic APM PHP agent is used.
You can use `OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY` and `OPBEANS_PHP_AGENT_INSTALL_LOCAL_SRC` environment variables
with the following command line to use local version of Elastic APM PHP agent.
- `OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY` should point to a compiled PHP extension binary
- `OPBEANS_PHP_AGENT_INSTALL_LOCAL_SRC` should point to `src` directory containing agent's PHP part

For example:

```bash
OPBEANS_PHP_AGENT_INSTALL_LOCAL_EXTENSION_BINARY=/home/user/git/apm-agent-php/src/ext/modules/elastic_apm.so \
OPBEANS_PHP_AGENT_INSTALL_LOCAL_SRC=/home/user/git/apm-agent-php/src \
docker-compose -f docker-compose_local_agent_code.yml -f docker-compose.yml up
```

## How to test locally

The simplest way to test this demo is by running:

```bash
make test
```

Tests are written using [bats](https://github.com/sstephenson/bats) under the tests dir

## How to publish to dockerhub locally

Publish the docker image with

```bash
VERSION=1.2.3 make publish
```

NOTE: VERSION refers to the tag for the docker image which will be published in the registry

## Api-routes list:

1. http://localhost:8000/api/orders - Create order
            
        METHOD:POST

        Body: 
        {
            "customer_id": 3
        }

        Response example:
        {
           "created_at": "2022-06-02",
           "customer_id": 3,
           "id": 50008
       }

2. http://localhost:8000/api/products - Create product

        METHOD:POST

        Body: 
        {
            "sku": "OP-DRC-C1",
            "name": "Marocco roast",
            "description": "Sweet aroma, round body, lively acidity.",
            "stock": 5,
            "cost": 75,
            "selling_price": 90,
            "type_id": 3
        }

        Response example:
        {
             "sku": "OP-DRC-C1",
             "name": "Marocco roast",
             "description": "Sweet aroma, round body, lively acidity.",
             "stock": 5,
             "cost": 75,
             "selling_price": 90,
             "type_id": 3,
             "id": 13
       }

3. http://localhost:8000/api/products/1 - Update product
   
        METHOD:PUT

        Body: 
        {
             "sku": "OP",
             "name": "Marocco roast",
             "description": "Sweet aroma, round body, lively acidity.",
             "stock": 1,
             "cost": 2,
             "selling_price": 3,
             "type_id": 3
        }

        Response example:
        {
             "id": 1,
             "sku": "OP",
             "name": "Marocco roast",
             "description": "Sweet aroma, round body, lively acidity.",
             "stock": 1,
             "cost": 2,
             "selling_price": 3,
             "type_id": 3
       }

4. http://localhost:8000/api/orders/1 - Delete product

        METHOD:DELETE
        Response: 200 Ok
