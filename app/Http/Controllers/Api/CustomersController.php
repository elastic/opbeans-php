<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Resources\StatsResource;
use App\Models\Customers;
use App\Models\OrderLines;
use App\Models\Orders;
use App\Models\Products;

class CustomersController extends Controller
{
    public function stats()
    {
        return (new StatsResource(collect([
            'products' => Products::all(),
            'customers' => Customers::all(),
            'orders' => Orders::all(),
            'orderLines' => OrderLines::all(),
        ])))->jsonSerialize();
    }

    protected function customers()
    {
        return Customers::all()->take(100);
    }
}
