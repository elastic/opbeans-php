<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Resources\StatsResource;
use App\Models\Customers;
use App\Models\Orders;
use App\Models\Products;

class CustomersController extends Controller
{
    public function stats()
    {
        return (new StatsResource(collect([
            'products_count' => Products::count(),
            'customers_count' => Customers::count(),
            'orders_count' => Orders::count()
        ])))->jsonSerialize();
    }
}
