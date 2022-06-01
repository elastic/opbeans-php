<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customers;
use App\Models\Orders;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class OrdersController extends Controller
{
    public function orders(): Collection
    {
        return Orders::select('customers.full_name as customer_name', 'orders.*')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->take(100)
            ->get();
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
