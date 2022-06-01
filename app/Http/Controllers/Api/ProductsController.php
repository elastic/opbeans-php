<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderLines;
use App\Models\Products;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    public function products(): Collection
    {
        return Products::all();
    }

    public function product($id): Products|Collection
    {
        return Products::findOrFail($id);
    }

    public function customers($id): Collection
    {
        $customers = OrderLines::select()
            ->leftJoin('orders', 'order_lines.order_id', '=', 'orders.id')
            ->leftJoin('customers', 'orders.customer_id', '=', 'customers.id')
            ->where('order_lines.product_id', $id)
            ->get();

        return $customers;
    }

    public function top(): array
    {
        $topProducts = DB::select("
            SELECT products.id as id, products.sku as sku, products.name as name, products.stock as stock, sum(order_lines.amount) as sold
            FROM order_lines
            LEFT JOIN products
            ON order_lines.product_id = products.id
            GROUP BY products.id order by sold desc
        ");

        return $topProducts;
    }
}
