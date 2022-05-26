<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;

class ProductsController extends Controller
{
    public function products()
    {
        return '
          [  {
	"name": "Brazil Verde, Italian Roast",
	"type_name": "Dark Roast Coffee",
	"id": 1,
	"sold": 57433,
	"type_id": 3,
	"sku": "OP-DRC-C1",
	"selling_price": 3200,
	"stock": 80,
	"cost": 1500,
	"description": "Soft, nutty, low acid, with nice bitter-sweet chocolate tastes."
}]
        ';
    }

    public function product()
    {
        return '
            {
	"name": "Brazil Verde, Italian Roast",
	"type_name": "Dark Roast Coffee",
	"id": 1,
	"sold": 57433,
	"type_id": 3,
	"sku": "OP-DRC-C1",
	"selling_price": 3200,
	"stock": 80,
	"cost": 1500,
	"description": "Soft, nutty, low acid, with nice bitter-sweet chocolate tastes."
}
        ';
    }
}
