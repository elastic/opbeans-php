# opbeans-php
PHP backend implementation for Opbeans, Elastic APM demo app

## How to run locally
To run locally, including Server, Kibana and Elasticsearch, use the provided docker compose file by running the commands
```bash
docker-compose up
```

Opbeans-PHP web UI is accessible at:
```
http://localhost:8000
```
You can change it by setting `OPBEANS_PHP_HOST` and/or `OPBEANS_PHP_PORT` environment variables.
For example 
```bash
OPBEANS_PHP_HOST=0.0.0.0 OPBEANS_PHP_PORT=9876 docker-compose up
```
will make Opbeans-PHP web UI accessible remotely for example
```
http://<my-opbeans-test-VM>:9876
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
will make Opbeans-PHP web UI accessible remotely for example
```
http://<my-opbeans-test-VM>:9877
```

## How to run locally with PostgreSQL as database instead of MySQL

```bash
docker-compose --env-file docker-compose_env_for_PostgreSQL.txt up
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
