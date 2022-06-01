<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Orders;
use Carbon\Carbon;
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

        $order = Orders::create([
            'created_at' => Carbon::now()->format('Y-m-d'),
            'customer_id' => $customer->id
        ]);

        return $order;
    }
}
