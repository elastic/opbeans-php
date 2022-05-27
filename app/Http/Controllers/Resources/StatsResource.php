<?php

namespace App\Http\Controllers\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StatsResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'products' => $this->get('products_count'),
            'customers' => $this->get('customers_count'),
            'orders' => $this->get('orders_count'),
            "numbers" => [
                "profit" => 2717097200,
                "revenue" => 5184667700,
                "cost" => 2467570500
            ],
        ];
    }
}
