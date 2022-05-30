<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Orders;

class OrdersController extends Controller
{
    public function orders()
    {
        return Orders::all()->take(100);
    }
}
