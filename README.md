# opbeans-php
PHP backend implementation for Opbeans, Elastic APM demo app

# Api-routes list:

1. http://localhost:8876/api/orders - Create order
            
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

2. http://localhost:8876/api/products - Create product

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

3. http://localhost:8876/api/products/1 - Update product
   
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

4. http://localhost:8876/api/orders/1 - Delete product

        METHOD:DELETE
        Response: 200 Ok
