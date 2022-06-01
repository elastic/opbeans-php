<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Orders;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class OrdersController extends Controller
{
    public function orders(): Collection
    {
        return Orders::all()->take(100);
    }

    public function order($id): Orders
    {
        return Orders::findOrFail($id);
    }

    public function createOrder(Request $request)
    {
        $customer = Customers::findOrFail($request->get('customer_id'));
//        $customer->orders->save(['created_at' => "2017-06-07 12:16:13.655000"]);
        $order = Orders::create(['created_at' => "2017-06-07 12:16:13.655000", 'customer_id' => 3]);
        dd('createOrder', $request);
    }
}
