PHP Challenge - REST API

Technology and tools used:
- Git
- PHP 7.2
- MySQL 5.7
- composer
- Symfony 4
- FOSRestBundle
- Docker 
- Postman

How to use the API:
- list products
    - url: http://localhost/api/product
    - type: GET
- list categories
    - url: http://localhost/api/category
    - type: GET
- create a product
    - url: http://localhost/api/product
    - type: POST
    - params:
    {
    "name": "productName",
    "category": "productCategory",
    "sku": "productSku",
    "price": "10.10",
    "quantity": "100"
    }
- retrieve a product
    - url: http://localhost/api/product/{product_id}
    - type: GET
- update a product
    - url: http://localhost/api/product/{product_id}
    - type: PUT
    - params:
    {
        "name": "productName",
        "quantity": "100"
        }
- delete a product
    - url: http://localhost/api/product/{product_id}
    - type: DELETE
