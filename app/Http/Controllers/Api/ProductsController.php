<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Products;

class ProductsController extends Controller
{
    public function products()
    {
        return Products::all();
    }

    public function product($id)
    {
        return Products::findOrFail($id);
    }

    public function top()
    {
        return Products::all();
        return '
[
	{
		"name": "Jamaica Blue Mountain, Vienna Roast",
		"id": 2,
		"sold": 113307,
		"sku": "OP-MRC-C2",
		"stock": 0
	},
	{
		"name": "Brazil Verde, Italian Roast",
		"id": 1,
		"sold": 57433,
		"sku": "OP-DRC-C1",
		"stock": 80
	},
	{
		"name": "Colombian Supremo, Cinnamon Roast",
		"id": 3,
		"sold": 57261,
		"sku": "OP-LRC-C3",
		"stock": 150
	}
]
        ';
    }
}
