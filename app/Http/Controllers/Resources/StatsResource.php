<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatsResource extends JsonResource
{
    public function toArray($request): array
    {
        $products = $this->get('products');
        $customers = $this->get('customers');
        $orders = $this->get('orders');

        $revenue = 0;
        $cost = 0;
        $profit = 0;

        // Special created problem n+1
        foreach ($products as $product){
            $revenue += $product->orderLines->sum('amount') * $product->selling_price;
            $cost += $product->orderLines->sum('amount') * $product->cost;
            $profit += $product->orderLines->sum('amount') * ($product->selling_price - $product->cost);
        }

        return [
            'products' => $products->count(),
            'customers' => $customers->count(),
            'orders' => $orders->count(),
            "numbers" => [
                "profit" => $profit,
                "revenue" => $revenue,
                "cost" => $cost
            ],
        ];
    }
}
